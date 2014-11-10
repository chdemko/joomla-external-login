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
 * Log View of External Login component
 * 
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
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
		$basename = $this->get('BaseName');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$document = JFactory::getDocument();
		$document->setMimeEncoding('text/csv');
		JResponse::setHeader('Content-disposition', 'attachment; filename="'.$basename.'.csv'.'"; creation-date="'.JFactory::getDate()->toRFC822().'"', true);
		$this->get('Content');
	}
}

