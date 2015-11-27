-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 27 Novembre 2015 à 08:11
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

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
  `nomEntreprise` varchar(40) NOT NULL,
  `mailEntreprise` varchar(30) NOT NULL,
  `telEntreprise` char(10) NOT NULL,
  `adresseEntreprise` varchar(150) NOT NULL,
  `logoEntreprise` varchar(100) NOT NULL,
  `descEntreprise` text NOT NULL,
  `loginAdmin` varchar(30) NOT NULL,
  `mdpAdmin` varchar(30) NOT NULL,
  PRIMARY KEY (`nomEntreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`nomEntreprise`, `mailEntreprise`, `telEntreprise`, `adresseEntreprise`, `logoEntreprise`, `descEntreprise`, `loginAdmin`, `mdpAdmin`) VALUES
('tiff', 'truc@gmail.com', '', '', '', '', 'log', 'mdp');

-- --------------------------------------------------------

--
-- Structure de la table `tiff_client`
--

CREATE TABLE IF NOT EXISTS `tiff_client` (
  `id_client` char(8) NOT NULL,
  `nom_client` varchar(40) DEFAULT NULL,
  `prenom_client` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `login_client` varchar(30) DEFAULT NULL,
  `mdp_client` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tiff_employe`
--

CREATE TABLE IF NOT EXISTS `tiff_employe` (
  `id_employe` char(8) NOT NULL,
  `nom_employe` varchar(40) DEFAULT NULL,
  `prenom_employe` varchar(50) DEFAULT NULL,
  `competenceA` char(8) DEFAULT NULL,
  `competenceB` char(8) DEFAULT NULL,
  `competenceC` char(8) DEFAULT NULL,
  `absent` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tiff_planning`
--

CREATE TABLE IF NOT EXISTS `tiff_planning` (
  `code_employe` char(8) NOT NULL,
  `id_planning` varchar(10) NOT NULL,
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
  `SamediA` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tiff_prestation`
--

CREATE TABLE IF NOT EXISTS `tiff_prestation` (
  `id_presta` char(8) NOT NULL,
  `descriptif_presta` text,
  `prix` decimal(5,2) DEFAULT NULL,
  `paypal` tinyint(1) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_presta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tiff_reserv`
--

CREATE TABLE IF NOT EXISTS `tiff_reserv` (
  `id_reserv` char(8) NOT NULL,
  `client` char(8) DEFAULT NULL,
  `employe` char(8) DEFAULT NULL,
  `presta` char(8) DEFAULT NULL,
  `paye` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  PRIMARY KEY (`id_reserv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
