-- @package     External Login
-- @subpackage  Component
-- @copyright   Copyright (C) 2008-2014 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @author      Christophe Demko
-- @author      Ioannis Barounis
-- @author      Alexandre Gandois
-- @link        http://www.chdemko.com
-- @license     http://www.gnu.org/licenses/gpl-2.0.html

DROP TABLE IF EXISTS `#__externallogin_servers`;
DROP TABLE IF EXISTS `#__externallogin_users`;
DROP TABLE IF EXISTS `#__externallogin_logs`;
ALTER TABLE `#__users` DROP INDEX `idx_externallogin`;
