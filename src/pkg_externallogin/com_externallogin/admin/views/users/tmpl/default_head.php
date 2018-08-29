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
	<th width="1%">
		<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_USERNAME', 'a.username', $listDirn, $listOrder); ?>
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_NAME', 'a.name', $listDirn, $listOrder); ?>
	</th>
	<th width="20%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_EMAIL', 'a.email', $listDirn, $listOrder); ?>
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_PLUGIN', 'e.ordering', $listDirn, $listOrder); ?>
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_SERVER', 's.title', $listDirn, $listOrder); ?>
	</th>
	<th width="5%">
		<?php echo JText::_('COM_EXTERNALLOGIN_HEADING_JOOMLA'); ?>
	</th>
	<th width="5%">
		<?php echo JText::_('COM_EXTERNALLOGIN_HEADING_EXTERNAL'); ?>
	</th>
	<th width="5%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
	</th>
</tr>
