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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * Logs Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
 */
class ExternalloginModelLogs extends JModelList
{
	/**
	 * Valid filter fields or ordering.
	 *
	 * @var  array
	 *
	 * @see  JModelList::$filter_fields
	 *
	 * @since  2.1.0
	 */
	protected $filter_fields = array('a.message', 'a.priority', 'a.category', 'a.date');

	/**
	 * Method to auto-populate the model state.
	 *
	 * @return  void
	 *
	 * @note  Calling getState in this method will result in recursion.
	 *
	 * @see  JModelList::populateState
	 *
	 * @since  2.1.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Adjust the context to support modal layouts.
		if ($layout = JFactory::getApplication()->input->get('layout')) {
			$this->context .= '.'.$layout;
		}

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$priority = $this->getUserStateFromRequest($this->context.'.filter.priority', 'filter_priority', '');
		$this->setState('filter.priority', $priority);

		$category = $this->getUserStateFromRequest($this->context.'.filter.category', 'filter_category', '');
		$this->setState('filter.category', $category);

		$begin = $this->getUserStateFromRequest($this->context.'.filter.begin', 'filter_begin', '');
		$this->setState('filter.begin', $begin);

		$end = $this->getUserStateFromRequest($this->context.'.filter.end', 'filter_end', '');
		$this->setState('filter.end', $end);

		// List state information.
		parent::populateState('a.date', 'desc');
	}

	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  object  A JDatabaseQuery object to retrieve the data set.
	 *
	 * @see  JModelList::getListQuery
	 *
	 * @since  2.1.0 
	 */
	protected function getListQuery() 
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// Select some fields
		$query->select('a.priority, a.category, a.date, a.message');

		// From the externallogin_servers table
		$query->from($db->quoteName('#__externallogin_logs') . ' as a');
		
		// Filter by search in message.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('a.message LIKE ' . $search);
		}

		// Filter by category
		$category = $this->getState('filter.category');
		if (!empty($category))
		{
			$query->where('a.category = ' . $db->quote($category));
		}

		// Filter by priority
		$priority = $this->getState('filter.priority');
		if (is_numeric($priority))
		{
			$query->where('a.priority = ' . (int)$priority);
		}

		// Filter by begin date
		$begin = $this->getState('filter.begin');
		if (!empty($begin))
		{
			$begin = JFactory::getDate($begin);
			$query->where('a.date >= ' . $db->quote($begin->toUnix()));
		}

		// Filter by end date
		$end = $this->getState('filter.end');
		if (!empty($end))
		{
			$end = JFactory::getDate($end);
			$query->where('a.date < ' . $db->quote($end->toUnix() + 24*60*60));
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		$query->order($db->escape($orderCol.' '.$orderDirn));

		return $query;
	}


	/**
	 * Get file name
	 *
	 * @return	string	The file name
	 * @since	2.1.0
	 */
	public function getBaseName()
	{
		return JFactory::getConfig()->get('sitename') . '_externallogin-logs_' . JFactory::getDate();
	}

	/**
	 * Get the content
	 *
	 * @return	string	The content.
	 * @since	2.1.0
	 */
	public function getContent()
	{
		$file = fopen('php://output', 'w');
		$db = JFactory::getDbo();
		$db->setQuery($this->getListQuery());
		$results = $db->loadAssocList();
		foreach ($results as $result)
		{
			$result['priority'] = JText::_('COM_EXTERNALLOGIN_GRID_LOG_PRIORITY_' . $result['priority']);
			list($time, $microtime) = explode('.', $result['date']);
			$result['date'] = date('Y-m-d H:i:s', $time) . '.' . $microtime;
			fputcsv($file, $result);
		}
		fclose($file);
	}

	/**
	 * Delete items
	 *
	 * @return	boolean	 TRUE on success, FALSE on failure.
	 * @since	2.1.0
	 */
	public function delete()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// Delete
		$query->delete();

		// From the externallogin_servers table
		$query->from($db->quoteName('#__externallogin_logs'));
		
		// Filter by search in message.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('message LIKE ' . $search);
		}

		// Filter by category
		$category = $this->getState('filter.category');
		if (!empty($category))
		{
			$query->where('category = ' . $db->quote($category));
		}

		// Filter by priority
		$priority = $this->getState('filter.priority');
		if (is_numeric($priority))
		{
			$query->where('priority = ' . (int)$priority);
		}

		// Filter by begin date
		$begin = $this->getState('filter.begin');
		if (!empty($begin))
		{
			$begin = JFactory::getDate($begin);
			$query->where('date >= ' . $db->quote($begin->toUnix()));
		}

		// Filter by end date
		$end = $this->getState('filter.end');
		if (!empty($end))
		{
			$end = JFactory::getDate($end);
			$query->where('date < ' . $db->quote($end->toUnix() + 24*60*60));
		}

		$db->setQuery($query);

		try
		{
			$db->execute();
			$app = JFactory::getApplication();
			$app->setUserState($this->context.'.filter.search', '');
			$app->setUserState($this->context.'.filter.priority', '');
			$app->setUserState($this->context.'.filter.category', '');
			$app->setUserState($this->context.'.filter.begin', '');
			$app->setUserState($this->context.'.filter.end', '');
			$app->enqueueMessage(JText::_('COM_EXTERNALLOGIN_MSG_LOGS_FILTER_RESET'), 'notice');
			return true;
		}
		catch (JDatabaseException $e)
		{
			$this->setError($e->getMessage());
			return false;
		}
	}
}
