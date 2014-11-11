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
 * Servers Controller of External Login component
 * 
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
 */
class ExternalloginControllerServers extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @see     JController::getModel
	 *
	 * @since   2.0.0
	 */
	public function getModel($name = 'Server', $prefix = 'ExternalloginModel', $config = null) 
	{
		return parent::getModel($name, $prefix, isset($config) ? $config : array('ignore_request' => true));
	}
}
