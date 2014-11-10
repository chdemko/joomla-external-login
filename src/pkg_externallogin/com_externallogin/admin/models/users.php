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
 * Servers Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
 */
class ExternalloginModelUsers extends JModelList
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
	protected $filter_fields = array('a.id', 'a.username', 'a.name', 'a.email', 's.title', 'e.ordering');

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

		$external = $this->getUserStateFromRequest($this->context.'.filter.external', 'filter_external', '');
		$this->setState('filter.external', $external);

		$joomla = $this->getUserStateFromRequest($this->context.'.filter.joomla', 'filter_joomla', '');
		$this->setState('filter.joomla', $joomla);

		$server = $this->getUserStateFromRequest($this->context.'.filter.server', 'filter_server', '');
		$this->setState('filter.server', $server);

		$plugin = $this->getUserStateFromRequest($this->context.'.filter.plugin', 'filter_plugin', '');
		$this->setState('filter.plugin', $plugin);

		// List state information.
		parent::populateState('a.username', 'asc');
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
		$query->select('a.*');
		$query->select('a.password <> ' . $db->quote('') . ' AS joomla');

		// From the users table
		$query->from($db->quoteName('#__users') . ' as a');
		
		// Join over the externallogin_users
		$query->join('LEFT', '#__externallogin_users AS u ON a.id=u.user_id');
		$query->join('LEFT', '#__externallogin_servers AS s ON u.server_id=s.id');
		$query->select('s.title');
		$query->select('s.published');
		$query->select('s.plugin');

		// Join over the extensions for enabled plugins.
		$query->join('LEFT', '#__extensions AS e ON ' .
			$db->quoteName('e.type') . '=' . $db->quote('plugin') . ' AND ' .
			$query->concatenate(array($db->quoteName('e.folder'), $db->quoteName('e.element')), '.') . '=' . $db->quoteName('s.plugin')
		);
		$query->select('e.enabled AS enabled');

		// Filter by enabled state
		$enabled = $this->getState('filter.enabled');
		if ($enabled !== null)
		{
			$query->where('e.enabled = ' . (int) $enabled);
		}

		// Filter by external state
		$external = $this->getState('filter.external');
		if (is_numeric($external))
		{
			if ($external == 0)
			{
				$query->where('s.plugin IS NULL');
			}
			else
			{
				$query->where('s.plugin IS NOT NULL');
			}
		}

		// Filter by Joomla! state
		$joomla = $this->getState('filter.joomla');
		if (is_numeric($joomla))
		{
			if ($joomla == 0)
			{
				$query->where('a.password = ' . $db->quote(''));
			}
			else
			{
				$query->where('a.password <> ' . $db->quote(''));
			}
		}

		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = '. (int) substr($search, 3));
			}
			else
			{
				// Escape the search token.
				$token	= $db->Quote('%'.$db->escape($search).'%');

				// Compile the different search clauses.
				$searches	= array();
				$searches[]	= 'a.name LIKE '.$token;
				$searches[]	= 'a.username LIKE '.$token;
				$searches[]	= 'a.email LIKE '.$token;

				// Add the clauses to the query.
				$query->where('('.implode(' OR ', $searches).')');
			}
		}

		// Filter by plugin
		$plugin = $this->getState('filter.plugin');
		if (!empty($plugin))
		{
			$query->where('s.plugin = ' . $db->quote($plugin));
		}

		// Filter by server
		$server = $this->getState('filter.server');
		if (!empty($server))
		{
			$query->where('s.id = ' . (int)$server);
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		switch ($orderCol)
		{
			case 'e.ordering':
				$query->order($db->escape('e.ordering ' . $orderDirn));
				$query->order($db->escape('a.username ASC'));
			break;
			default:
				$query->order($db->escape($orderCol.' '.$orderDirn));
			break;
		}

		return $query;
	}
}
