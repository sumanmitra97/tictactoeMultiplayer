
CREATE TABLE `play` (
  `game_id` int(11) NOT NULL,
  `first_user` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `second_user` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `play`
  ADD PRIMARY KEY (`game_id`);
