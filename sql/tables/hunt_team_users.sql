CREATE TABLE `hunt_team_users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `team_id` int(11) NOT NULL,
 `user_id` int(11) NOT NULL,
 `hunt_id` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `user_id` (`user_id`,`hunt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;