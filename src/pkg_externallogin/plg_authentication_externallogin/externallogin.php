<?php

/**
 * @package     External_Login
 * @subpackage  External Login Plugin
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2017 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access to this file
defined('_JEXEC') or die;
if (version_compare( JVERSION, '3.8.0', '>=' ))
{
	JLoader::registerAlias('JLogLoggerExternallogin','\\Joomla\\CMS\\Log\\Logger\\ExternalloginLogger');	
}
JLoader::register('JLogLoggerExternallogin', JPATH_ADMINISTRATOR . '/components/com_externallogin/log/logger.php');
JLoader::register('ExternalloginLogEntry', JPATH_ADMINISTRATOR . '/components/com_externallogin/log/entry.php');

/**
 * External Login - External Login plugin.
 *
 * @package     External_Login
 * @subpackage  External Login Plugin
 *
 * @since       2.0.0
 */
class PlgAuthenticationExternallogin extends JPlugin
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
		JLog::addLogger(
			array('logger' => 'externallogin', 'db_table' => '#__externallogin_logs', 'plugin' => 'authentication-externallogin'),
			JLog::ALL,
			array('authentication-externallogin-autoregister', 'authentication-externallogin-autoupdate')
		);
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @param   array   $credentials  Array holding the user credentials
	 * @param   array   $options      Array of extra options
	 * @param   object  &$response    Authentication response object
	 *
	 * @return	boolean
	 */
	public function onUserAuthenticate($credentials, $options, &$response)
	{
		$results = JFactory::getApplication()->triggerEvent('onExternalLogin', array(&$response));

		if (count($results) > 0)
		{
			// Get the DB driver
			$db = JFactory::getDbo();

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
				if ($params->get('autoupdate', 0))
				{
					// User is found
					$user->load($id);

					// Update it on auto-update
					$user->set('name', $response->fullname);
					$user->set('email', $response->email);

					// Get the old groups
					$query = $db->getQuery(true);
					$query->select('group_id')->from('#__user_usergroup_map')->where('user_id = ' . (int) $id);
					$db->setQuery($query);
					$oldgroups = $db->loadColumn();

					// Delete the old groups
					$query = $db->getQuery(true);
					$query->delete('#__user_usergroup_map')->where('user_id = ' . (int) $id);
					$db->setQuery($query);
					$db->execute();

					$user->groups = null;

					// Attempt to save the user
					if ($user->save())
					{
						if ($params->get('log_autoupdate', 0))
						{
							// Log autoupdate
							JLog::add(
								new ExternalloginLogEntry(
									'Auto-update of user "'
										. $user->username
										. '" with fullname "'
										. $response->fullname
										. '" and email "'
										. $response->email
										. '" on server '
										. $response->server->id,
									JLog::INFO,
									'authentication-externallogin-autoupdate'
								)
							);
						}

						$response->status = JAuthentication::STATUS_SUCCESS;
						$response->id = $id;
						$groups = empty($response->groups) ? $oldgroups : $response->groups;

						// Add the groups
						$query = $db->getQuery(true);
						$query->insert('#__user_usergroup_map')->columns('user_id, group_id');

						foreach ($groups as $group)
						{
							$query->values((int) $id . ',' . (int) $group);
						}

						$db->setQuery($query);
						$db->execute();

						if (!empty($response->groups) && $params->get('log_autoupdate', 0))
						{
							// Log autoupdate
							JLog::add(
								new ExternalloginLogEntry(
									'Auto-update new groups of user "' . $user->username . '" with groups (' . implode(',', $groups) . ') on server ' . $response->server->id,
									JLog::INFO,
									'authentication-externallogin-autoupdate'
								)
							);
						}

						// Check for an existing externallogin_users record. If none, create one.
						$query = $db->getQuery(true);
						$query->select('*')->from('#__externallogin_users')->where('user_id = ' . $id);
						$db->setQuery($query);
						$results = $db->loadObject();

						if (!$results)
						{
							$query = $db->getQuery(true);
							$query->insert('#__externallogin_users')->columns('server_id, user_id')->values((int) $response->server->id . ',' . (int) $id);
							$db->setQuery($query);
							$db->execute();
						}
					}
					else
					{
						// Add the old groups
						$query = $db->getQuery(true);
						$query->insert('#__user_usergroup_map')->columns('user_id, group_id');

						foreach ($oldgroups as $group)
						{
							$query->values((int) $id . ',' . (int) $group);
						}

						$db->setQuery($query);
						$db->execute();

						if ($params->get('log_autoupdate', 0))
						{
							// Log autoupdate
							JLog::add(
								new ExternalloginLogEntry(
									$user->getError(),
									JLog::ERROR,
									'authentication-externallogin-autoupdate'
								)
							);
						}

						$response->status = JAuthentication::STATUS_UNKNOWN;
					}

					JAccess::clearStatics();
				}
				else
				{
					$response->status = JAuthentication::STATUS_SUCCESS;
					$response->id = $id;
				}
			}
			elseif ($params->get('autoregister', 0))
			{
				// User is not found
				$user->set('id', 0);
				$user->set('name', $response->fullname);
				$user->set('username', $response->username);
				$user->set('email', $response->email);
				$user->set('usertype', 'deprecated');

				// Create new user
				if ($user->save())
				{
					$response->status = JAuthentication::STATUS_SUCCESS;
					$response->id = $user->id;

					$query = $db->getQuery(true);
					$query->insert('#__externallogin_users')->columns('server_id, user_id')->values((int) $response->server->id . ',' . (int) $user->id);
					$db->setQuery($query);
					$db->execute();

					if ($params->get('log_autoregister', 0))
					{
						// Log autoregister
						JLog::add(
							new ExternalloginLogEntry(
								'Auto-register of user "'
									. $user->username
									. '" with fullname "'
									. $response->fullname
									. '" and email "'
									. $response->email
									. '" on server '
									. $response->server->id,
								JLog::INFO,
								'authentication-externallogin-autoregister'
							)
						);
					}

					// Add the new groups
					$groups = empty($response->groups) ? array($defaultUserGroup) : $response->groups;
					$query = $db->getQuery(true);
					$query->insert('#__user_usergroup_map')->columns('user_id, group_id');

					foreach ($groups as $group)
					{
						$query->values((int) $user->id . ',' . (int) $group);
					}

					$db->setQuery($query);
					$db->execute();

					if ($params->get('log_autoregister', 0))
					{
						if (empty($response->groups))
						{
							// Log autoregister
							JLog::add(
								new ExternalloginLogEntry(
									'Auto-register default group "' . $defaultUserGroup . '" for user "' . $user->username . '" on server ' . $response->server->id,
									JLog::INFO,
									'authentication-externallogin-autoregister'
								)
							);
						}
						else
						{
							// Log autoregister
							JLog::add(
								new ExternalloginLogEntry(
									'Auto-register new groups for user "' . $user->username . '" with groups (' . implode(',', $groups) . ') on server ' . $response->server->id,
									JLog::INFO,
									'authentication-externallogin-autoregister'
								)
							);
						}
					}
				}
				else
				{
					if ($params->get('log_autoregister', 0))
					{
						// Log autoregister
						JLog::add(
							new ExternalloginLogEntry(
								$user->getError(),
								JLog::ERROR,
								'authentication-externallogin-autoregister'
							)
						);
					}

					$response->status = JAuthentication::STATUS_UNKNOWN;
				}
				JAccess::clearStatics();
			}
			else
			{
				JLog::add(
					new ExternalloginLogEntry(
						'User "' . $user->username . '" is trying to register while auto-register is disabled',
						JLog::WARNING,
						'authentication-externallogin-autoregister'
					)
				);
				$response->status = JAuthentication::STATUS_UNKNOWN;
			}

			return true;
		}
		else
		{
			return false;
		}
	}
}
