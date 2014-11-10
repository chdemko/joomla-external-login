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

/**
 * External Login component helper.
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
 */
abstract class ExternalloginHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param  string  $submenu  the name of the current submenu
	 *
	 * @return  void
	 *
	 * @since  0.0.1
	 */
	public static function addSubmenu($submenu = 'servers') 
	{
		// Addsubmenu
		JSubMenuHelper::addEntry(JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), JRoute::_('index.php?option=com_externallogin', false), $submenu == 'servers');
		JSubMenuHelper::addEntry(JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), JRoute::_('index.php?option=com_externallogin&view=users', false), $submenu == 'users');
		JSubMenuHelper::addEntry(JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), JRoute::_('index.php?option=com_externallogin&view=logs', false), $submenu == 'logs');
		JSubMenuHelper::addEntry(JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), JRoute::_('index.php?option=com_externallogin&view=about', false), $submenu == 'about');

		// set some global property
		$document = JFactory::getDocument();
		$document->setTitle(JText::sprintf('COM_EXTERNALLOGIN_PAGETITLE', JFactory::getConfig()->get('sitename'), JText::_('COM_EXTERNALLOGIN_PAGETITLE_' . $submenu)));
	}

	/**
	 * Get a list of enabled plugins
	 *
	 * @return  array  array of plugins
	 *
	 * @since  2.0.0
	 */
	public static function getPlugins()
	{
		$app = JFactory::getApplication();
		return (array) $app->triggerEvent('onGetOption', array('com_externallogin'));
	}

	/**
	 * Get a list of servers
	 *
	 * @return  array  array of servers
	 *
	 * @since  2.1.0
	 */
	public static function getServers($config = array())
	{
		$options = array();
		$model = JModelLegacy::getInstance('Servers', 'ExternalloginModel', $config);
		$model->setState('list.ordering', 'a.ordering');
		$model->setState('list.direction', 'ASC');
		$items = $model->getItems();
		foreach($items as $item)
		{
			$options[] = array('value' => $item->id, 'text' => $item->title);
		}
		return $options;
	}

	/**
	 * Get a list of priorities
	 *
	 * @return  array  array of priorities
	 *
	 * @since  2.1.0
	 */
	public static function getPriorities()
	{
		$options = array();
		for ($i = 1; $i <= 128; $i = $i * 2)
		{
			$options[] = array('value' => $i, 'text' => 'COM_EXTERNALLOGIN_GRID_LOG_PRIORITY_' . $i);
		}
		return $options;
	}

	/**
	 * Get a list of categories
	 *
	 * @return  array  array of categories
	 *
	 * @since  2.1.0
	 */
	public static function getCategories()
	{
		$dbo = JFactory::getDbo();
		$categories = $dbo->setQuery($dbo->getQuery(true)->select('category')->from('#__externallogin_logs')->group('category'))->loadColumn();
		$options = array();
		foreach ($categories as $category)
		{
			$options[] = array('value' => $category, 'text' => $category);
		}
		return $options;
	}

	/**
	 * Get a list of groups from a string
	 *
	 * @param   string  $path       Group path
	 * @param   string  $separator  Separator string
	 *
	 * @return  array   Array of groups
	 */
	public static function getGroups($path, $separator = '/')
	{
		// Get the dbo
		$dbo = JFactory::getDbo();

		// Split the path
		if (empty($separator))
		{
			$path = array($path);
		}
		else
		{
			$path = explode($separator, $path);
		}
		$count = count($path);

		// Path is correct
		if ($count && !empty($path[$count - 1]))
		{
			// prepare query
			$query = $dbo->getQuery(true);
			$query->select('a' . ($count - 1) . '.id as id');
			$query->from('#__usergroups AS a' . ($count - 1));
			$query->where('a' . ($count - 1) . '.title = ' . $dbo->quote($path[$count - 1]));
			for ($i = $count - 2; $i >= 0; $i--)
			{
				if (empty($path[$i]))
				{
					if ($i == 0)
					{
						// Path is absolute
						$query->where('a1.parent_id = 0');
					}
					else
					{
						// Path is incorrect
						return null;
					}
				}
				else
				{
					$query->leftJoin('#__usergroups AS a' . $i . ' ON a' . $i . '.id = a' . ($i + 1) . '.parent_id');
					$query->where('a' . $i . '.title LIKE ' . $dbo->quote($path[$i]));
					
				}
			}
			$dbo->setQuery($query);
			return $dbo->loadColumn();
		}
		// Path is incorrect
		else
		{
			return null;
		}
	}	 
}
