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

<form action="<?php echo JRoute::_('index.php?option=com_externallogin&id=' . $this->item->id); ?>" method="post" name="adminForm" id="server-form" class="form-validate form-horizontal">
	<div class="row-fluid">
		<div class="span10">
			<ul class="nav nav-tabs" id="configTabs">
				<?php $fieldSets = $this->form->getFieldsets(); ?>
				<?php foreach ($fieldSets as $name => $fieldSet) : ?>
					<?php $label = empty($fieldSet->label) ? 'COM_CONFIG_' . $name . '_FIELDSET_LABEL' : $fieldSet->label; ?>
					<li><a href="#<?php echo $name; ?>" data-toggle="tab"><?php echo JText::_($label); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<div class="tab-content">
				<?php $fieldSets = $this->form->getFieldsets(); ?>
				<?php foreach ($fieldSets as $name => $fieldSet) : ?>
					<div class="tab-pane" id="<?php echo $name; ?>">
						<?php if (isset($fieldSet->description) && !empty($fieldSet->description)) : ?>
							<p class="tab-description"><?php echo JText::_($fieldSet->description); ?></p>
						<?php endif; ?>
						<?php foreach ($this->form->getFieldset($name) as $field): ?>
							<div class="control-group">
								<?php if (!$field->hidden && $name != "permissions") : ?>
									<div class="control-label">
										<?php echo $field->label; ?>
									</div>
								<?php endif; ?>
								<div class="<?php if ($name != "permissions") : ?>controls<?php endif; ?>">
									<?php echo $field->input; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div>
		<input type="hidden" name="plugin" value="<?php echo htmlspecialchars($this->item->plugin, ENT_COMPAT , 'UTF-8'); ?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<script type="text/javascript">
	jQuery('#configTabs').find('a:first').tab('show'); // Select first tab
</script>
