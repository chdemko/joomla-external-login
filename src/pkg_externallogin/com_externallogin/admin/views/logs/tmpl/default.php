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

// load tooltip behavior
JHtml::_('bootstrap.tooltip');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<script type="text/javascript">
	Joomla.orderTable = function()
	{
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_externallogin&view=logs'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
		<label class="filter-hide-lbl" for="filter_begin"><?php echo JText::_('COM_EXTERNALLOGIN_LABEL_BEGIN'); ?></label>
		<?php echo JHtml::_('calendar', $this->state->get('filter.begin'), 'filter_begin', 'filter_begin', '%Y-%m-%d' , array('size'=>8,'style'=>'width:146px' , 'onchange'=>"this.form.fireEvent('submit');this.form.submit()")); ?>

		<label class="filter-hide-lbl" for="filter_end"><?php echo JText::_('COM_EXTERNALLOGIN_LABEL_END'); ?></label>
		<?php echo JHtml::_('calendar', $this->state->get('filter.end'), 'filter_end', 'filter_end', '%Y-%m-%d' , array('size'=>8,'style'=>'width:146px', 'onchange'=>"this.form.fireEvent('submit');this.form.submit()")); ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif; ?>
		<?php echo $this->loadTemplate('filter'); ?>
		<table class="table table-striped">
			<thead><?php echo $this->loadTemplate('head'); ?></thead>
			<tfoot><?php echo $this->loadTemplate('foot'); ?></tfoot>
			<tbody><?php echo $this->loadTemplate('body'); ?></tbody>
		</table>
		<div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>
