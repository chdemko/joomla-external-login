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

JHtml::_('behavior.keepalive');
?>
<div class="login<?php echo htmlspecialchars($this->params->get('pageclass_sfx'), ENT_COMPAT, 'UTF-8'); ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	<div class="login-description">
	<?php endif; ?>

		<?php if($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('login_image')!='')) : ?>
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_EXTERNALLOGIN_LOGIN_IMAGE_ALT')?>"/>
		<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	</div>
	<?php endif; ?>

	<form action="<?php echo JRoute::_('index.php'); ?>" method="post">
		<fieldset>
			<div class="login-fields">
			<label for="server-login"><?php echo JText::_('COM_EXTERNALLOGIN_SERVER_LABEL'); ?></label>
			<select id="server-login">
				<option value=""><?php echo JText::_('COM_EXTERNALLOGIN_SELECT_OPTION'); ?></option>
			<?php foreach($this->items as $server) : ?>
				<option value="<?php echo htmlspecialchars($server->url, ENT_COMPAT, 'UTF-8'); ?>"><?php echo $server->title; ?></option>
			<?php endforeach; ?>
			</select>
			<div class="clr"></div>
			<input type="submit" onclick="document.location.href=document.getElementById('server-login').options[document.getElementById('server-login').selectedIndex].value;return false;" class="button" value="<?php echo htmlspecialchars(JText::_('JLOGIN'), ENT_COMPAT, 'UTF-8'); ?>" />
		</fieldset>
	</form>
</div>

