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
 * Servers View of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.0.0
 */
class ExternalloginViewServers extends JViewLegacy
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

		// Get global var if set
		$global = JFactory::getApplication()->input->getInt('globalS');

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

		// Check if a server should be set global
		if ($global === 1)
		{
			$this->globalS = true;
		}

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
	 * @since   2.0.0
	 */
	protected function addToolbar()
	{
		// Load specific css component
		JHtml::_('stylesheet', 'com_externallogin/administrator/externallogin.css', array(), true);

		// Set the toolbar
		$title = JText::_('COM_EXTERNALLOGIN_MANAGER_SERVERS');
		$layout = new JLayoutFile('joomla.toolbar.title');
		$html   = $layout->render(array('title' => $title, 'icon' => 'database'));
		$app = JFactory::getApplication();
		$app->JComponentTitle = $html;
		JFactory::getDocument()->setTitle(strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . JText::_('JADMINISTRATION'));
		$bar = JToolBar::getInstance('toolbar');
		$bar->appendButton('Popup', 'new', 'JTOOLBAR_NEW', 'index.php?option=com_externallogin&amp;view=plugins&amp;tmpl=component', 800, 400);
		$bar->appendButton('Standard', 'edit', 'JTOOLBAR_EDIT', 'server.edit', true);
		$bar->appendButton('Standard', 'publish', 'JTOOLBAR_PUBLISH', 'servers.publish', true);
		$bar->appendButton('Standard', 'unpublish', 'JTOOLBAR_UNPUBLISH', 'servers.unpublish', true);
		$bar->appendButton('Standard', 'checkin', 'JTOOLBAR_CHECKIN', 'servers.checkin', true);

		if ($this->state->get('filter.published') == - 2)
		{
			$bar->appendButton('Confirm', 'COM_EXTERNALLOGIN_MSG_SERVERS_DELETE', 'delete', 'servers.delete', 'servers.delete', true);
		}
		else
		{
			$bar->appendButton('Standard', 'archive', 'JTOOLBAR_ARCHIVE', 'servers.archive', true);
			$bar->appendButton('Standard', 'trash', 'JTOOLBAR_TRASH', 'servers.trash', true, false);
			$bar->appendButton('Separator', 'divider');
		}

		$bar->appendButton('Standard', 'upload', 'COM_EXTERNALLOGIN_TOOLBAR_SERVER_UPLOAD', 'server.upload', true);
		$bar->appendButton('Standard', 'download', 'COM_EXTERNALLOGIN_TOOLBAR_SERVER_DOWNLOAD', 'server.download', true);
		$return = urlencode(base64_encode((string) JUri::getInstance()));
		$bar->appendButton('Link', 'options', 'JToolbar_Options', 'index.php?option=com_config&amp;view=component&amp;component=com_externallogin&amp;return=' . $return);
		$bar->appendButton('Separator', 'divider');
		$bar->appendButton('Help', 'COM_EXTERNALLOGIN_HELP_MANAGER_SERVERS', false, null, null);

		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), 'index.php?option=com_externallogin', true);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), 'index.php?option=com_externallogin&view=users', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), 'index.php?option=com_externallogin&view=logs', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), 'index.php?option=com_externallogin&view=about', false);

		JHtml::_('sidebar.setaction', 'index.php?option=com_externallogin&view=servers');

		JHtml::_(
			'sidebar.addFilter',
			JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_PLUGIN'),
			'filter_plugin',
			JHtml::_('select.options', ExternalloginHelper::getPlugins(), 'value', 'text', $this->state->get('filter.plugin'), true)
		);

		JHtml::_(
			'sidebar.addFilter',
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
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
			'a.title' => JText::_('JGLOBAL_TITLE'),
			'e.ordering' => JText::_('COM_EXTERNALLOGIN_HEADING_PLUGIN'),
			'a.published' => JText::_('JSTATUS'),
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
