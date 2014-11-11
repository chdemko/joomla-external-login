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

?>
<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
	<div>
		<input type="submit" class="button" value="<?php echo htmlspecialchars(JText::_('JLOGOUT'), ENT_COMPAT, 'UTF-8'); ?>" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JFactory::getURI()); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

