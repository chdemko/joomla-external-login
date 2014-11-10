<?php

/**
 * @package     External Login
 * @subpackage  Component
 * @copyright   Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

// import Joomla modeladmin library
jimport('joomla.application.component.modeladmin');

/**
 * Server Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since	2.0.0
 */
class ExternalloginModelServer extends JModelAdmin
{
	/**
	 * Stock method to auto-populate the model state.
	 *
	 * @return  void
	 *
	 * @since   2.0.0
	 */
	protected function populateState()
	{
		parent::populateState();

		// Get the plugin from the request.
		$plugin = JFactory::getApplication()->input->get('plugin');
		$this->setState($this->getName() . '.plugin', $plugin);
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   string  $type   The table type to instantiate
	 * @param   string  $prefix A prefix for the table class name. Optional.
	 * @param   array   $config Configuration array for model. Optional.
	 *
	 * @return	JTable  A database object
	 *
	 * @see     JModel::getTable
	 *
	 * @since	2.0.0
	 */
	public function getTable($type = 'Server', $prefix = 'ExternalloginTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed	A JForm object on success, false on failure
	 *
	 * @see    JModelForm::getForm
	 *
	 * @since  2.0.0
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$plugin = isset($data['plugin']) ? $data['plugin'] : $this->getState($this->getName() . '.plugin');
		if (empty($plugin))
		{
			$item = $this->getItem();
			$plugin = $item->plugin;
		}
		$form = $this->loadForm('com_externallogin.server.' . $plugin, 'server', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 *
	 * @since  2.0.0
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_externallogin.edit.server.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		if (is_object($data) && empty($data->plugin))
		{
			$data->plugin = $this->getState($this->getName() . '.plugin');
		}
        elseif (is_array($data) && empty($data['plugin']))
        {
            $data['plugin'] = $this->getState($this->getName() . '.plugin');
        }
		return $data;
	}

	/**
	 * Method to delete one or more records.
	 *
	 * @param   array  &$pks  An array of record primary keys.
	 *
	 * @return  boolean  True if successful, false if an error occurs.
	 *
	 * @since   11.1
	 */
	public function delete(&$pks)
	{
		if (parent::delete($pks))
		{
			if (!empty($pks))
			{
				JArrayHelper::toInteger($pks);
				$query = $this->_db->getQuery(true);
				$query->delete();
				$query->from('#__externallogin_users');
				$query->where('server_id IN (' . implode(',', $pks) . ')');
				$this->_db->setQuery($query)->execute();
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Upload users
	 */
	public function upload($form)
	{
		// TODO To be replaced by JInput (buggy at that time)
		$files = JRequest::getVar('jform', null, 'files', 'array');
		$sid = (int)$form['id'];
		if ($files['type']['file'] == 'text/csv')
		{
			$handle = fopen($files['tmp_name']['file'], "r");
			do
			{
				$data = fgetcsv($handle);
				if ($data && count($data) == 4)
				{
					$user = JUser::getInstance();
					if ($id = intval(JUserHelper::getUserId($data[0])))
					{
						$user->load($id);
					}
					$user->username = $data[0];
					$user->name = $data[1];
					$user->email = $data[2];
					$user->groups = array();
					$groups = explode(',', $data[3]);
					foreach ($groups as $group)
					{
						if (is_numeric($group))
						{
							$user->groups[] = intval($group);
						}
						else
						{
							$user->groups = array_merge((array)$user->groups, (array) ExternalloginHelper::getGroups($group));
						}
					}
					if ($user->save())
					{
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->insert('#__externallogin_users')->columns('server_id, user_id')->values((int) $sid . ',' . (int) $user->id);
						$db->setQuery($query);
						$db->execute();
					}
				}
			} while ($data);
			fclose($handle);
			return true;
		}
		else
		{
			$this->setError('COM_EXTERNALLOGIN_ERROR_BAD_FILE');
			return false;
		}
	}
}
