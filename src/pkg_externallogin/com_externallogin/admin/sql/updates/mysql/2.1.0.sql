-- @package     External_Login
-- @subpackage  Component
-- @author      Christophe Demko <chdemko@gmail.com>
-- @author      Ioannis Barounis <contact@johnbarounis.com>
-- @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
-- @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
-- @link        http://www.chdemko.com

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

