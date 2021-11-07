<?php

/**
 * @package     External_Login
 * @subpackage  Component
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * Server View of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.0.0
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
			$app = JFactory::getApplication();
			$app->enqueueMessage(implode('<br />', $errors), 'error');
			$app->redirect('index.php');

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
	 * @return  void
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
		$title = JText::_('COM_EXTERNALLOGIN_MANAGER_SERVER_' . $type);
		$layout = new JLayoutFile('joomla.toolbar.title');
		$html   = $layout->render(array('title' => $title, 'icon' => 'server-' . $type));
		$app = JFactory::getApplication();
		$app->JComponentTitle = $html;
		JFactory::getDocument()->setTitle(strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . JText::_('JADMINISTRATION'));

		$bar = JToolbar::getInstance('toolbar');
		// Build the actions for new and existing records.
		if ($isNew)
		{
			$bar->appendButton('Standard', 'apply', 'JTOOLBAR_APPLY', 'server.apply', false);
			$bar->appendButton('Standard', 'save', 'JTOOLBAR_SAVE', 'server.save', false);
			$bar->appendButton('Standard', 'cancel', 'JTOOLBAR_CANCEL', 'server.cancel', false);
		}
		else
		{
			// Can't save the record if it's checked out.
			if (!$checkedOut)
			{
				$bar->appendButton('Standard', 'apply', 'JTOOLBAR_APPLY', 'server.apply', false);
				$bar->appendButton('Standard', 'save', 'JTOOLBAR_SAVE', 'server.save', false);
			}
			$bar->appendButton('Standard', 'cancel', 'JTOOLBAR_CLOSE', 'server.cancel', false);
		}
		$bar->appendButton('Separator', 'divider');
		$bar->appendButton('Help', 'COM_EXTERNALLOGIN_HELP_MANAGER_SERVER', false, null, null);
	}
}
