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

/**
 * Server Controller of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.3.0
 */
class ExternalloginControllerServer extends JController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string      $name    Model name
	 * @param   string      $prefix  Model prefix
	 * @param   array|null  $config  Options
	 *
	 * @return  JModel
	 *
	 * @see     JController::getModel
	 *
	 * @since   2.3.0
	 */
	public function getModel($name = 'Server', $prefix = 'ExternalloginModel', $config = null)
	{
		return parent::getModel($name, $prefix, isset($config) ? $config : array('ignore_request' => true));
	}

	/**
	 * Login task.
	 *
	 * @return  void
	 *
	 * @since   2.3.0
	 */
	public function login()
	{
		JSession::checkToken('post') or jexit(JText::_('JInvalid_Token'));

		// Get the model
		$model = $this->getModel();

		// Get the uri
		$uri = $model->getItem();

		if (empty($uri))
		{
			$this->setMessage($model->getError(), 'warning');
			$this->setRedirect('index.php', false);
		}
		else
		{
			$this->setRedirect(JRoute::_($uri, false));
		}
	}
}
