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
abstract class ModExternalloginsiteHelper
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
		$redirect = $app->input->get('redirect', $app->getUserState('users.login.form.data.return'));

		if ($redirect)
		{
			$redirect = urlencode($redirect);
		}
		else
		{
			$redirect = $params->get('redirect');
		}

		$ishome = in_array(substr(JFactory::getUri()->toString(), strlen(JUri::base())), array('', 'index.php'));
		$noredirect = $params->get('noredirect');

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
			$url = 'index.php?option=com_externallogin&view=server&server=' . $item->id;

			if ($noredirect && !$ishome)
			{
				$url .= '&noredirect=1';
			}
			elseif (!empty($redirect))
			{
				$url .= '&redirect=' . $redirect;
			}

			$item->url = $url;
		}

		return $items;
	}

	/**
	 * Retrieve the url where the user should be returned after logging out
	 *
	 * @param   \Joomla\Registry\Registry  $params  module parameters
	 *
	 * @return string
	 */
	public static function getLogoutUrl($params)
	{
		$app = JFactory::getApplication();
		$item = $app->getMenu()->getItem(
			$params->get(
				'logout_redirect_menuitem',
				JComponentHelper::getComponent('com_externallogin', true)->params->get('logout_redirect_menuitem')
			)
		);

		// Stay on the same page
		$url = JUri::getInstance()->toString();

		if ($item)
		{
			$lang = '';

			if (JLanguageMultilang::isEnabled() && $item->language !== '*')
			{
				$lang = '&lang=' . $item->language;
			}

			$url = JRoute::_('index.php?Itemid=' . $item->id . $lang, $app->get('force_ssl') === 2 ? 1 : 2);
		}

		// We are forced to encode the url in base64 as com_users uses this encoding
		return base64_encode($url);
	}
}
