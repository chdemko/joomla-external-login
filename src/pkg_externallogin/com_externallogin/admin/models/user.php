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

// Import Joomla model library
jimport('joomla.application.component.model');

/**
 * User Model of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.1.0
 */
class ExternalloginModelUser extends JModelLegacy
{
	/**
	 * Method to enable the Joomla login for a set of user.
	 *
	 * @param   array  $pks  A list of the primary keys to change.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.1.0
	 */
	public function enableJoomla(&$pks)
	{
		// Initialise variables.
		$table = JTable::getInstance('User');
		$pks = (array) $pks;

		// Attempt to change the state of the records.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk) && $table->password === '')
			{
				$table->password = 'empty';
				$table->store();
			}
			else
			{
				unset($pks[$i]);
			}
		}

		return true;
	}

	/**
	 * Method to disable the Joomla login for a set of user.
	 *
	 * @param   array  $pks  A list of the primary keys to change.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.1.0
	 */
	public function disableJoomla(&$pks)
	{
		// Initialise variables.
		$table = JTable::getInstance('User');
		$pks = (array) $pks;

		// Attempt to change the state of the records.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk) && $table->password !== '')
			{
				$query = $this->_db->getQuery(true);
				$query->select('user_id');
				$query->from('#__externallogin_users');
				$query->where('user_id = ' . (int) $pk);
				$this->_db->setQuery($query);

				if ($this->_db->loadResult())
				{
					$table->password = '';
					$table->store();
				}
				else
				{
					unset($pks[$i]);
				}
			}
			else
			{
				unset($pks[$i]);
			}
		}

		return true;
	}

	/**
	 * Method to disable the external login for a set of user.
	 *
	 * @param   array  $pks  A list of the primary keys to change.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.1.0
	 */
	public function disableExternallogin(&$pks)
	{
		// Initialise variables.
		$table = JTable::getInstance('User');
		$pks = (array) $pks;

		// Attempt to change the state of the records.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk) && $table->password !== '')
			{
				$query = $this->_db->getQuery(true);
				$query->select('user_id');
				$query->from('#__externallogin_users');
				$query->where('user_id = ' . (int) $pk);
				$this->_db->setQuery($query);

				if ($this->_db->loadResult())
				{
					$query = $this->_db->getQuery(true);
					$query->delete();
					$query->from('#__externallogin_users');
					$query->where('user_id = ' . (int) $pk);
					$this->_db->setQuery($query);
					$this->_db->execute();
				}
				else
				{
					unset($pks[$i]);
				}
			}
			else
			{
				unset($pks[$i]);
			}
		}

		return true;
	}

	/**
	 * Method to disable the external login for a set of user.
	 *
	 * @param   array    $sid   Server id.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.1.0
	 */
	public function disableExternalloginGlobal($sid)
	{

		// Attempt to change the state of the records.
		$query = $this->_db->getQuery(true);
		$query->select("user_id");
		$query->from("#__externallogin_users");
		$query->where("server_id = '$sid'");
		$this->_db->setQuery($query);

		// Get application
		$app = JFactory::getApplication();

		try
		{
			$userID = $this->_db->loadResult();
		}
		catch (Exception $exc)
		{
			$app->enqueueMessage($exc->getMessage(), 'error');
		}

		if (!empty($userID))
		{
			$query = $this->_db->getQuery(true);
			$query->delete();
			$query->from("#__externallogin_users");
			$query->where("server_id = '$sid'");
			$this->_db->setQuery($query);

			try
			{
				$this->_db->execute();
			}
			catch (Exception $exc)
			{
				$app->enqueueMessage($exc->getMessage(), 'error');
			}
		}

		return true;
	}

	/**
	 * Method to enable the external login for a set of user.
	 *
	 * @param   array    $pks  A list of the primary keys to change.
	 * @param   integer  $sid  The server id
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.1.0
	 */
	public function enableExternallogin(&$pks, $sid)
	{
		// Initialise variables.
		$table = JTable::getInstance('User');
		$pks = (array) $pks;

		// Attempt to change the state of the records.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk))
			{
				$query = $this->_db->getQuery(true);
				$query->select('user_id');
				$query->from('#__externallogin_users');
				$query->where('user_id = ' . (int) $pk);
				$this->_db->setQuery($query);

				$query = $this->_db->getQuery(true);
				$query->set('server_id = ' . (int) $sid);

				if ($this->_db->loadResult())
				{
					$query->update('#__externallogin_users');
					$query->where('user_id = ' . (int) $pk);
				}
				else
				{
					$query->insert('#__externallogin_users');
					$query->set('user_id = ' . (int) $pk);
				}

				$this->_db->setQuery($query);
				$this->_db->execute();
			}
			else
			{
				unset($pks[$i]);
			}
		}

		return true;
	}

	/**
	 * Method to enable the external login for all users.
	 *
	 * @throws  Exception
	 * @param   integer  $sid    The server id
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.1.1
	 */
	public function enableExternalloginGlobal($sid)
	{
		// Get application
		$app = JFactory::getApplication();

		// Get all user id's
		$query = $this->_db->getQuery(true);
		$query->select('id');
		$query->from('#__users');
		$this->_db->setQuery($query);

		try
		{
			$column = $this->_db->loadColumn();
		}
		catch (Exception $exc)
		{
			$app->enqueueMessage($exc->getMessage(), 'error');
		}

		// Check if user is already activated and update/insert value
		foreach ($column as $userID)
		{
			$query = $this->_db->getQuery(true);
			$query->select("user_id");
			$query->from("#__externallogin_users");
			$query->where("user_id = '$userID'");
			$this->_db->setQuery($query);

			// Get result if user is already activated
			try
			{
				$success = $this->_db->loadResult();
			}
			catch (Exception $exc)
			{
				$app->enqueueMessage($exc->getMessage(), 'error');
			}

			$query = $this->_db->getQuery(true);
			$query->set("server_id = '$sid'");

			// Update if already activated/insert if not
			if ($success)
			{
				$query->update("#__externallogin_users");
				$query->where("user_id = '$userID'");
			}
			else
			{
				$query->insert("#__externallogin_users");
				$query->set("user_id = '$userID'");
			}

			$this->_db->setQuery($query);

			try
			{
				$this->_db->execute();
			}
			catch (Exception $exc)
			{
				$app->enqueueMessage($exc->getMessage(), 'error');
			}
		}

		return true;
	}
}
