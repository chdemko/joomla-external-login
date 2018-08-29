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

// Import the Joomla modellist library
jimport('joomla.application.component.modelitem');

/**
 * Server Model of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.0.0
 */
class ExternalloginModelServer extends JModelItem
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
		$id = JFactory::getApplication()->input->get('server', 0, 'uint');
		$this->setState('server.id', $id);
		$redirect = JFactory::getApplication()->input->get('redirect', '', 'RAW');
		$this->setState('server.redirect', $redirect);
		$noredirect = JFactory::getApplication()->input->get('noredirect');
		$this->setState('server.noredirect', $noredirect);
		parent::populateState();
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type    $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
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
	 * Returns the server
	 *
	 * @return	JTable  A database object
	 *
	 * @since	2.0.0
	 */
	public function getItem()
	{
		// Load the server
		$id = $this->getState('server.id');
		$item = $this->getTable();

		if (!$item->load($id) || $item->published != 1)
		{
			$this->setError(JText::_('COM_EXTERNALLOGIN_ERROR_SERVER_UNPUBLISHED'));

			return false;
		}

		$app = JFactory::getApplication();
		$menu = $app->getMenu()->getActive();

		if ($menu)
		{
			$params = $menu->params;
		}
		else
		{
			$params = new JRegistry;
		}

		// Compute the url
		$redirect = $this->getState(
			'server.redirect',
			$params->get(
				'redirect',
				$item->params->get(
					'redirect',
					JComponentHelper::getParams('com_externallogin')->get('redirect')
				)
			)
		);
		$noredirect = $this->getState(
			'server.noredirect',
			$item->params->get(
				'noredirect',
				JComponentHelper::getParams('com_externallogin')->get('noredirect')
			)
		);

		if (!empty($redirect) && !$noredirect)
		{
			$url = ExternalloginHelper::url($redirect);
		}
		else
		{
			$url = $app->input->server->getString('HTTP_REFERER');

			if (empty($url) || !JUri::isInternal($url))
			{
				$url = JRoute::_('index.php', true, $app->get('force_ssl') == 2);
			}
		}

		// Compute the URI
		$uri = JFactory::getURI($url);

		// Return the service/URL
		if (JFactory::getUser()->guest)
		{
			$app->setUserState('com_externallogin.server', $item->id);

			$results = $app->triggerEvent('onGetLoginUrl', array($item, $uri));

			if (!empty($results))
			{
				return $results[0];
			}
			else
			{
				$this->setError(JText::_('COM_EXTERNALLOGIN_ERROR_OCCURS'));
			}
		}
		else
		{
			return $uri;
		}
	}
}
