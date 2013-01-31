<?php

/**
 * @package    External Login
 * @subpackage External Login Module
 * @copyright  Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author     Christophe Demko
 * @author     Ioannis Barounis
 * @author     Alexandre Gandois
 * @link       http://www.chdemko.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;
?>
<h4><?php echo $servers[0]->title; ?></h4>
<div class="button-holder" >
	<div class="button1">
		<div class="next">
			<a href="<?php echo $servers[0]->url; ?>"><?php echo JText::_('MOD_EXTERNALLOGIN_ADMIN_LOGIN'); ?></a>
		</div>
	</div>
</div>

