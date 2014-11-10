<?php

/**
 * @package    External Login
 * @subpackage Component
 * @copyright  Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author     Christophe Demko
 * @author     Ioannis Barounis
 * @author     Alexandre Gandois
 * @link       http://www.chdemko.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Logs View of External Login component
 * 
 * @package    External Login
 * @subpackage Component
 *             
 * @since      2.1.0
 */
class ExternalloginViewLogs extends JViewLegacy
{

	/**
	 * Execute and display a layout script.
	 *
	 * @param   string  $tpl  The name of the layout file to parse.
	 *
	 * @return  void|JError
	 *
	 * @see     Overload JView::display
	 *
	 * @since   2.1.0
	 */
	public function display($tpl = null) 
	{

		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
		$state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		$this->state = $state;

		// Set the toolbar
		$this->addToolBar();
		
		$this->sidebar = JHtml::_('sidebar.render');

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Setting the toolbar
	 *
	 * @since   2.1.0
	 */
	protected function addToolbar() 
	{
		// Load specific css component
		JHtml::_('stylesheet', 'com_externallogin/administrator/externallogin.css', array(), true);

		// Set the toolbar
		JToolBarHelper::title(JText::_('COM_EXTERNALLOGIN_MANAGER_LOGS'), 'list-view');
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Confirm', 'COM_EXTERNALLOGIN_MSG_LOGS_DELETE', 'delete', 'JTOOLBAR_DELETE', 'logs.delete', false);
		$bar->appendButton('Link', 'box-add', 'COM_EXTERNALLOGIN_TOOLBAR_LOGS_DOWNLOAD', 'index.php?option=com_externallogin&view=logs&format=csv');
		JToolBarHelper::preferences('com_externallogin');
		
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), 'index.php?option=com_externallogin', false); 
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), 'index.php?option=com_externallogin&view=users', false); 
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), 'index.php?option=com_externallogin&view=logs', true);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), 'index.php?option=com_externallogin&view=about', false);
			
		JHtml::_('sidebar.setaction', 'index.php?option=com_externallogin&view=logs');

		JHtml::_('sidebar.addFilter', JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_PRIORITY'), 'filter_priority',
			 JHtml::_('select.options', ExternalloginHelper::getPriorities(), 'value', 'text', $this->state->get('filter.priority'), true));
		
		JHtml::_('sidebar.addFilter', JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_category',
			JHtml::_('select.options', ExternalloginHelper::getCategories(), 'value', 'text', $this->state->get('filter.category'), true));
	}
	
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.priority' => JText::_('COM_EXTERNALLOGIN_HEADING_PRIORITY'),
			'a.category' => JText::_('COM_EXTERNALLOGIN_HEADING_CATEGORY'),
			'a.date' => JText::_('COM_EXTERNALLOGIN_HEADING_DATE'),
			'a.message' => JText::_('COM_EXTERNALLOGIN_HEADING_MESSAGE')		
		);		
	}

}
