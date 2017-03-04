<?php

/**
 * @package     External_Login
 * @subpackage  Component
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;

$html = JHtml::_('icons.buttons', $this->items);
?>
<?php if (!empty($html)): ?>
	<div class="cpanel"><?php echo $html; ?></div>
<?php else : ?>
    <div class="cpanel"><?php echo JText::_('COM_EXTERNALLOGIN_NO_PLUGINS'); ?></div>
<?php endif; ?>
