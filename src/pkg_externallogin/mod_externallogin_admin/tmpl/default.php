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
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="external-login">
<?php require JModuleHelper::getLayoutPath('mod_externallogin_admin', 'title'); ?>
	<fieldset class="loginform">
<?php
if ($enabled):
	switch ($count):
		case 0:
			require JModuleHelper::getLayoutPath('mod_externallogin_admin', 'zero');
			break;
		case 1:
			require JModuleHelper::getLayoutPath('mod_externallogin_admin', 'alone');
			break;
		default:
			require JModuleHelper::getLayoutPath('mod_externallogin_admin', 'form');
			break;
	endswitch;
else:
	require JModuleHelper::getLayoutPath('mod_externallogin_admin', 'disabled');
endif;
?>
	</fieldset>
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
