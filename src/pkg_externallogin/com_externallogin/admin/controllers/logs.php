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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Logs Controller of External Login component
 * 
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
 */
class ExternalloginControllerLogs extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  2.1.0
	 */
	protected $text_prefix = 'COM_EXTERNALLOGIN_LOGS';

	/**
	 * Proxy for getModel.
	 *
	 * @see     JController::getModel
	 *
	 * @since   2.1.0
	 */
	public function getModel($name = 'Log', $prefix = 'ExternalloginModel', $config = null) 
	{
		return parent::getModel($name, $prefix, isset($config) ? $config : array('ignore_request' => true));
	}

	/**
	 * Delete logs
	 *
	 * @since   2.1.0
	 */
	public function delete()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get/Create the model
		$model = $this->getModel('Logs', 'ExternalloginModel', array());

		// Remove the items.
		$count = $model->getTotal();
		if ($model->delete())
		{
			$this->setMessage(JText::plural('COM_EXTERNALLOGIN_LOGS_N_ITEMS_DELETED', $count));
		}
		else
		{
			$this->setMessage($model->getError());
		}

		$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=logs', false));
	}
}
