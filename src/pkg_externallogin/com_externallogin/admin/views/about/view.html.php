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
 * About View of External Login component
 * @package     External Login
 * @subpackage  Component
 * @since       2.0.0
 */
class ExternalloginViewAbout extends JViewLegacy {

    /**
     * Execute and display a layout script.
     *
     * @param   string $tpl The name of the layout file to parse.
     *
     * @return  void|JError
     * @see     Overload JView::display
     * @since   2.0.0
     */
    public function display($tpl = null) {
        // Set the toolbar
        $this->addToolBar();

        $this->sidebar = JHtml::_('sidebar.render');

        // Display the template
        parent::display($tpl);
    }

    /**
     * Setting the toolbar
     * @since   2.0.0
     */
    protected function addToolbar() {
        // Load specific css component
        JHtml::_('stylesheet', 'com_externallogin/administrator/externallogin.css', array(), true);

        // Set the title
        JToolBarHelper::title(JText::_('COM_EXTERNALLOGIN_MANAGER_ABOUT'), 'help');

        JToolBarHelper::preferences('com_externallogin');
        JToolBarHelper::divider();
        JToolBarHelper::help('COM_EXTERNALLOGIN_HELP_MANAGER_ABOUT');

        JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_SERVERS'), 'index.php?option=com_externallogin', false);
        JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_USERS'), 'index.php?option=com_externallogin&view=users', false);
        JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_LOGS'), 'index.php?option=com_externallogin&view=logs', false);
        JHtml::_('sidebar.addentry', JText::_('COM_EXTERNALLOGIN_SUBMENU_ABOUT'), 'index.php?option=com_externallogin&view=about', true);
    }
}

