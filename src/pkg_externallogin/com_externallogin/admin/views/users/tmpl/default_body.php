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

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$user = JFactory::getUser();
$ordering = $this->state->get('list.ordering') == 'a.ordering';
$plugins = JArrayHelper::pivot(ExternalloginHelper::getPlugins(), 'value');
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $this->escape($item->username); ?>
		</td>
		<td>
			<?php echo $this->escape($item->name); ?>
		</td>
		<td>
			<?php echo $this->escape($item->email); ?>
		</td>
		<td>
			<?php if (isset($item->plugin)):?>
				<?php echo isset($plugins[$item->plugin]) ? $this->escape(JText::_($plugins[$item->plugin]['text'])) : JText::_('COM_EXTERNALLOGIN_GRID_SERVER_DISABLED'); ?>
			<?php endif;?>
		</td>
		<td>
			<?php echo $this->escape($item->title); ?>
		</td>
		<td class="center">
			<?php echo JHtml::_('ExternalloginHtml.Users.joomla', $item->joomla, $i, isset($item->plugin)); ?>
		</td>
		<td class="center">
			<?php if (isset($item->plugin)):?>
				<?php echo JHtml::_('ExternalloginHtml.Users.externallogin', 1, $i, $item->joomla); ?>
			<?php else:?>
				<a
					class="modal jgrid"
					title="<?php echo addslashes(htmlspecialchars(JText::_('COM_EXTERNALLOGIN_GRID_USER_EXTERNALLOGIN_ENABLE'), ENT_COMPAT, 'UTF-8'));?>"
					onclick="listItemTask('cb<?php echo $i;?>',''); return true;"
					href="<?php echo JRoute::_('index.php?option=com_externallogin&view=servers&layout=modal&tmpl=component');?>"
					rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}"
				>
					<span class="state unpublish">
						<span class="text"><?php echo JText::_('COM_EXTERNALLOGIN_GRID_USER_EXTERNALLOGIN_DISABLED');?></span>
					</span>
				</a>
			<?php endif;?>
		</td>
		<td class="right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
