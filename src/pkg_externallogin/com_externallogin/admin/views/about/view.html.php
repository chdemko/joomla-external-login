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
 * About View of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 * @since       2.0.0
 */
class ExternalloginViewAbout extends JViewLegacy
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

		// Set the title
		$title = JText::_('COM_EXTERNALLOGIN_MANAGER_ABOUT');
		$layout = new JLayoutFile('joomla.toolbar.title');
		$html   = $layout->render(array('title' => $title, 'icon' => 'help'));
		$app = JFactory::getApplication();
		$app->JComponentTitle = $html;
		JFactory::getDocument()->setTitle(strip_tags($title) . ' - ' . $app->get('sitename') . ' - ' . JText::_('JADMINISTRATION'));

		$bar = JToolbar::getInstance('toolbar');
		$return = urlencode(base64_encode((string) JUri::getInstance()));
		$bar->appendButton('Link', 'options', 'JToolbar_Options', 'index.php?option=com_config&amp;view=component&amp;component=com_externallogin&amp;return=' . $return);
		$bar->appendButton('Separator', 'divider');
		$bar->appendButton('Help', 'COM_EXTERNALLOGIN_HELP_MANAGER_ABOUT', false, null, null);

		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), 'index.php?option=com_externallogin', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), 'index.php?option=com_externallogin&view=users', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), 'index.php?option=com_externallogin&view=logs', false);
		JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), 'index.php?option=com_externallogin&view=about', true);
	}
}
