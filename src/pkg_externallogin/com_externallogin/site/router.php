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

/**
 * Function to build a External Login URL route.
 *
 * @param   array  $query  The array of query string values for which to build a route.
 *
 * @return  array  The URL route with segments represented as an array.
 *
 * @since	2.0.0
 */
function externalloginBuildRoute(&$query)
{
	// Declare static variables.
	static $items;
	static $default;
	static $login;

	// Initialise variables.
	$segments = array();

	// Get the relevant menu items if not loaded.
	if (empty($items))
	{
		// Get all relevant menu items.
		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$items	= $menu->getItems('component', 'com_externallogin');

		// Build an array of serialized query strings to menu item id mappings.
		for ($i = 0, $n = count($items); $i < $n; $i++)
		{
			// Check to see if we have found the login menu item.
			if (empty($login) && !empty($items[$i]->query['view']) && ($items[$i]->query['view'] == 'login'))
			{
				$login = $items[$i]->id;
			}
		}
	}

	if (!empty($query['view']))
	{
		switch ($query['view'])
		{
			default:
			case 'login':
				if (isset($login))
				{
					$query['Itemid'] = $login;
				}
				else
				{
					$segments[] = 'login';
				}
				break;
		}

		unset($query['view']);
	}

	return $segments;
}

/**
 * Function to parse a External Login URL route.
 *
 * @param   array  $segments  The URL route with segments represented as an array.
 *
 * @return  array|void  The array of variables to set in the request.
 *
 * @since	2.0.0
 */
function externalloginParseRoute($segments)
{
	// Only run routine if there are segments to parse.
	if (count($segments) == 0)
	{
		return;
	}
	else
	{
		$view = array_pop($segments);
		$vars['view'] = $view;

		return $vars;
	}
}
