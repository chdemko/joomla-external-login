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
 * Users View of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.1.0
 */
class ExternalloginViewUsers extends JViewLegacy
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

		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), 'index.php?option=com_externallogin', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), 'index.php?option=com_externallogin&view=users', true);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), 'index.php?option=com_externallogin&view=logs', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), 'index.php?option=com_externallogin&view=about', false);

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

		$bar = JToolBar::getInstance('toolbar');

		// Set the toolbar
		$title = JText::_('COM_EXTERNALLOGIN_MANAGER_USERS');
		$layout = new JLayoutFile('joomla.toolbar.title');
		$html   = $layout->render(array('title' => $title, 'icon' => 'users'));
		$app = JFactory::getApplication();
		$app->JComponentTitle = $html;
		JFactory::getDocument()->setTitle(strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . JText::_('JADMINISTRATION'));

		// Add a standard button.
		$bar->appendButton(
			'Confirm',
			'COM_EXTERNALLOGIN_TOOLBAR_ENABLE_JOOMLA_MSG',
			'publish',
			'COM_EXTERNALLOGIN_TOOLBAR_ENABLE_JOOMLA',
			'users.enableJoomla',
			true
		);
		$bar->appendButton(
			'Confirm',
			'COM_EXTERNALLOGIN_TOOLBAR_DISABLE_JOOMLA_MSG',
			'unpublish',
			'COM_EXTERNALLOGIN_TOOLBAR_DISABLE_JOOMLA',
			'users.disableJoomla',
			true
		);
		$bar->appendButton(
			'Popup',
			'publish',
			'COM_EXTERNALLOGIN_TOOLBAR_ENABLE_EXTERNALLOGIN',
			'index.php?option=com_externallogin&amp;view=servers&amp;layout=modal&amp;tmpl=component',
			800,
			300,
			0,
			0,
			''
		);
		$bar->appendButton('Standard', 'unpublish', 'COM_EXTERNALLOGIN_TOOLBAR_DISABLE_EXTERNALLOGIN', 'users.disableExternallogin', true);
		$return = urlencode(base64_encode((string) JUri::getInstance()));
		$bar->appendButton('Link', 'options', 'JToolbar_Options', 'index.php?option=com_config&amp;view=component&amp;component=com_externallogin&amp;return=' . $return);
		$bar->appendButton('Separator', 'divider');
		$bar->appendButton('Help', 'COM_EXTERNALLOGIN_HELP_MANAGER_USERS', false, null, null);
		$bar->appendButton(
			'Popup',
			'edit',
			'COM_EXTERNALLOGIN_TOOLBAR_ENABLE_DISABLE_GLOBAL',
			'index.php?option=com_externallogin&amp;view=servers&amp;layout=modal&amp;tmpl=component&globalS=1',
			875,
			300,
			0,
			0,
			''
		);

		JHtml::_('sidebar.setaction', 'index.php?option=com_externallogin&view=users');

		JHtml::_(
			'sidebar.addFilter',
			JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_PLUGIN'),
			'filter_plugin',
			JHtml::_('select.options', ExternalloginHelper::getPlugins(), 'value', 'text', $this->state->get('filter.plugin'), true)
		);

		JHtml::_(
			'sidebar.addFilter',
			JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_SERVER'),
			'filter_server',
			JHtml::_(
				'select.options',
				ExternalloginHelper::getServers(array('ignore_request' => true)),
				'value',
				'text',
				$this->state->get('filter.server'),
				true
			)
		);

		JHtml::_(
			'sidebar.addFilter',
			JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_JOOMLA'),
			'filter_joomla',
			JHtml::_(
				'select.options',
				JHtml::_('jgrid.publishedOptions', array('archived' => false, 'trash' => false, 'all' => false)),
				'value',
				'text',
				$this->state->get('filter.joomla'),
				true
			)
		);

		JHtml::_(
			'sidebar.addFilter',
			JText::_('COM_EXTERNALLOGIN_OPTION_SELECT_EXTERNAL'),
			'filter_external',
			JHtml::_(
				'select.options',
				JHtml::_('jgrid.publishedOptions', array('archived' => false, 'trash' => false, 'all' => false)),
				'value',
				'text',
				$this->state->get('filter.external'),
				true
			)
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
			'a.username' => JText::_('COM_EXTERNALLOGIN_HEADING_USERNAME'),
			'a.name' => JText::_('COM_EXTERNALLOGIN_HEADING_NAME'),
			'a.email' => JText::_('COM_EXTERNALLOGIN_HEADING_EMAIL'),
			'a.plugin' => JText::_('COM_EXTERNALLOGIN_HEADING_PLUGIN'),
			's.title' => JText::_('COM_EXTERNALLOGIN_HEADING_SERVER'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
