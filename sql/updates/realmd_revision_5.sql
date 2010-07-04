ALTER TABLE `bt_message` ADD COLUMN `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `priority`;
INSERT INTO `bt_section` (`id`, `name`) VALUES ('6', 'Достижение');
INSERT INTO `bt_section` VALUES ('7', 'Звание');