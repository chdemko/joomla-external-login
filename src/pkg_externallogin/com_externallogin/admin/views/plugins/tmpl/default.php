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

$html = JHtml::_('icons.buttons', $this->items);
?>
<?php if (!empty($html)): ?>
	<div class="cpanel"><?php echo $html; ?></div>
<?php else : ?>
    <div class="cpanel"><?php echo JText::_('COM_EXTERNALLOGIN_NO_PLUGINS'); ?></div>
<?php endif; ?>
