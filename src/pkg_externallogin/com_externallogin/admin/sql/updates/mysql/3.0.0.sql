-- @package     External Login
-- @subpackage  Component
-- @copyright   Copyright (C) 2008-2017 Christophe Demko, Ioannis Barounis, Alexandre Gandois. All rights reserved.
-- @author      Christophe Demko
-- @author      Ioannis Barounis
-- @author      Alexandre Gandois
-- @link        http://www.chdemko.com
-- @license     http://www.gnu.org/licenses/gpl-2.0.html

ALTER TABLE `#__externallogin_users` DROP INDEX `user_id`, ADD UNIQUE `user_id` (`user_id`);
