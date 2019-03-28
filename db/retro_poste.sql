-- --------------------------------------------------------

--
-- Structure de la table `r_album`
--

CREATE TABLE IF NOT EXISTS `r_album` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_possessor` int UNSIGNED NOT NULL,
  `entity` char(5) DEFAULT 'Album',
  `title` varchar(255) NOT NULL,
  `resum` text,
  `creation_date` datetime NOT NULL,
  `change_date` datetime,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table des albums des cartes postales';

--
-- Liste index 
--

CREATE INDEX `ind_r_album_title_resum`
ON `r_album` (`title`(15), `resum`(15));

--
-- Liste index FullText
--

CREATE FULLTEXT INDEX `ind_full_r_album_title`
ON `r_album` (`title`);

CREATE FULLTEXT INDEX `ind_full_r_album_resum`
ON `r_album` (`resum`);

CREATE FULLTEXT INDEX `ind_full_r_album_title_resum`
ON `r_album` (`title`, `resum`);

-- --------------------------------------------------------

--
-- Structure de la table `r_picture`
--

CREATE TABLE IF NOT EXISTS `r_picture` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_album` int UNSIGNED,
  `id_possessor` int UNSIGNED NOT NULL,
  `entity` char(7) DEFAULT 'Picture',
  `title` varchar(255) NOT NULL,
  `resum` text,
  `sha` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table contenant les cartes postales';

--
-- Contenu de la table `r_picture`
--

INSERT INTO `r_picture` (`id_album`, `id_possessor`, `title`, `resum`, `sha`, `extension`, `creation_date`) VALUES
(NULL, 1, 'image 1', NULL, '4ac6fdbc2ae046c6e5b8f63c033bea6311de7fc4', '.png', '2019-03-04 16:02:26'),
(NULL, 1, 'image 2', NULL, '3e7f0372e686ec7c975c42451824760969642d45', '.png', '2019-03-04 16:07:12'),
(NULL, 1, 'image 3', NULL, '4a1bb27c812b27a8dbf36e6e704d0ea3477f445a', '.png', '2019-03-05 17:31:54'),
(NULL, 1, 'image 4', NULL, '6bb18d425c7d7487006180a49aade067e090de7b', '.png', '2019-03-05 17:32:21'),
(NULL, 1, 'image 5', NULL, '9a7e479735aad47b2ce147ade10ffb0b11f8d207', '.png', '2019-03-05 17:32:28'),
(NULL, 1, 'image 6', NULL, '12c9fba1dab7b6e563b2a55c995feb07c244a141', '.png', '2019-03-05 17:32:35'),
(NULL, 1, 'image 7', NULL, '64fe04478e07e1a6d9b9019378e2f413048e7112', '.png', '2019-03-05 17:32:45'),
(NULL, 1, 'image 8', NULL, '67a3fd867c8e79fc70774063c89b24b8eeb685ae', '.png', '2019-03-05 17:33:21'),
(NULL, 2, 'image 9', NULL, '900dbe12f7308a97c9e8f762a43c6fba79aa239d', '.png', '2019-03-05 17:33:33'),
(NULL, 2, 'image 10', NULL, '3399e81aaf9cc8bc37ba248e19fb895945fd5d08', '.png', '2019-03-05 17:33:42'),
(NULL, 2, 'image 11', NULL, '82821fbc10d8fe2eecad03179851cf7adc39e73c', '.png', '2019-03-05 17:33:50'),
(NULL, 2, 'image 12', NULL, 'c545f8a5799b241424eb530624f452602504661e', '.png', '2019-03-05 17:33:59'),
(NULL, 2, 'image 13', NULL, 'cdb5e6ecda3885bad46527d4fc0b5208e06dc154', '.png', '2019-03-05 17:34:10'),
(NULL, 2, 'image 14', NULL, 'd2a6899b492b404a109f865031e7f9ebfafd3544', '.png', '2019-03-05 17:34:21'),
(NULL, 2, 'image 15', NULL, 'd0389a5a0a6e742c98186e03099cda6a956c829a', '.png', '2019-03-05 17:34:30'),
(NULL, 2, 'image 16', NULL, 'ed2942c51e7a42fc66fe858795f55fea48463b8b', '.png', '2019-03-05 17:34:38'),
(NULL, 2, 'image 17', NULL, 'f3730d9a06d08fc7f6b91fb93fd9a12b33d6c9a3', '.png', '2019-03-05 17:34:50');

--
-- Liste index 
--

CREATE INDEX `ind_r_picture_title_resum`
ON `r_picture` (`title`(15), `resum`(15));

--
-- Index unique sur les colones sha
--

CREATE UNIQUE INDEX `ind_uni_sha`
ON `r_picture` (`sha`); 

--
-- Liste index FullText
--

CREATE FULLTEXT INDEX `ind_full_r_picture_title`
ON `r_picture` (`title`);

CREATE FULLTEXT INDEX `ind_full_r_picture_resum`
ON `r_picture` (`resum`);

CREATE FULLTEXT INDEX `ind_full_r_picture_title_resum`
ON `r_picture` (`title`, `resum`);

-- --------------------------------------------------------

--
-- Structure de la table `r_users`
--

CREATE TABLE IF NOT EXISTS `r_user` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity` char(4) DEFAULT 'User',
  `login` varchar(60) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table contenant les utilisateurs de l''application';

--
-- Contenu de la table `r_user`
--

INSERT INTO `r_user` (`login`, `pass`, `mail`, `creation_date`) VALUES
('engel731', 'd10c988ca61b785f5a7756b5852683d798fe4d92', 'tanguy731@hotmail.fr', '2019-03-04 17:05:12'),
('pierre73460', 'aa90f0a2bcd819661fcab606b41c8134cd30be3c', 'ma.bazire@laposte.net', '2019-03-04 17:06:18');

--
-- Liste index 
--

CREATE INDEX `ind_r_user_title_resum`
ON `r_user` (`login`(15));

--
-- Index unique sur les colones login, mail
--

CREATE UNIQUE INDEX `ind_uni_login`
ON `r_user` (`login`, `mail`); 

--
-- Liste index FullText
--

CREATE FULLTEXT INDEX `ind_full_r_user_login`
ON `r_user` (`login`);

-- --------------------------------------------------------

--
-- Clé etrangere
--

ALTER TABLE `r_picture`
ADD CONSTRAINT `fk_possessor_id` FOREIGN KEY (`id_possessor`) REFERENCES `r_user`(`id`);

ALTER TABLE `r_picture`
ADD CONSTRAINT `fk_album_id` FOREIGN KEY (`id_album`) REFERENCES `r_album`(`id`);

ALTER TABLE `r_album`
ADD CONSTRAINT `fk_r_album_possessor_id` FOREIGN KEY (`id_possessor`) REFERENCES `r_user`(`id`);