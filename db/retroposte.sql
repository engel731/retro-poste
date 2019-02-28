-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 28 Février 2019 à 09:44
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `retroposte`
--

-- --------------------------------------------------------

--
-- Structure de la table `r_album`
--

CREATE TABLE IF NOT EXISTS `r_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `resum` text NOT NULL,
  `creation-date` datetime NOT NULL,
  `change-date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table des albums des cartes postales' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `r_picture`
--

CREATE TABLE IF NOT EXISTS `r_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `resum` text NOT NULL,
  `sha` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `creation-date` datetime NOT NULL,
  `id_possessor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table contenant les cartes postales' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `r_users`
--

CREATE TABLE IF NOT EXISTS `r_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(60) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table contenant les utilisateurs de l''application' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
