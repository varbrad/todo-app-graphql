DROP DATABASE IF EXISTS `sceqicla_todo`;
CREATE DATABASE `sceqicla_todo` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `sceqicla_todo`;

CREATE TABLE `user` (
	`user_id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(32) NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE (`username`)
) ENGINE=InnoDB;

CREATE TABLE `list` (
	`list_id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`title` VARCHAR(64) NOT NULL,
	PRIMARY KEY (`list_id`),
	FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `list_item` (
	`list_item_id` VARCHAR(4) NOT NULL,
	`list_id` INT(11) NOT NULL,
	`content` VARCHAR(128) NOT NULL,
	PRIMARY KEY (`list_item_id`, `list_id`),
	FOREIGN KEY (`list_id`) REFERENCES `list` (`list_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

# DROP USER 'sceqicla_todo'@'localhost';
CREATE USER 'sceqicla_todo'@'localhost';
UPDATE mysql.user SET Password=PASSWORD('password') WHERE User='sceqicla_todo' AND Host='localhost';
GRANT Insert ON sceqicla_todo.* TO 'sceqicla_todo'@'localhost';
GRANT Update ON sceqicla_todo.* TO 'sceqicla_todo'@'localhost';
GRANT Delete ON sceqicla_todo.* TO 'sceqicla_todo'@'localhost';
GRANT Select ON sceqicla_todo.* TO 'sceqicla_todo'@'localhost';
FLUSH PRIVILEGES;
