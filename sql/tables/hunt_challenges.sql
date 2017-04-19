CREATE TABLE `hunt_challenges` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `hunt_id` int(11) NOT NULL,
 `challenge_id` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `hunt_id` (`hunt_id`,`challenge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;