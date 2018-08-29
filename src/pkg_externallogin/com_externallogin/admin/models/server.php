<?php

/**
 * @package     External_Login
 * @subpackage  Component
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;

// Import Joomla modeladmin library
jimport('joomla.application.component.modeladmin');

/**
 * Server Model of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.0.0
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
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
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

			if (version_compare(JVERSION, '3.7.0', '>=')
				&& property_exists($data, 'params')
				&& isset($data->params['data']))
			{
				$registry = new JRegistry($data->params['data']);
				$data->params = $registry->toArray();
			}
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
	 * @param   array  $pks  An array of record primary keys.
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
	 *
	 * @param   JForm  $form  Form
	 *
	 * @return  boolean  True on success
	 */
	public function upload($form)
	{
		$files = JFactory::getApplication()->input->files->get('jform', null, 'array');
		$sid = (int) $form['id'];

		if ($files['file']['type'] == 'text/csv')
		{
			$handle = fopen($files['file']['tmp_name'], "r");

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
							$user->groups = array_merge((array) $user->groups, (array) ExternalloginHelper::getGroups($group));
						}
					}

					if ($user->save())
					{
						$query = $this->_db->getQuery(true);
						$query->select('user_id');
						$query->from('#__externallogin_users');
						$query->where('user_id = ' . (int) $user->id);
						$this->_db->setQuery($query);

						$query = $this->_db->getQuery(true);
						$query->set('server_id = ' . (int) $sid);

						if ($this->_db->loadResult())
						{
							$query->update('#__externallogin_users');
							$query->where('user_id = ' . (int) $user->id);
						}
						else
						{
							$query->insert('#__externallogin_users');
							$query->set('user_id = ' . (int) $user->id);
						}

						$this->_db->setQuery($query);
						$this->_db->execute();
					}
				}
			}
			while ($data);

			fclose($handle);

			return true;
		}
		else
		{
			$this->setError(JText::_('COM_EXTERNALLOGIN_ERROR_BAD_FILE'));

			return false;
		}
	}
}
