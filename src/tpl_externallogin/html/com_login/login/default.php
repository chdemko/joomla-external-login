<?php

/**
 * @package     External Login
 * @subpackage  Administrator Template
 * @copyright   Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access.
defined('_JEXEC') or die;

if (JRequest::getVar('classic') == 1)
{
	// Get the classical mod_login module
	echo JModuleHelper::renderModule(LoginModelLogin::getLoginModule('mod_login'), array('style' => 'rounded', 'id' => 'section-box'));
}
else
{
	// Get any other modules in the login position.
	foreach (JModuleHelper::getModules('login') as $module)
	{
		echo JModuleHelper::renderModule($module, array('style' => 'rounded', 'id' => 'section-box'));
	}
}
