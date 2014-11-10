<?php

/**
 * @package    External Login
 * @subpackage External Login Module
 * @copyright  Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author     Christophe Demko
 * @author     Ioannis Barounis
 * @author     Alexandre Gandois
 * @link       http://www.chdemko.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;
?>
<?php if ($params->get('show_title', 0)):?>
<h4><?php echo $servers[0]->title; ?></h4>
<?php endif; ?>
<input type="submit" onclick="document.location.href='<?php echo $servers[0]->url; ?>';return false;" class="button" value="<?php echo htmlspecialchars(JText::_('JLOGIN'), ENT_COMPAT, 'UTF-8'); ?>" />

