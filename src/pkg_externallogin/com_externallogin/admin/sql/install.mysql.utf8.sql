-- @package     External_Login
-- @subpackage  Component
-- @author      Christophe Demko <chdemko@gmail.com>
-- @author      Ioannis Barounis <contact@johnbarounis.com>
-- @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
-- @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
-- @link        http://www.chdemko.com

CREATE TABLE IF NOT EXISTS `#__externallogin_servers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(128) NOT NULL,
	`published` TINYINT(3) NOT NULL,
	`plugin` VARCHAR(128) NOT NULL,
	`ordering` INT(11) NOT NULL,
	`checked_out` INT(11) NOT NULL,
	`checked_out_time` DATETIME NOT NULL,
	`params` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__externallogin_users` (
	`server_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	INDEX (`server_id`),
	UNIQUE (`user_id`),
	UNIQUE (`server_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__externallogin_logs` (
	`priority` INT(11) NOT NULL DEFAULT 0,
	`category` VARCHAR(128) NOT NULL,
	`date` DECIMAL(20,6) NOT NULL,
	`message` MEDIUMTEXT NOT NULL,
	INDEX (`priority`),
	INDEX (`category`),
	INDEX (`date`),
	INDEX (`message`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `#__users` ADD INDEX `idx_externallogin` (`password`);
