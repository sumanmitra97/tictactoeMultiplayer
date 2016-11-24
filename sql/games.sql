
CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `moves` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);
