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
 * Plugins Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
 */
class ExternalloginModelPlugins extends JModelLegacy
{
	/**
	 * Get plugins
	 *
	 * @since  2.0.0
	 */
	public function getItems()
	{
		$items = array();

		// Include buttons defined by published external login plugins
		$app = JFactory::getApplication();
		$arrays = (array) $app->triggerEvent('onGetIcons', array('com_externallogin'));
		foreach ($arrays as $response)
		{
			foreach ($response as $plugin)
			{
				$items[] = $plugin;
			}
		}
		return $items;
	}
}
