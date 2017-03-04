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

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<fieldset id="filter">
	<div class="filter-modal-box">
		<div class="filter-search btn-group pull-left">
			<label class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" class="hasTooltip" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo $this->escape(JText::_('COM_EXTERNALLOGIN_FILTER_SERVERS_SEARCH_DESC')); ?>" />
		</div>
		<div class="btn-group pull-left">		
			<button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
			<button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>		
		</div>
	</div>
	<div class="filter-select fltrt">
		<select name="filter_plugin" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_PLUGIN'); ?></option>
			<?php echo JHtml::_('select.options', ExternalloginHelper::getPlugins(), 'value', 'text', $this->state->get('filter.plugin'), true); ?>
		</select>
		<select name="filter_published" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
			<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true); ?>
		</select>
	</div>
</fieldset>
<div class="clr"></div>
