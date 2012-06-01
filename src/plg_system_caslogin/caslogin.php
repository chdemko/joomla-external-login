<?php

/**
 * @package     External Login
 * @subpackage  CAS Plugin
 * @copyright   Copyright (C) 2008-2012 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.database.table');
JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_externallogin/tables');

jimport('joomla.application.component.model');
JModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_externallogin/models', 'ExternalloginModel');

JLoader::register('ExternalloginHelper', JPATH_ADMINISTRATOR . '/components/com_externallogin/helpers/externallogin.php');

/**
 * External Login - CAS plugin.
 *
 * @package     External Login
 * @subpackage  CAS Plugin
 *
 * @since  2.0.0
 */
class plgSystemCaslogin extends JPlugin
{
	/**
	 * @var    ExternalloginTableServer
	 * @since  2.0.0
	 */
	protected $server;

	/**
	 * @var    DOMXPath  The xpath object
	 * @since  2.0.0
	 */
	protected $xpath;

	/**
	 * @var    DOMNode  The success node
	 * @since  2.0.0
	 */
	protected $success;

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
	 * Get icons.
	 *
	 * @param   string  $context  The calling context
	 *
	 * @since   2.0.0
	 */
	public function onGetIcons($context)
	{
		if ($context == 'com_externallogin')
		{
			return array(
				array(
					'image' => 'plg_system_caslogin/administrator/icon-48-caslogin.png',
					'link' => JRoute::_('index.php?option=com_externallogin&task=server.add&plugin=system.caslogin'),
					'alt' => JText::_('PLG_SYSTEM_CASLOGIN_ALT'),
					'text' => JText::_('PLG_SYSTEM_CASLOGIN_TEXT'),
					'target' => '_parent'
				)
			);
		}
		else
		{
			return array();
		}
	}

	/**
	 * Get option.
	 *
	 * @param   string  $context  The calling context
	 *
	 * @since   2.0.0
	 */
	public function onGetOption($context)
	{
		if ($context == 'com_externallogin')
		{
			return array('value' => 'system.caslogin', 'text' => 'PLG_SYSTEM_CASLOGIN_OPTION');
		}
	}

