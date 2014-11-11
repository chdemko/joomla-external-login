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
jimport('joomla.application.component.modelitem');

/**
 * Server Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
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
		$id = JFactory::getApplication()->input->get('server');
		$this->setState('server.id', $id);
		parent::populateState();
	}

	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type    The table type to instantiate
	 * @param   string  A prefix for the table class name. Optional.
	 * @param   array   Configuration array for model. Optional.
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

		// Compute the url
		$app = JFactory::getApplication();
		$url = $app->input->server->getString('HTTP_REFERER');
		if (empty($url) || !JURI::isInternal($url))
		{
			$redirect = JFactory::getApplication()->getParams('com_externallogin')->get('redirect');
			$url = JURI::getInstance()->toString(array('scheme', 'user', 'pass', 'host', 'port')) . JRoute::_('index.php?Itemid=' . $redirect, true);
		}

		// Compute the URI
		$uri = JFactory::getURI($url);

		// Return the service/URL
		if (JFactory::getUser()->guest)
		{
			$uri->setVar('server', $item->id);
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
