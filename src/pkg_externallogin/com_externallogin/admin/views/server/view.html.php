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

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Server View of External Login component
 * 
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.0.0
 */
class ExternalloginViewServer extends JViewLegacy
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
		$item = $this->get('Item');
		$form = $this->get('Form');
		$state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Assign data to the view
		$this->item = $item;
		$this->form = $form;
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

		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user = JFactory::getUser();
		$userId = $user->get('id');
		$isNew = $this->item->id == 0;
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$type = $checkedOut ? 'view' : $isNew ? 'new' : 'edit';

		// Set the title
		JToolBarHelper::title(JText::_('COM_EXTERNALLOGIN_MANAGER_SERVER_' . $type), 'server-' . $type);

		// Build the actions for new and existing records.
		if ($isNew)
		{
			JToolBarHelper::apply('server.apply');
			JToolBarHelper::save('server.save');
			JToolBarHelper::cancel('server.cancel');
		}
		else {
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				JToolBarHelper::apply('server.apply');
				JToolBarHelper::save('server.save');
			}

			JToolBarHelper::cancel('server.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('COM_EXTERNALLOGIN_HELP_MANAGER_SERVER');
	}
}

