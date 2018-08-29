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

jimport('joomla.plugin.helper');
jimport('joomla.application.component.helper');

require_once dirname(__FILE__) . '/helper.php';

$enabled = JComponentHelper::getComponent('com_externallogin', true)->enabled && JPluginHelper::isEnabled('authentication', 'externallogin');
$servers = modExternalloginsiteHelper::getListServersURL($params);
$count = count($servers);
$user = JFactory::getUser();
$return = modExternalloginsiteHelper::getLogoutUrl($params);

require JModuleHelper::getLayoutPath('mod_externallogin_site', $params->get('layout', 'default'));
