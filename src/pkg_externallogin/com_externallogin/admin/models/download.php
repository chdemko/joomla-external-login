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

// import the Joomla model library
jimport('joomla.application.component.model');

/**
 * Download Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
 */
class ExternalloginModelDownload extends JModelLegacy
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * @return  void
	 *
	 * @note  Calling getState in this method will result in recursion.
	 *
	 * @see  JModel::populateState
	 *
	 * @since  2.0.0
	 */
	protected function populateState()
	{
		// Get the pk of the record from the request.
		$pk = JFactory::getApplication()->input->getInt('id');
		$this->setState($this->getName() . '.id', $pk);
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
	 * Get file name
	 *
	 * @return	string	The file name
	 * @since	1.6
	 */
	public function getBaseName()
	{
		$table = $this->getTable();
		if ($table->load($this->getState($this->getName() . '.id')))
		{
			return JFactory::getConfig()->get('sitename') . '_' . $table->title . '_' . JFactory::getDate();
		}
		else
		{
			$this->setError(JText::_('COM_EXTERNALLOGIN_ERROR_CANNOT_DOWNLOAD'));
			return false;
		}
	}

	/**
	 * Get the content
	 *
	 * @return	string	The content.
	 * @since	1.6
	 */
	public function getContent()
	{
		$file = fopen('php://output', 'w');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.username, a.name, a.email');
		$query->from('#__users AS a');
		$query->leftJoin('#__externallogin_users AS e ON e.user_id = a.id');
		$query->where('e.server_id = ' . (int) $this->getState($this->getName() . '.id'));
		$query->leftJoin('#__user_usergroup_map AS g ON g.user_id = a.id');
		$query->group('a.id');
		$query->select('GROUP_CONCAT(g.group_id SEPARATOR ",")');
		$db->setQuery($query);
		$results = $db->loadRowList();
		foreach ($results as $result)
		{
			fputcsv($file, $result);
		}
		fclose($file);
	}
}
