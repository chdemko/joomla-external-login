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

echo '<div id="j-sidebar-container" class="span2">' . $this->sidebar . '</div>';

echo JText::sprintf(
	'COM_EXTERNALLOGIN_ABOUT',
	'http://www.univ-montp2.fr',
	JHtml::_('image', 'com_externallogin/administrator/logo_um2.png', 'logo_um2', null, true)
);
?>
<br>
<h2 style="text-align: center;">...and upgraded to Joomla! 3.x by <a href="http://www.ninjaforge.com/" target="_blank">Ninja Forge</a> and <a href="http://www.pdxfixit.com/" target="_blank">PDXfixIT</a> with the help and the final validation of Christophe Demko.</h2>
