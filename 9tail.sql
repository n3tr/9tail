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
