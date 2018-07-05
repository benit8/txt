-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 05 juil. 2018 à 17:33
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `txt`
--
CREATE DATABASE IF NOT EXISTS `txt` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `txt`;

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `email` varchar(250) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `rank` enum('Admin','Moderator','Janitor','User') NOT NULL DEFAULT 'User',
  `status` enum('good','muted','banned') NOT NULL DEFAULT 'good',
  `expire` timestamp NULL DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `boards`
--

DROP TABLE IF EXISTS `boards`;
CREATE TABLE IF NOT EXISTS `boards` (
  `id` varchar(32) NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `boards`
--

INSERT INTO `boards` (`id`, `title`) VALUES
('0', 'Random'),
('a', 'Anime & Manga'),
('t', 'Technology & Programming'),
('v', 'Video Games');

-- --------------------------------------------------------

--
-- Structure de la table `ips`
--

DROP TABLE IF EXISTS `ips`;
CREATE TABLE IF NOT EXISTS `ips` (
  `ip` varchar(15) NOT NULL,
  `status` enum('good','muted','banned') NOT NULL DEFAULT 'good',
  `expire` timestamp NULL DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `board` varchar(8) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `subject` text,
  `ip` varchar(15) DEFAULT NULL,
  `date_posted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_bump` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sticky` tinyint(1) DEFAULT '0',
  `locked` tinyint(1) DEFAULT '0',
  `archived` tinyint(1) DEFAULT '0',
  UNIQUE KEY `unique_index` (`board`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
