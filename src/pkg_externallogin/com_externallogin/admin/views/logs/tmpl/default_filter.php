<?php

/**
 * @package     External Login
 * @subpackage  Component
 * @copyright   Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<fieldset id="filter-bar">
	<div class="filter-search fltlft">
		<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
		<input type="text" class="hasTip" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo $this->escape(JText::_('COM_EXTERNALLOGIN_FILTER_LOGS_SEARCH_DESC')); ?>" />

		<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
		<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
	</div>
	<div class="filter-select fltrt">
		<select name="filter_priority" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_PRIORITY');?></option>
			<?php echo JHtml::_('select.options', ExternalloginHelper::getPriorities(), 'value', 'text', $this->state->get('filter.priority'), true);?>
		</select>
		<select name="filter_category" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_CATEGORY');?></option>
			<?php echo JHtml::_('select.options', ExternalloginHelper::getCategories(), 'value', 'text', $this->state->get('filter.category'), true);?>
		</select>
		<label class="filter-hide-lbl" for="filter_begin"><?php echo JText::_('COM_EXTERNALLOGIN_LABEL_BEGIN'); ?></label>
		<?php echo JHtml::_('calendar', $this->state->get('filter.begin'), 'filter_begin', 'filter_begin', '%Y-%m-%d' , array('size'=>10, 'onchange'=>"this.form.fireEvent('submit');this.form.submit()"));?>

		<label class="filter-hide-lbl" for="filter_end"><?php echo JText::_('COM_EXTERNALLOGIN_LABEL_END'); ?></label>
		<?php echo JHtml::_('calendar', $this->state->get('filter.end'), 'filter_end', 'filter_end', '%Y-%m-%d' , array('size'=>10, 'onchange'=>"this.form.fireEvent('submit');this.form.submit()"));?>
	</div>
</fieldset>
<div class="clr"></div>

