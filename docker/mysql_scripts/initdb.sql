CREATE DATABASE IF NOT EXISTS `dana_internal_db`;

GRANT ALL PRIVILEGES ON dana_internal_db.* TO 'dana_user'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;