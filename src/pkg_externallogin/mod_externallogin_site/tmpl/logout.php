<?php

/**
 * @package     External_Login
 * @subpackage  External Login Module
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2017 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;

?>
<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
	<div>
		<input type="submit" class="button" value="<?php echo htmlspecialchars(JText::_('JLOGOUT'), ENT_COMPAT, 'UTF-8'); ?>" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JFactory::getURI()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

