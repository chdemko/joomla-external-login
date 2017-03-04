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

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$user = JFactory::getUser();
$ordering = $this->state->get('list.ordering') == 'a.ordering';
$plugins = JArrayHelper::pivot(ExternalloginHelper::getPlugins(), 'value');

if (!count($this->items)){
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td colspan="6" class="center">
			<?php echo JText::_('COM_EXTERNALLOGIN_NO_RECORDS'); ?>
		</td>
	</tr>
	<?php 
} else {
?>
<?php foreach($this->items as $i => $item): ?>
	<?php
		$canChange	= $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php if ($item->checked_out) : ?>
				<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'servers.', $canChange); ?>
			<?php endif; ?>
			<a href="<?php echo JRoute::_('index.php?option=com_externallogin&task=server.edit&id='.$item->id); ?>">
				<?php echo $this->escape($item->title); ?>
			</a>
		</td>
		<td>
			<?php echo isset($plugins[$item->plugin]) ? $this->escape(JText::_($plugins[$item->plugin]['text'])) : JText::_('COM_EXTERNALLOGIN_GRID_SERVER_DISABLED'); ?>
		</td>
		<td class="center">
			<?php echo JHtml::_(
				'ExternalloginHtml.Servers.state',
				$item->published == 1 ? ($item->enabled == null ? 4 : ($item->enabled == 0 ? 3 : 1)) : $item->published,
				$i,
				$canChange); ?>
		</td>
		<td class="order center">
<?php if ($canChange && $ordering) : ?>
			<span><?php echo $this->pagination->orderUpIcon($i, true, 'servers.orderup', 'JLIB_HTML_MOVE_UP'); ?></span>
			<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'servers.orderdown', 'JLIB_HTML_MOVE_DOWN'); ?></span>
			<input type="text" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="text-area-order" />
<?php else: ?>
			<?php echo $item->ordering; ?>
<?php endif; ?>
		</td>
		<td class="right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; } ?>
