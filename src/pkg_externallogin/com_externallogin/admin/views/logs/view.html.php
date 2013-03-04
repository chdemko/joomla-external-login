<?php

/**
 * @package    External Login
 * @subpackage Component
 * @copyright  Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
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
class ExternalloginViewLogs extends JView
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
		JToolBarHelper::title(JText::_('COM_EXTERNALLOGIN_MANAGER_LOGS'), 'logs');
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Confirm', 'COM_EXTERNALLOGIN_MSG_LOGS_DELETE', 'delete', 'JTOOLBAR_DELETE', 'logs.delete', false);
		JToolBarHelper::divider();
		$bar->appendButton('Link', 'logs-download', 'COM_EXTERNALLOGIN_TOOLBAR_LOGS_DOWNLOAD', 'index.php?option=com_externallogin&view=logs&format=csv');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_externallogin');
		JToolBarHelper::divider();
		JToolBarHelper::help('COM_EXTERNALLOGIN_HELP_MANAGER_LOGS');
	}
}
