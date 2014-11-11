<?php

/**
 * @package     External Login
 * @subpackage  External Login Module
 * @copyright   Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.plugin.helper');
jimport('joomla.application.component.helper');

require_once dirname(__FILE__) . '/helper.php';

$enabled = JComponentHelper::getComponent('com_externallogin', true)->enabled && JPluginHelper::isEnabled('authentication', 'externallogin');
$servers = modExternalloginsiteHelper::getListServersURL($params);
$count = count($servers);
require JModuleHelper::getLayoutPath('mod_externallogin_site', $params->get('layout', 'default'));

