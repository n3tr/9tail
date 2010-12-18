CREATE TABLE  `9tail_db`.`user` (
`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`screen_name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`email` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`password` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`firstname` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`lastname` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`create_date` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00',
`status` INT( 11 ) NOT NULL DEFAULT  '0',
UNIQUE (
`screen_name` ,
`email`
)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE  `9tail_db`.`messages` (
`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`to` BIGINT( 20 ) UNSIGNED NOT NULL ,
`from` BIGINT( 20 ) UNSIGNED NOT NULL ,
`text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`datetime` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE  `9tail_db`.`friend` (
`from` BIGINT( 20 ) UNSIGNED NOT NULL ,
`to` BIGINT( 20 ) UNSIGNED NOT NULL ,
`status` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '0',
`create_date` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00',
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `friend` ADD  `guid` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD UNIQUE (
`guid`
)

CREATE TABLE  `9tail_db`.`place` (
`id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`lat` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`lng` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`create_by` BIGINT( 20 ) NOT NULL ,
`create_date` DATETIME NOT NULL DEFAULT  '0000-00-00 00:00:00',
`official` INT( 11 ) NOT NULL DEFAULT  '0'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE  `9tail_db`.`place_address` (
`place_id` BIGINT( 20 ) UNSIGNED NOT NULL ,
`address` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`tambon` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`amphoe` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`province` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`country` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
`postal` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE  `place` ADD  `guid` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
ADD UNIQUE (
`guid`
)