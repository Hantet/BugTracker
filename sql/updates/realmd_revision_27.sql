CREATE TABLE `bt_comment` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`entry` int(11) NOT NULL,
`account` int(11) NOT NULL,
`player` int(11) NOT NULL,
`text` varchar(255) NOT NULL,
`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`));