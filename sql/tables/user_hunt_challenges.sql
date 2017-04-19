CREATE TABLE `user_hunt_challenges` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `hunt_challenge_id` int(11) NOT NULL,
 `state` tinyint(2) NOT NULL,
 `start_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `end_time` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci