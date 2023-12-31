CREATE DATABASE IF NOT EXISTS noodler;

USE noodler;

DROP TABLE IF EXISTS `users`;

DROP TABLE IF EXISTS `noodles`;

CREATE TABLE `users` (
                         `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                         `username` varchar(255) NOT NULL,
                         `description` varchar(500),
                         `email` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         PRIMARY KEY(`id`)
);
INSERT INTO `users` (`id`, `username`, `description`, `email`, `password`) VALUES (1, 'Tiago', 'i like noodles', 'tiago@noodles.com', 'ilikenoodles');

INSERT INTO `users` (`id`, `username`, `description`, `email`, `password`) VALUES (2, 'Neal', 'noodles are the best', 'neal@noodles.com', 'noodlesforever');

INSERT INTO `users` (`id`, `username`, `description`, `email`, `password`) VALUES (3, 'Andrej', 'noodles are my favorite food', 'andrej@noodles.com', 'noodlesforlife');



CREATE TABLE `noodles` (
                           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                           `user_id`int(11) unsigned NOT NULL,
                           `time` TIMESTAMP NOT NULL,
                           `noodle` VARCHAR(500) NOT NULL,
                           PRIMARY KEY(`id`),
                           CONSTRAINT `fk_users` FOREIGN KEY (user_id) REFERENCES `users`(`id`)

);

INSERT INTO `noodles` (`user_id`, `time`, `noodle`) VALUES (1, '2023-11-11', 'noodles are the best');