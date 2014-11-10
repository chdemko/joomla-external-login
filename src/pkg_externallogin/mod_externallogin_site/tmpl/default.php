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
<?php if (JFactory::getUser()->guest):?>
<div class="externallogin<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>">
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="external-login">
		<fieldset class="loginform">
	<?php
	if ($enabled):
		switch ($count):
			case 0:
				require JModuleHelper::getLayoutPath('mod_externallogin_site', 'zero');
				break;
			case 1:
				require JModuleHelper::getLayoutPath('mod_externallogin_site', 'alone');
				break;
			default:
				require JModuleHelper::getLayoutPath('mod_externallogin_site', 'form');
				break;
		endswitch;
	else:
		require JModuleHelper::getLayoutPath('mod_externallogin_site', 'disabled');
	endif;
	?>
		</fieldset>
	</form>
	<div class="clr"></div>
</div>
<?php elseif ($params->get('show_logout', 0)):?>
<div class="externallogin<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>">
	<?php require JModuleHelper::getLayoutPath('mod_externallogin_site', 'logout'); ?>
</div>
<?php endif; ?>

