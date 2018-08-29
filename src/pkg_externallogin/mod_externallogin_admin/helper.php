<?php

/**
 * @package     External_Login
 * @subpackage  External Login Module
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_externallogin/models', 'ExternalloginModel');

/**
 * Module helper class
 *
 * @package     External_Login
 * @subpackage  External Login Module
 *
 * @since       2.0.0
 */
abstract class ModExternalloginadminHelper
{
	/**
	 * Get the URLs of servers
	 *
	 * @param   JRegistry  $params  Module parameters
	 *
	 * @return  array  Array of URL
	 */
	public static function getListServersURL($params)
	{
		$app = JFactory::getApplication();
		$uri = JFactory::getURI();

		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Servers', 'ExternalloginModel', array('ignore_request' => true));
		$model->setState('filter.published', 1);
		$model->setState('filter.enabled', 1);
		$model->setState('filter.servers', $params->get('server'));
		$model->setState('list.start', 0);
		$model->setState('list.limit', 0);
		$model->setState('list.ordering', 'a.ordering');
		$model->setState('list.direction', 'ASC');
		$items = $model->getItems();

		foreach ($items as $i => $item)
		{
			$item->params = new JRegistry($item->params);
			$uri->setVar('server', $item->id);
			$results = $app->triggerEvent('onGetLoginUrl', array($item, JRoute::_($uri, true)));

			if (!empty($results))
			{
				$item->url = $results[0];
			}
			else
			{
				unset($items[$i]);
			}
		}

		return $items;
	}
}
