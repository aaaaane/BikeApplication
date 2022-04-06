CREATE DATABASE IF NOT EXISTS vanmoof;

USE mysql;

CREATE USER 'vanmoof'@'%' IDENTIFIED BY 'secret';

FLUSH PRIVILEGES;

GRANT ALL PRIVILEGES ON *.* TO 'vanmoof'@'%';

FLUSH PRIVILEGES;

USE vanmoof;


CREATE TABLE `Bike`
(
    `id`      VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `user_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `state`  VARCHAR(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'inactive',
    `name`    VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `model`   INT(15),
    UNIQUE KEY `index_id` (`id`) USING BTREE,
    PRIMARY KEY (`id`)
);

