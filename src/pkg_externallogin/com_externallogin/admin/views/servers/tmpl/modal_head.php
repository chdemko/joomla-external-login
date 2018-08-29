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

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<tr>
	<th>
		<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
	</th>
	<?php if(isset($this->globalS)): ?>
		<th>
			<?php echo JText::_('COM_EXTERNALLOGIN_TOOLBAR_ENABLE_ACTIVATE_ALL'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_EXTERNALLOGIN_TOOLBAR_DISABLE_ALL'); ?>
		</th>
	<?php endif; ?>
	<th width="20%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_PLUGIN', 'e.ordering', $listDirn, $listOrder); ?>
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
	</th>
	<th width="5%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
	</th>
</tr>
