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
?>
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $this->escape(JText::_('COM_EXTERNALLOGIN_GRID_LOG_PRIORITY_' . $item->priority)); ?>
		</td>
		<td>
			<?php echo $this->escape($item->category); ?>
		</td>
		<td>
			<?php echo date('Y-m-d H:i:s', (int)$item->date); ?>
		</td>
		<td>
			<?php echo $this->escape($item->message); ?>
		</td>
	</tr>
<?php endforeach; ?>
