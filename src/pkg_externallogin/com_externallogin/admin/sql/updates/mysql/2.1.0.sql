-- @package     External Login
-- @subpackage  Component
-- @copyright   Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @author      Christophe Demko
-- @author      Ioannis Barounis
-- @author      Alexandre Gandois
-- @link        http://www.chdemko.com
-- @license     http://www.gnu.org/licenses/gpl-2.0.html

CREATE TABLE IF NOT EXISTS `#__externallogin_logs` (
	`priority` INT(11) NOT NULL DEFAULT 0,
	`category` VARCHAR(255) NOT NULL,
	`date` DECIMAL(20,6) NOT NULL,
	`message` VARCHAR(65535) NOT NULL,
	INDEX (`priority`),
	INDEX (`category`),
	INDEX (`date`),
	INDEX (`message`(255))
) DEFAULT CHARSET=utf8;

ALTER TABLE `#__users` ADD INDEX `idx_externallogin` (`password`);

