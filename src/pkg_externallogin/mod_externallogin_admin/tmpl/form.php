<?php

/**
 * @package    External Login
 * @subpackage External Login Module
 * @copyright  Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author     Christophe Demko
 * @author     Ioannis Barounis
 * @author     Alexandre Gandois
 * @link       http://www.chdemko.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;
?>
<label for="mod-server-login-<?php echo $module->id; ?>"><?php echo JText::_('MOD_EXTERNALLOGIN_ADMIN_SERVER_LABEL'); ?></label>
<select id="mod-server-login-<?php echo $module->id; ?>">
	<option value=""><?php echo JText::_('MOD_EXTERNALLOGIN_ADMIN_SELECT_OPTION'); ?></option>
<?php foreach($servers as $server):?>
	<option value="<?php echo htmlspecialchars($server->url, ENT_COMPAT, 'UTF-8'); ?>"><?php echo $server->title; ?></option>
<?php endforeach; ?>
</select>
<div class="clr"></div>
<div class="control-group">
	<div class="controls">
		<div class="btn-group pull-left">
			<button tabindex="3" class="btn btn-primary btn-large" onclick="window.location=document.id('mod-server-login-<?php echo $module->id; ?>').options[document.id('mod-server-login-<?php echo $module->id; ?>').selectedIndex].value; return false;">
				<i class="icon-lock icon-white"></i> <?php echo JText::_('MOD_EXTERNALLOGIN_ADMIN_LOGIN'); ?>
			</button>
		</div>
	</div>
</div>

