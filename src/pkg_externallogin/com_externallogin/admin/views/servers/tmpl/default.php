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

// load tooltip behavior
JHtml::_('bootstrap.tooltip');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

JHtml::_('behavior.framework', true);
JHtml::_('script', 'system/modal.js', true, true);
JHtml::_('stylesheet', 'system/modal.css', array(), true);

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

JFactory::getDocument()->addScriptDeclaration("
Joomla.submitbutton = function(pressbutton)
{
	if (pressbutton == 'server.upload')
	{
		var c = 0;
		for (var i = 0, n = document.adminForm.elements.length; i < n; i++)
		{
			var e = document.adminForm.elements[i];
			if (e.name == 'cid[]' & e.checked == true)
			{
				c = e.value;
				break;
			}
		}
		SqueezeBox.open(\"" . JRoute::_('index.php?option=com_externallogin&view=upload&tmpl=component', false) . "\" + '&id=' + c, {handler: 'iframe', size: {x: 600, y: 300}});
	}
	else
	{
		Joomla.submitform(pressbutton);
	}
}
	Joomla.orderTable = function()
	{
		table = document.getElementById(\"sortTable\");
		direction = document.getElementById(\"directionTable\");
		order = table.options[table.selectedIndex].value;
		if (order != '" . $listOrder . "')
		{
			dirn = 'asc';
		}
		else
		{
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
");
?>
<form action="<?php echo JRoute::_('index.php?option=com_externallogin&view=servers'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
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
