-- @package     External Login
-- @subpackage  Component
-- @copyright   Copyright (C) 2008-2013 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @author      Christophe Demko
-- @author      Ioannis Barounis
-- @author      Alexandre Gandois
-- @link        http://www.chdemko.com
-- @license     http://www.gnu.org/licenses/gpl-2.0.html

CREATE TABLE IF NOT EXISTS `#__externallogin_servers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL,
	`published` TINYINT(3) NOT NULL,
	`plugin` VARCHAR(255) NOT NULL,
	`ordering` INT(11) NOT NULL,
	`checked_out` INT(11) NOT NULL,
	`checked_out_time` DATETIME NOT NULL,
	`params` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE (`title`)
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__externallogin_users` (
	`server_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	INDEX (`server_id`),
	INDEX (`user_id`),
	UNIQUE (`server_id`, `user_id`)
) DEFAULT CHARSET=utf8;

