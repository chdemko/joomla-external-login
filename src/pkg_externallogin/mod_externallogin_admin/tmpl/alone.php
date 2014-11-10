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
<h4><?php echo $servers[0]->title; ?></h4>
<div class="control-group">
	<div class="controls">
		<div class="btn-group pull-left">
			<button tabindex="3" class="btn btn-primary btn-large" onclick="window.location='<?php echo $servers[0]->url; ?>'; return false;">
				<i class="icon-lock icon-white"></i> <?php echo JText::_('MOD_EXTERNALLOGIN_ADMIN_LOGIN'); ?>
			</button>
		</div>
	</div>
</div>

