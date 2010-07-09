ALTER TABLE `bt_message`
ADD COLUMN `type`  int(11) NOT NULL DEFAULT 0 AFTER `text_3`,
ADD COLUMN `subtype`  int(11) NOT NULL DEFAULT 0 AFTER `type`,
ADD COLUMN `name`  varchar(50) NOT NULL AFTER `subtype`;

ALTER TABLE `bt_options`
DROP COLUMN `method`,
DROP COLUMN `guid`,
DROP COLUMN `map`,
DROP COLUMN `zone`,
DROP COLUMN `subtype`,
DROP COLUMN `type`,
DROP COLUMN `name`,
MODIFY COLUMN `link`  varchar(50) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL AFTER `id`;

ALTER TABLE `bt_message`
MODIFY COLUMN `type`  int(11) NOT NULL DEFAULT 0 AFTER `priority`,
ADD COLUMN `map`  int(11) NOT NULL DEFAULT 0 AFTER `subtype`,
ADD COLUMN `zone`  int(11) NOT NULL DEFAULT 0 AFTER `map`,
MODIFY COLUMN `date`  datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `name`;

ALTER TABLE `bt_message`
MODIFY COLUMN `name`  varchar(20) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL AFTER `zone`;