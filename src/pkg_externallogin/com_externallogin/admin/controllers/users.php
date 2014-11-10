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

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Users Controller of External Login component
 * 
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
 */
class ExternalloginControllerUsers extends JControllerLegacy
{
	/**
	 * Proxy for getModel.
	 *
	 * @see     JController::getModel
	 *
	 * @since   2.1.0
	 */
	public function getModel($name = 'User', $prefix = 'ExternalloginModel', $config = null) 
	{
		return parent::getModel($name, $prefix, isset($config) ? $config : array('ignore_request' => true));
	}

	/**
	 * Enable external login users to login using classical Joomla! method
	 *
	 * @since   2.1.0
	 */
	public function enableJoomla()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to publish from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');

		if (empty($cid))
		{
			JError::raiseWarning(500, JText::_('COM_EXTERNALLOGIN_USERS_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			JArrayHelper::toInteger($cid);

			// Publish the items.
			if (!$model->enableJoomla($cid))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				$this->setMessage(JText::plural('COM_EXTERNALLOGIN_USERS_N_USERS_JOOMLA_ENABLED', count($cid)));
			}
		}
		$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=users', false));
	}

	/**
	 * Enable external login users to login using classical Joomla! method
	 *
	 * @since   2.1.0
	 */
	public function disableJoomla()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to publish from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');

		if (empty($cid))
		{
			JError::raiseWarning(500, JText::_('COM_EXTERNALLOGIN_USERS_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			JArrayHelper::toInteger($cid);

			// Publish the items.
			if (!$model->disableJoomla($cid))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				$this->setMessage(JText::plural('COM_EXTERNALLOGIN_USERS_N_USERS_JOOMLA_DISABLED', count($cid)));
			}
		}
		$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=users', false));
	}

	/**
	 * Disable Joomla! users to login using external login method
	 *
	 * @since   2.1.0
	 */
	public function disableExternallogin()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to publish from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');

		if (empty($cid))
		{
			JError::raiseWarning(500, JText::_('COM_EXTERNALLOGIN_USERS_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			JArrayHelper::toInteger($cid);

			// Publish the items.
			if (!$model->disableExternallogin($cid))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				$this->setMessage(JText::plural('COM_EXTERNALLOGIN_USERS_N_USERS_EXTERNALLOGIN_DISABLED', count($cid)));
			}
		}
		$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=users', false));
	}

	/**
	 * Enable Joomla! users to login using external login method
	 *
	 * @since   2.1.0
	 */
	public function enableExternallogin()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		// Get items to publish from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');
		$sid = JRequest::getInt('server');

		if (empty($cid))
		{
			JError::raiseWarning(500, JText::_('COM_EXTERNALLOGIN_USERS_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			JArrayHelper::toInteger($cid);

			// Publish the items.
			if (!$model->enableExternallogin($cid, $sid))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				$this->setMessage(JText::plural('COM_EXTERNALLOGIN_USERS_N_USERS_EXTERNALLOGIN_ENABLED', count($cid)));
			}
		}
		$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=users', false));
	}
}
