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
 * External Login - External Login entry.
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       2.1.0
 */
class ExternalloginLogEntry extends JLogEntry
{
	/**
	 * Constructor
	 *
	 * @param   string  $message   The message to log.
	 * @param   string  $priority  Message priority based on {$this->priorities}.
	 * @param   string  $category  Type of entry
	 * @param   string  $date      Date of entry (defaults to now if not specified or blank)
	 *
	 * @since   11.1
	 */
	public function __construct($message, $priority = JLog::INFO, $category = '', $date = null)
	{
		if (empty($date))
		{
			list($microtime, $time) = explode(' ', microtime());
			$date = date('Y-m-d H:i:s', $time) . trim($microtime, '0');
		}

		parent::__construct($message, $priority, $category, $date);
	}
}
