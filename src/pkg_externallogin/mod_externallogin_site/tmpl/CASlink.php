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
<?php

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root(true) . '/modules/mod_externallogin_site/media/css/mod_externallogin.css');

if (JFactory::getUser()->guest): ?>
<span class="rawlink-spacer">|</span>
<span class="externallogin<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>"
	 style="line-height: 14px; float:right;">
	<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="external-login">
		<fieldset class="loginform">
	<?php
	if ($enabled): ?>
		<?php if ($params->get('show_title', 0)):?>
			<h4><?php echo $servers[0]->title; ?></h4>
		<?php endif; ?>
		<input type="submit"
        onclick="document.location.href='<?php echo $servers[0]->url; ?>';return false;"
	    class="submitLink"
        value="<?php echo htmlspecialchars(JText::_('JLOGIN'), ENT_COMPAT, 'UTF-8'); ?>"/>
	<?php 
	else:
		require JModuleHelper::getLayoutPath('mod_externallogin_site', 'disabled');
	endif;
	?>
		</fieldset>
	</form>
	<div class="clr"></div>
</span>
<?php elseif ($params->get('show_logout', 0)):?>
<span class="rawlink-spacer" style="float:left;">|</span>
<span class="externallogin<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>"
	  style="line-height14px; float:left;">
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
    <div>
        <input type="submit"
			   class="submitLink"
               value="<?php echo htmlspecialchars(JText::_('JLOGOUT'), ENT_COMPAT, 'UTF-8'); ?>" />
        <input type="hidden"
               name="return"
               value="<?php echo base64_encode(JFactory::getURI()); ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
</span>
	<?php if ($params->get('show_logout_local', 0)):?>
		<span class="rawlink-spacer" style="float:left;">|</span>
		<span class="externallogin<?php echo htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>"
			  style="line-height14px; float:right;">
		<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
			<div>
				<input type="submit"
					   class="submitLink"
					   value="<?php echo htmlspecialchars(JText::_('Lokal abmelden'), ENT_COMPAT, 'UTF-8'); ?>" />
				<input type="hidden"
					   name="return"
					   value="<?php echo base64_encode(JFactory::getURI()); ?>" />
				<input type="hidden"
					   name="local"
					   value="1" />
				<?php echo JHtml::_('form.token'); ?>
				</div>
		</form>
</span>
	<?php endif; ?>
<?php endif; ?>