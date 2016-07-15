-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 15 Juillet 2016 à 11:24
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `minijeu`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

CREATE TABLE IF NOT EXISTS `personnages` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `degats` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Nom_UNIQUE` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `personnages`
--

INSERT INTO `personnages` (`id`, `nom`, `degats`) VALUES
(22, 'xhavier', 0),
(4, 'Wilfrid', 20),
(13, 'Wallas', 10),
(9, 'Jerome', 45),
(18, 'Benoît', 15),
(15, 'Gael', 5),
(16, 'walliou', 5),
(19, 'Richard', 65),
(20, 'Prudent', 10),
(21, 'Aurele', 40);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
