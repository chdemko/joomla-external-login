-- @package     External_Login
-- @subpackage  Component
-- @author      Christophe Demko <chdemko@gmail.com>
-- @author      Ioannis Barounis <contact@johnbarounis.com>
-- @author      Alexandre Gandois <alexandre.gandois@etudiant.univ-lr.fr>
-- @copyright   Copyright (C) 2008-2018 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @license     GNU General Public License, version 2. http://www.gnu.org/licenses/gpl-2.0.html
-- @link        http://www.chdemko.com

DROP TABLE IF EXISTS `#__externallogin_servers`;
DROP TABLE IF EXISTS `#__externallogin_users`;
DROP TABLE IF EXISTS `#__externallogin_logs`;
ALTER TABLE `#__users` DROP INDEX `idx_externallogin`;
