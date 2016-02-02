-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 27 Janvier 2016 à 16:03
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `portail_reserv`
--

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `nomEntreprise` varchar(40) COLLATE utf8_bin NOT NULL,
  `mailEntreprise` varchar(30) COLLATE utf8_bin NOT NULL,
  `telEntreprise` char(10) COLLATE utf8_bin NOT NULL,
  `adresseEntreprise` varchar(150) COLLATE utf8_bin NOT NULL,
  `logoEntreprise` varchar(100) COLLATE utf8_bin NOT NULL,
  `descEntreprise` varchar(500) COLLATE utf8_bin NOT NULL,
  `loginAdmin` varchar(30) COLLATE utf8_bin NOT NULL,
  `mdpAdmin` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`nomEntreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`nomEntreprise`, `mailEntreprise`, `telEntreprise`, `adresseEntreprise`, `logoEntreprise`, `descEntreprise`, `loginAdmin`, `mdpAdmin`) VALUES
('test', 'test@gmail.com', '', '', '', '', 'test', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `test_absence`
--

CREATE TABLE IF NOT EXISTS `test_absence` (
  `id_absence` char(8) COLLATE utf8_bin NOT NULL,
  `code_employe` char(8) COLLATE utf8_bin NOT NULL,
  `motif` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `absenceFini` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_absence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `test_client`
--

CREATE TABLE IF NOT EXISTS `test_client` (
  `id_client` char(8) COLLATE utf8_bin NOT NULL,
  `nom_client` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `prenom_client` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `login_client` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `mdp_client` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `test_employe`
--

CREATE TABLE IF NOT EXISTS `test_employe` (
  `id_employe` char(8) COLLATE utf8_bin NOT NULL,
  `nom_employe` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `prenom_employe` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `competenceA` char(8) COLLATE utf8_bin DEFAULT NULL,
  `competenceB` char(8) COLLATE utf8_bin DEFAULT NULL,
  `competenceC` char(8) COLLATE utf8_bin DEFAULT NULL,
  `telephone_emp` char(10) COLLATE utf8_bin DEFAULT NULL,
  `adresse_emp` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `mail_emp` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `test_planning`
--

CREATE TABLE IF NOT EXISTS `test_planning` (
  `id_agenda` char(8) COLLATE utf8_bin NOT NULL,
  `code_employe` char(8) COLLATE utf8_bin NOT NULL,
  `LundiM` tinyint(1) DEFAULT NULL,
  `LundiA` tinyint(1) DEFAULT NULL,
  `MardiM` tinyint(1) DEFAULT NULL,
  `MardiA` tinyint(1) DEFAULT NULL,
  `MercrediM` tinyint(1) DEFAULT NULL,
  `MercrediA` tinyint(1) DEFAULT NULL,
  `JeudiM` tinyint(1) DEFAULT NULL,
  `JeudiA` tinyint(1) DEFAULT NULL,
  `VendrediM` tinyint(1) DEFAULT NULL,
  `VendrediA` tinyint(1) DEFAULT NULL,
  `SamediM` tinyint(1) DEFAULT NULL,
  `SamediA` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_agenda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `test_prestation`
--

CREATE TABLE IF NOT EXISTS `test_prestation` (
  `id_presta` char(8) COLLATE utf8_bin NOT NULL,
  `descriptif_presta` text COLLATE utf8_bin,
  `prix` decimal(5,2) DEFAULT NULL,
  `paypal` tinyint(1) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_presta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `test_reserv`
--

CREATE TABLE IF NOT EXISTS `test_reserv` (
  `id_reserv` char(8) COLLATE utf8_bin NOT NULL,
  `client` char(8) COLLATE utf8_bin DEFAULT NULL,
  `employe` char(8) COLLATE utf8_bin DEFAULT NULL,
  `presta` char(8) COLLATE utf8_bin DEFAULT NULL,
  `paye` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  PRIMARY KEY (`id_reserv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
