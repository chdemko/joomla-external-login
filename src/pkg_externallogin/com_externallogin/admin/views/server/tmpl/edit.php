<?php

/**
 * @package     External_Login
 * @subpackage  Component
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$fieldSets = $this->form->getFieldsets();
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'server.cancel' || document.formvalidator.isValid(document.getElementById('server-form'))) {
			Joomla.submitform(task, document.getElementById('server-form'));
		}
		else {
			alert(Joomla.JText._('JGLOBAL_VALIDATION_FORM_FAILED', 'Some values are unacceptable'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_externallogin&id=' . $this->item->id); ?>" method="post" name="adminForm" id="server-form" class="form-validate ">
	<div>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>
		<?php foreach ($fieldSets as $name => $fieldSet): ?>
			<?php $label = empty($fieldSet->label) ? 'COM_CONFIG_' . $name . '_FIELDSET_LABEL' : $fieldSet->label;?>
			<?php echo HTMLHelper::_('uitab.addTab', 'myTab', $name, Text::_($label)); ?>

			<?php if (isset($fieldSet->description) && trim(Text::_($fieldSet->description))): ?>
				<div class="alert alert-info">
					<span class="icon-info" aria-hidden="true"></span>
					<?php echo $this->escape(Text::_($fieldSet->description));?>
				</div>
			<?php endif;?>

			<div class="row">
				<div class="col-md-12">
					<?php foreach ($this->form->getFieldset($name) as $field) : ?>
						<?php echo $field->renderField(); ?>
					<?php endforeach; ?>
				</div>
			</div>
			<?php echo HTMLHelper::_('uitab.endTab'); ?>
		<?php endforeach; ?>
		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>

		<input type="hidden" name="plugin" value="<?php echo htmlspecialchars($this->item->plugin, ENT_COMPAT , 'UTF-8'); ?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

