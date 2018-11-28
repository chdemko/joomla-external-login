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
?>
<label for="mod-server-login-<?php echo $module->id; ?>"><?php echo JText::_('MOD_EXTERNALLOGIN_SITE_SERVER_LABEL'); ?></label>
<select id="mod-server-login-<?php echo $module->id; ?>" class="span">
	<option value=""><?php echo JText::_('MOD_EXTERNALLOGIN_SITE_SELECT_OPTION'); ?></option>
<?php foreach($servers as $server):?>
	<option value="<?php echo htmlspecialchars($server->url, ENT_COMPAT, 'UTF-8'); ?>"><?php echo $server->title; ?></option>
<?php endforeach; ?>
</select>
<div class="clr"></div>
<input type="submit" class="btn btn-primary" onclick="document.location.href=document.getElementById('mod-server-login-<?php echo $module->id; ?>').options[document.getElementById('mod-server-login-<?php echo $module->id; ?>').selectedIndex].value;return false;" class="button" value="<?php echo htmlspecialchars(JText::_('JLOGIN'), ENT_COMPAT, 'UTF-8'); ?>" />