	/**
	 * Prepare Form
	 *
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 *
	 * @since	2.0.0
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		// Check we are manipulating a valid form.
		if ($form->getName() != 'com_externallogin.server.system.caslogin') {
			return true;
		}

		// Add the registration fields to the form.
		JForm::addFormPath(dirname(__FILE__) . '/forms');
		$form->loadFile('cas', false);
		return true;
	}

	/**
	 * After initialise event
	 *
	 * @return	void
	 *
	 * @since	2.0.0
	 */
	public function onAfterInitialise()
	{
		// If the user is not connected
		if (JFactory::getUser()->guest)
		{
			// Get the application
			$app = JFactory::getApplication();

			// Get the dbo
			$db = JFactory::getDbo();

			// Get the input
			$input = $app->input;

			// Get the service
			$uri = JFactory::getURI();

			// Get the ticket and the server
			$ticket = $input->get('ticket');
			$sid = $input->getInt('server');

			// If ticket and server exist
			if (!empty($ticket) && !empty($sid))
			{
				// Load the server
				$server = JTable::getInstance('Server', 'ExternalloginTable');
				if ($server->load($sid) && $server->plugin == 'system.caslogin')
				{
					$uri->delVar('ticket');

					// Verify the service
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_URL, $this->getUrl($server->params) . '/serviceValidate?ticket=' . $ticket . '&service=' . urlencode($uri));
					curl_setopt($curl, CURLOPT_TIMEOUT, $server->params->get('timeout'));
					$result = curl_exec($curl);
					curl_close($curl);

					// Result is not empty
					if (!empty($result))
					{
						$dom = new DOMDocument;
						$dom->loadXML($result);
						$xpath = new DOMXPath($dom);
						$success = $xpath->query('/cas:serviceResponse/cas:authenticationSuccess[1]');
						if ($success && $success->length == 1)
						{
							// Store the xpath
							$this->xpath = $xpath;

							// Store the success node
							$this->success = $success->item(0);

							// Store the server
							$this->server = $server;

							$uri->delVar('server');
							$return = 'index.php' . $uri->toString(array('query'));
							if ($return == 'index.php?option=com_login')
							{
								$return = 'index.php';
							}

							// Prepare the connection process
							if ($app->isAdmin())
							{
								$input->set('option', 'com_login');
								$input->set('task', 'login');
								$input->set(JSession::getFormToken(), 1);
								$input->set('return', base64_encode($return));

								// Keep compatibility with old plugins
								JRequest::setVar('option', 'com_login');
								JRequest::setVar('task', 'login');
								JRequest::setVar(JSession::getFormToken(), 1);
								JRequest::setVar('return', base64_encode($return));
							}
							else
							{
								$input->set('option', 'com_users');
								$input->set('task', 'user.login');
								$input->post->set(JSession::getFormToken(), 1);
								$input->post->set('return', base64_encode($return));

								// Keep compatibility with old plugins
								JRequest::setVar('option', 'com_users');
								JRequest::setVar('task', 'user.login');

								// TODO JInput is buggy. This must removed
								JRequest::setVar(JSession::getFormToken(), 1, 'post');

								// TODO JInput is buggy. This must removed
								JRequest::setVar('return', base64_encode($return), 'post');
							}
						}
					}
				}
			}
			else
			{
				// Get CAS servers
				$model = JModel::getInstance('Servers', 'ExternalloginModel', array('ignore_request' => true));
				$model->setState('filter.published', 1);
				$model->setState('filter.plugin', 'system.caslogin');
				$model->setState('list.start', 0);
				$model->setState('list.limit', 0);
				$model->setState('list.ordering', 'a.ordering');
				$model->setState('list.direction', 'ASC');
				$servers = $model->getItems();

				// Try to autologin for some servers
				$session = JFactory::getSession();
				foreach ($servers as $server)
				{
					$params = new JRegistry($server->params);
					if ($params->get('autologin') == 1 && !$session->get('system.caslogin.autologin.' . $server->id))
					{
						$uri->setVar('server', $server->id);
						$session->set('system.caslogin.autologin.' . $server->id, 1);
						$app->redirect($this->getUrl($params) . '/login?service=' . urlencode($uri) . '&gateway=true');
					}
				}

				// Remove server var
				if ($uri->hasVar('server') || $uri->hasVar('ticket'))
				{
					$uri->delVar('ticket');
					$uri->delVar('server');
					$app->redirect($uri);
				}
			}
		}
	}

	/**
	 * Get Login URL
	 *
	 * @param	object  $server   The CAS server.
	 * @param	string  $service  The asked service.
	 *
	 * @return	void|string
	 *
	 * @since	2.0.0
	 */
	public function onGetLoginUrl($server, $service)
	{
		if ($server->plugin == 'system.caslogin')
		{
			// Return the login URL
			return $this->getUrl($server->params) . '/login?service=' . urlencode($service);
		}
	}

	/**
	 * External Login event
	 *
	 * @param   JAuthenticationResponse  &$response  Response to the login process
	 *
	 * @return	void|true
	 *
	 * @since	2.0.0
	 */
	public function onExternalLogin(&$response)
	{
		if (isset($this->success))
		{
			// Prepare response
			$response->status = JAuthentication::STATUS_SUCCESS;
			$response->server = $this->server;
			$response->type = 'system.caslogin';

			// Compute username
			$response->username = $this->xpath->evaluate($this->server->params->get('username_xpath'), $this->success);

			// Compute email
			$response->email = $this->xpath->evaluate($this->server->params->get('email_xpath'), $this->success);

			// Compute name
			$response->fullname = $this->xpath->evaluate($this->server->params->get('name_xpath'), $this->success);

			// Compute groups
			if ($this->server->params->get('group_xpath'))
			{
				$groups = $this->xpath->query($this->server->params->get('group_xpath'), $this->success);
				if ($groups && $groups->length > 0)
				{
					$response->groups = array();

					// Loop on each group attribute
					for ($i = 0; $i < $groups->length; $i++)
					{
						$group = (string) $groups->item($i)->nodeValue;
						if (is_numeric($group))
						{
							// Group is numeric
							$response->groups[] = $group;
						}
						else
						{
							// Group is not numeric, extract the groups
							$response->groups = array_merge($response->groups, (array) ExternalloginHelper::getGroups($group));											
						}
					}
				}
			}
			return true;
		}
	}

	/**
	 * Get server URL
	 *
	 * @param	JRegistry  $params  The CAS parameters.
	 *
	 * @return	string  The server URL
	 *
	 * @since	2.0.0
	 */
	protected function getUrl($params)
	{
		// Get the parameters
		$url = $params->get('url');
		$dir = $params->get('dir');
		$port = (int) $params->get('port');

		// Return the server URL
		return 'https://' . $url . ($port && $port != 443 ? (':' . $port) : '') . ($dir ? ('/' . $dir) : '');
	}

	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @param	array  $user     Holds the user data.
	 * @param	array  $options  Array holding options (client, ...).
	 *
	 * @return	boolean  True on success
	 *
	 * @since	2.0.0
	 */
	public function onUserLogout($user, $options = array())
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__externallogin_servers AS a');
		$query->leftJoin('#__externallogin_users AS e ON e.server_id = a.id');
		$query->where('a.plugin = ' . $db->quote('system.caslogin'));
		$query->where('e.user_id = ' . (int) $user['id']);
		$db->setQuery($query);
		$server = $db->loadObject();
		if ($server)
		{
			// Destroy session
			$my 		= JFactory::getUser();
			$session 	= JFactory::getSession();
			$app 		= JFactory::getApplication();

			// Make sure we're a valid user first
			if ($user['id'] == 0 && !$my->get('tmp_user')) {
				return true;
			}

			// Check to see if we're deleting the current session
			if ($my->get('id') == $user['id'] && $options['clientid'] == $app->getClientId()) {
				// Hit the user last visit field
				$my->setLastVisit();

				// Destroy the php session for this user
				$session->destroy();
			}

			// Force logout all users with that userid
			$db = JFactory::getDBO();
			$db->setQuery(
				'DELETE FROM '.$db->quoteName('#__session') .
				' WHERE '.$db->quoteName('userid').' = '.(int) $user['id'] .
				' AND '.$db->quoteName('client_id').' = '.(int) $options['clientid']
			);
			$db->query();

			// Logout from CAS
			$params = new JRegistry($server->params);
			if ($params->get('autologin') && $my->get('id') == $user['id'])
			{
				if ($params->get('logouturl'))
				{
					$redirect = $this->getUrl($params) . '/logout?url=' . urlencode($params->get('logouturl'));
				}
				else
				{
					$redirect = $this->getUrl($params) . '/logout';
				}
				$app->redirect($redirect);
			}
		}
		return true;
	}
}
