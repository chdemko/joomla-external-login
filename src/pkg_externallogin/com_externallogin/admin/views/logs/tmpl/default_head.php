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
	<th width="10%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_PRIORITY', 'a.priority', $listDirn, $listOrder); ?>
	</th>
	<th width="20%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_CATEGORY', 'a.category', $listDirn, $listOrder); ?>
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_DATE', 'a.date', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_EXTERNALLOGIN_HEADING_MESSAGE', 'a.message', $listDirn, $listOrder); ?>
	</th>
</tr>
