<?php

/**
 * @package     External Login
 * @subpackage  Component
 * @copyright   Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @author      Christophe Demko
 * @author      Ioannis Barounis
 * @author      Alexandre Gandois
 * @link        http://www.chdemko.com
 * @license     http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * External Login - External Login logger.
 *
 * @package     External Login
 * @subpackage  Component
 *
 * @since  2.1.0
 */
class JLoggerExternallogin extends JLoggerDatabase
{
	/**
	 * Method to add an entry to the log.
	 *
	 * @param   JLogEntry  $entry  The log entry object to add to the log.
	 *
	 * @return  void
	 *
	 * @since   2.1.0
	 */
	public function addEntry(JLogEntry $entry)
	{
		if ($entry instanceof ExternalloginLogEntry)
		{
			// Connect to the database if not connected.
			if (empty($this->dbo))
			{
				$this->connect();
			}

			// Convert the date.
			$entry->date = $entry->date->format('U.u');

			$this->dbo->insertObject($this->table, $entry);
		}
	}
}
