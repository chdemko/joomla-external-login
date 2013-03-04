<?php

/**
 * @package     External Login
 * @subpackage  Component
 * @copyright   Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$fieldSets = $this->form->getFieldsets();
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'server.cancel' || document.formvalidator.isValid(document.id('server-form'))) {
			Joomla.submitform(task, document.getElementById('server-form'));
		}
		else {
			alert(Joomla.JText._('JGLOBAL_VALIDATION_FORM_FAILED', 'Some values are unacceptable'));
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_externallogin&id=' . $this->item->id); ?>" method="post" name="adminForm" id="server-form" class="form-validate">
	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_($fieldSets['details']->label); ?></legend>
			<?php if (isset($fieldSets['details']->description) && $desc = trim(JText::_($fieldSets['details']->description))) :?>
				<p class="tip"><?php echo $desc;?></p>
			<?php endif;?>
			<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset('details') as $field):
	if ($field->hidden):
				echo $field->input;
	else:
?>
				<li><?php echo $field->label . $field->input; ?></li>
<?php
	endif;
endforeach;
?>
			</ul>
		</fieldset>
	</div>
	
	<div class="width-50 fltrt">
<?php
		echo JHtml::_('sliders.start','externallogin-sliders-server-'.$this->item->id, array('useCookie'=>1));
?>
<?php
foreach ($fieldSets as $name => $fieldSet):
	if ($name != 'details'):
		echo JHtml::_('sliders.panel',JText::_($fieldSet->label), $name.'-options');
		if (isset($fieldSet->description) && trim($desc = JText::_($fieldSet->description))):
?>
		<p class="tip"><?php echo $desc;?></p>
<?php
		endif;
?>
		<fieldset class="panelform">
			<ul class="adminformlist">
<?php
foreach ($this->form->getFieldset($name) as $field):
	if ($field->hidden):
				echo $field->input;
	else:
?>
				<li><?php echo $field->label . $field->input; ?></li>
<?php
	endif;
endforeach;
?>
			</ul>
		</fieldset>
<?php
	endif;
endforeach;
		echo JHtml::_('sliders.end');
?>
	</div>
	<div>
		<input type="hidden" name="plugin" value="<?php echo htmlspecialchars($this->item->plugin, ENT_COMPAT , 'UTF-8');?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

