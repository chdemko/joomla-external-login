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
 * Logs View of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.1.0
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
			$app = JFactory::getApplication();
			$app->enqueueMessage(implode('<br />', $errors), 'error');
			$app->redirect('index.php');

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
	 * @return  void
	 *
	 * @since   2.1.0
	 */
	protected function addToolbar()
	{
		// Load specific css component
		JHtml::_('stylesheet', 'com_externallogin/administrator/externallogin.css', array(), true);

		// Set the toolbar
        $title = JText::_('COM_EXTERNALLOGIN_MANAGER_LOGS');
		$layout = new JLayoutFile('joomla.toolbar.title');
		$html   = $layout->render(array('title' => $title, 'icon' => 'list-view'));
		$app = JFactory::getApplication();
		$app->JComponentTitle = $html;
		JFactory::getDocument()->setTitle(strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . JText::_('JADMINISTRATION'));

		$return = urlencode(base64_encode((string) JUri::getInstance()));
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Confirm', 'COM_EXTERNALLOGIN_MSG_LOGS_DELETE', 'delete', 'JTOOLBAR_DELETE', 'logs.delete', false);
		$bar->appendButton('Link', 'download', 'COM_EXTERNALLOGIN_TOOLBAR_LOGS_DOWNLOAD', 'index.php?option=com_externallogin&view=logs&format=csv');
        $bar->appendButton('Link', 'options', 'JToolbar_Options', 'index.php?option=com_config&amp;view=component&amp;component=com_externallogin&amp;return=' . $return);
		$bar->appendButton('Separator', 'divider');
		$bar->appendButton('Help', 'COM_EXTERNALLOGIN_HELP_MANAGER_LOGS', false, null, null);

		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), 'index.php?option=com_externallogin', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), 'index.php?option=com_externallogin&view=users', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), 'index.php?option=com_externallogin&view=logs', true);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), 'index.php?option=com_externallogin&view=about', false);

		JHtml::_('sidebar.setaction', 'index.php?option=com_externallogin&view=logs');

		JHtml::_(
			'sidebar.addFilter',
			JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_PRIORITY'),
			'filter_priority',
			JHtml::_('select.options', ExternalloginHelper::getPriorities(), 'value', 'text', $this->state->get('filter.priority'), true)
		);

		JHtml::_(
			'sidebar.addFilter',
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_category',
			JHtml::_('select.options', ExternalloginHelper::getCategories(), 'value', 'text', $this->state->get('filter.category'), true)
		);
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
