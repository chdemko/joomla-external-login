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
 * @since  2.0.0
 */
abstract class ExternalloginHtmlServers
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
	 * @since   2.0.0
	 */
	public static function state($value, $i, $enabled = true)
	{
		$states	= array(
			4	=> array(
				'unpublish',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNINSTALLED',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNPUBLISH',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNINSTALLED',
				false,
				'expired',
				'expired'
			),
			3	=> array(
				'unpublish',
				'COM_EXTERNALLOGIN_GRID_SERVER_DISABLED',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNPUBLISH',
				'COM_EXTERNALLOGIN_GRID_SERVER_DISABLED',
				false,
				'warning',
				'warning'
			),
			2	=> array(
				'publish',
				'COM_EXTERNALLOGIN_GRID_SERVER_ARCHIVED',
				'COM_EXTERNALLOGIN_GRID_SERVER_PUBLISH',
				'COM_EXTERNALLOGIN_GRID_SERVER_ARCHIVED',
				false,
				'archive',
				'archive'
			),
			1	=> array(
				'unpublish',
				'COM_EXTERNALLOGIN_GRID_SERVER_PUBLISHED',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNPUBLISH',
				'COM_EXTERNALLOGIN_GRID_SERVER_PUBLISHED',
				false,
				'publish',
				'publish'
			),
			0	=> array(
				'publish',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNPUBLISHED',
				'COM_EXTERNALLOGIN_GRID_SERVER_PUBLISH',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNPUBLISHED',
				false,
				'unpublish',
				'unpublish'
			),
			-2	=> array(
				'unpublish',
				'COM_EXTERNALLOGIN_GRID_SERVER_TRASHED',
				'COM_EXTERNALLOGIN_GRID_SERVER_UNPUBLISH',
				'COM_EXTERNALLOGIN_GRID_SERVER_TRASHED',
				false,
				'trash',
				'trash'
			),
		);

		return JHtml::_('jgrid.state', $states, $value, $i, 'servers.', $enabled, true, 'cb');
	}
}
