<?php

/**
 * @package    External Login
 * @subpackage Component
 * @copyright  Copyright (C) 2008-2012 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
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
 * Servers View of External Login component
 * 
 * @package    External Login
 * @subpackage Component
 *             
 * @since      2.0.0
 */
class ExternalloginViewServers extends JView
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
	 * @since   2.0.0
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
	 * @since   2.0.0
	 */
	protected function addToolbar() 
	{

		// Load specific css component
		JHtml::_('stylesheet', 'com_externallogin/administrator/externallogin.css', array(), true);

		// Set the toolbar
		JToolBarHelper::title(JText::_('COM_EXTERNALLOGIN_MANAGER_SERVERS'), 'servers');
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Popup', 'new', 'JTOOLBAR_NEW', 'index.php?option=com_externallogin&amp;view=plugins&amp;tmpl=component', 875, 550, 0, 0, '');
		JToolBarHelper::editList('server.edit');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('servers.publish');
		JToolBarHelper::unpublishList('servers.unpublish');
		JToolBarHelper::divider();
		JToolBarHelper::checkin('servers.checkin');
		if ($this->state->get('filter.published') == - 2) 
		{
			JToolBarHelper::deleteList('COM_EXTERNALLOGIN_MSG_SERVERS_DELETE', 'servers.delete');
			JToolBarHelper::divider();
		}
		else
		{
			JToolBarHelper::archiveList('servers.archive');
			JToolBarHelper::trash('servers.trash');
			JToolBarHelper::divider();
		}
		JToolBarHelper::custom('server.upload', 'users-upload', 'users-upload', 'COM_EXTERNALLOGIN_TOOLBAR_UPLOAD');
		JToolBarHelper::custom('server.download', 'users-download', 'users-download', 'COM_EXTERNALLOGIN_TOOLBAR_DOWNLOAD');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_externallogin');
		JToolBarHelper::divider();
		JToolBarHelper::help('COM_EXTERNALLOGIN_HELP_MANAGER_SERVERS');
	}
}
