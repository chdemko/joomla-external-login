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
 * General Controller of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
 */
class ExternalloginController extends JControllerLegacy
{
	/**
	 * @var  string  The default view for the display method.
	 *
	 * @since  0.0.1
	 *
	 * @see  JController::$default_view
	 */
	protected $default_view = 'login';
}
