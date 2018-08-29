<?php

/**
 * @package     External_Login
 * @subpackage  External Login Module
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;
?>
<h4><?php echo $servers[0]->title; ?></h4>
<div class="control-group">
	<div class="controls">
		<div class="btn-group pull-left">
			<button tabindex="3" class="btn btn-primary btn-large" onclick="document.location.href='<?php echo $servers[0]->url; ?>'; return false;">
				<i class="icon-lock icon-white"></i> <?php echo JText::_('MOD_EXTERNALLOGIN_ADMIN_LOGIN'); ?>
			</button>
		</div>
	</div>
</div>

