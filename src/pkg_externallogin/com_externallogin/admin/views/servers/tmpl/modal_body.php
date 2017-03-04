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
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<a class="pointer" onclick="if (window.parent) {window.parent.document.adminForm.server.value=<?php echo $item->id; ?>;window.close(); window.parent.submitbutton('users.enableExternallogin');}"><?php echo $this->escape($item->title); ?></a>
		</td>
		<td>
			<?php echo isset($plugins[$item->plugin]) ? $this->escape(JText::_($plugins[$item->plugin]['text'])) : JText::_('COM_EXTERNALLOGIN_GRID_SERVER_DISABLED'); ?>
		</td>
		<td class="center">
			<?php echo JHtml::_(
				'ExternalloginHtml.Servers.state',
				$item->published == 1 ? ($item->enabled == null ? 4 : ($item->enabled == 0 ? 3 : 1)) : $item->published,
				$i,
				false); ?>
		</td>
		<td class="right">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; }?>
