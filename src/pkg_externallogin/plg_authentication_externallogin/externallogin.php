<?php

/**
 * @package     External Login
 * @subpackage  External Login Plugin
 * @copyright   Copyright (C) 2008-2012 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * External Login - External Login plugin.
 *
 * @package     External Login
 * @subpackage  External Login Plugin
 *
 * @since  2.0.0
 */
class plgAuthenticationExternallogin extends JPlugin
{
	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 *
	 * @since   2.0.0
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param	array	Array holding the user credentials
	 * @param	array	Array of extra options
	 * @param	object	Authentication response object
	 * @return	boolean
	 * @since 1.5
	 */
	public function onUserAuthenticate($credentials, $options, &$response)
	{
		$results = JFactory::getApplication()->triggerEvent('onExternalLogin', array(&$response));
		if (count($results) > 0)
		{
			// Get server params
			$params = $response->server->params;

			// Import JComponentHelper library
			jimport('joomla.application.component.helper');

			// Get com_users parameters
			$config	= JComponentHelper::getParams('com_users');

			// Get default user group.
			$defaultUserGroup = $params->get('usergroup', $config->get('new_usertype', 2));

			// Get a user
			$user = JUser::getInstance();
			if ($id = intval(JUserHelper::getUserId($response->username)))
			{
				// User is found
				$user->load($id);
				if ($params->get('autoupdate', 0))
				{
					// Update it on auto-update
					$user->set('name', $response->fullname);
					$user->set('email', $response->email);
					if (isset($response->groups))
					{
						$user->set('groups', $response->groups);
					}
					$user->save();
				}
				$response->id = $id;
				$response->status = JAuthentication::STATUS_SUCCESS;
			}
			elseif ($params->get('autoregister', 0))
			{
				// User is not found
				$user->set('id', 0);
				$user->set('name', $response->fullname);
				$user->set('username', $response->username);
				$user->set('email', $response->email);
				$user->set('usertype', 'deprecated');
				$user->set('groups', empty($response->groups) ? array($defaultUserGroup) : $response->groups);

				// Create new user
				if ($user->save())
				{
					$response->status = JAuthentication::STATUS_SUCCESS;
					$response->id = $user->id;
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->insert('#__externallogin_users')->columns('server_id, user_id')->values((int) $response->server->id . ',' . (int) $user->id);
					$db->setQuery($query);
					$db->query();
				}
				else
				{
					$response->status = JAuthentication::STATUS_UNKNOWN;
				}
			}
			else
			{
				$response->status = JAuthentication::STATUS_UNKNOWN;
			}
		}
		else
		{
			return false;
		}
	}
}
