<?php

/**
 * @package    External Login
 * @subpackage Component
 * @copyright  Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author     Christophe Demko
 * @author     Ioannis Barounis
 * @author     Alexandre Gandois
 * @link       http://www.chdemko.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * Server Controller of External Login component
 * 
 * @package    External Login
 * @subpackage Component
 *             
 * @since      2.0.0
 */
class ExternalloginControllerServer extends JControllerForm
{
	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param   integer  $recordId  The primary key id for the item.
	 * @param   string   $urlVar    The name of the URL variable for the id.
	 *
	 * @return  string  The arguments to append to the redirect URL.
	 *
	 * @see  JControllerForm::getRedirectToItemAppend
	 *
	 * @since   2.0.0
	 */
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id') 
	{
		$plugin = JFactory::getApplication()->input->get('plugin', '');
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);
		if (!empty($plugin)) 
		{
			$append.= '&plugin=' . $plugin;
		}
		return $append;
	}

	/**
	 * Download users
	 */
	public function download()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');

		$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=download&format=csv&id=' . $cid[0], false));
		return true;
	}

	/**
	 * Upload users
	 */
	public function upload()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$form = JFactory::getApplication()->input->get('jform', array(), 'array');
		$id = (int) $form['id'];

		$model = $this->getModel();
		if ($model->upload($form))
		{
			$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=success&tmpl=component', false), JText::_('COM_EXTERNALLOGIN_MSG_UPLOAD_SUCCESS'));
		}
		else
		{
			$this->setRedirect(JRoute::_('index.php?option=com_externallogin&view=upload&tmpl=component&id=' . $id, false), $model->getError(), 'error');
		}
	}
}
