<?php

/**
 * @package     External Login
 * @subpackage  Community Builder External Login Plugin
 * @copyright   Copyright (C) 2008-2013 Christophe Demko. All rights reserved.
 * @author      Christophe Demko
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * External Login - Community Builder External Login Plugin.
 *
 * @package     External Login
 * @subpackage  Community Builder External Login Plugin
 *
 * @since  2.0.0
 */
class plgUserCbexternallogin extends JPlugin
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
	 * This method should handle any login logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data
	 * @param	array	$options	Array holding options (remember, autoregister, group)
	 *
	 * @return	boolean	True on success
	 *
	 * @since	2.0.0
	 */
	public function onUserLogin($user, $options = array())
	{
		// User comes from external login plugin and community builder is installed and enabled
		if (isset($user['server']) && JComponentHelper::getComponent('com_comprofiler', true)->enabled)
		{
			// Verify if user is stored into community builder
			$dbo = JFactory::getDbo();
			$query = $dbo->getQuery(true);
			$query->select('COUNT(*)');
			$query->from('#__comprofiler');
			$query->where('id = ' . (int) $user['id']);
			$dbo->setQuery($query);

			// User does not exist in community builder
			if ($dbo->loadResult() == 0)
			{
				// Prepare query for insertion in community builder
				$query = $dbo->getQuery(true);
				$query->insert('#__comprofiler');
				$query->columns('id, user_id, confirmed, approved');

				// Server is set to autoregister
				if ($user['server']->params->get('autoregister', 0))
				{
					$query->values((int) $user['id'] . ',' . (int) $user['id'] . ', 1, 1');
				}
				// Server is not set to autoregister
				else
				{
					$query->values((int) $user['id'] . ',' . (int) $user['id'] . ', 0, 0');
				}
				$dbo->setQuery($query);
				$dbo->execute();
			}
		}
		return true;
	}
}
