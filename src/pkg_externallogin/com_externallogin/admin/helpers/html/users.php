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
 * External Login component Html helper.
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
 */
abstract class ExternalloginHtmlUsers
{
	/**
	 * Returns a published state on a grid
	 *
	 * @param   integer       $value			The state value.
	 * @param   integer       $i				The row index
	 * @param   boolean       $enabled			An optional setting for access control on the action.
	 *
	 * @return  string        The Html code
	 *
	 * @see JHtmlJGrid::state
	 *
	 * @since   2.1.0
	 */
	public static function joomla($value, $i, $enabled = true)
	{
		$states	= array(
			1	=> array(
				'disableJoomla',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_ENABLED',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_DISABLE',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_ENABLED',
				false,
				'publish',
				'publish'
			),
			0	=> array(
				'enableJoomla',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_DISABLED',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_ENABLE',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_DISABLED',
				false,
				'unpublish',
				'unpublish'
			),
		);

		return JHtml::_('jgrid.state', $states, $value, $i, 'users.', $enabled, true, 'cb');
	}

	/**
	 * Returns a published state on a grid
	 *
	 * @param   integer       $value			The state value.
	 * @param   integer       $i				The row index
	 * @param   boolean       $enabled			An optional setting for access control on the action.
	 *
	 * @return  string        The Html code
	 *
	 * @see JHtmlJGrid::state
	 *
	 * @since   2.1.0
	 */
	public static function externallogin($value, $i, $enabled = true)
	{
		$states	= array(
			1	=> array(
				'disableExternallogin',
				'COM_EXTERNALLOGIN_GRID_USER_EXTERNALLOGIN_ENABLED',
				'COM_EXTERNALLOGIN_GRID_USER_EXTERNALLOGIN_DISABLE',
				'COM_EXTERNALLOGIN_GRID_USER_EXTERNALLOGIN_ENABLED',
				false,
				'publish',
				'publish'
			),
			0	=> array(
				'enableJoomla',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_DISABLED',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_ENABLE',
				'COM_EXTERNALLOGIN_GRID_USER_JOOMLA_DISABLED',
				false,
				'unpublish',
				'unpublish'
			),
		);

		return JHtml::_('jgrid.state', $states, $value, $i, 'users.', $enabled, true, 'cb');
	}
}
