<?php

/**
 * @package     External_Login
 * @subpackage  Component
 * @author      Christophe Demko <chdemko@gmail.com>
 * @author      Ioannis Barounis <contact@johnbarounis.com>
 * @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
 * @copyright   Copyright (C) 2008-2017 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
 * @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
 * @link        http://www.chdemko.com
 */

// No direct access
defined('_JEXEC') or die;

// Import Joomla table library
jimport('joomla.database.table');

/**
 * Server Table class of External Login component
 *
 * @package     External_Login
 * @subpackage  Component
 *
 * @since       0.0.1 
 */
class ExternalloginTableServer extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   object  &$db  Database connector object
	 *
	 * @see     JTable::__construct
	 *
	 * @since   2.0.0
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__externallogin_servers', 'id', $db);
	}

	/**
	 * Overloaded store function.
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success.
	 *
	 * @link	http://docs.joomla.org/JTable/store
	 * @since   2.0.0
	 */
	public function store($updateNulls = false)
	{
		if ($this->ordering == 0)
		{
			$query = $this->_db->getQuery(true);
			$query->select('MAX(ordering)');
			$query->from('#__externallogin_servers');
			$this->_db->setQuery($query);
			$this->ordering = $this->_db->loadResult() + 1;
		}

		if (is_array($this->params))
		{
			$this->params = (string) new JRegistry($this->params);
		}

		if (parent::store($updateNulls))
		{
			return $this->reorder();
		}
		else
		{
			return false;
		}
	}
}
