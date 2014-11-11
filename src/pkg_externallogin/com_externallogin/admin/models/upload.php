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

// import Joomla modeladmin library
jimport('joomla.application.component.modeladmin');

/**
 * Upload Model of External Login component
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since	2.0.0
 */
class ExternalloginModelUpload extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   type    The table type to instantiate
	 * @param   string  A prefix for the table class name. Optional.
	 * @param   array   Configuration array for model. Optional.
	 *
	 * @return	JTable  A database object
	 *
	 * @see     JModel::getTable
	 *
	 * @since	2.0.0
	 */
	public function getTable($type = 'Server', $prefix = 'ExternalloginTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed	A JForm object on success, false on failure
	 *
	 * @see    JModelForm::getForm
	 *
	 * @since  2.0.0 
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_externallogin.upload', 'upload', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 *
	 * @since  2.0.0
	 */
	protected function loadFormData() 
	{
		return $this->getItem();
	}
}
