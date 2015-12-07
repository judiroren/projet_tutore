-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 07 Décembre 2015 à 13:38
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
-- Structure de la table `absence`
--

CREATE TABLE IF NOT EXISTS `absence` (
  `code_employe` char(8) NOT NULL,
  `motif` varchar(100) NOT NULL,
  `dateDébut` date NOT NULL,
  `dateFin` date NOT NULL,
  `absenceFini` tinyint(1) NOT NULL,
  PRIMARY KEY (`code_employe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('tiff', 'machin@gmail.com', '0565784220', '10 rue des potiers', 'http://www.richeidee.com/wp-content/uploads/2010/05/coiffure.jpg', 'entreprise test', 'log', 'mdp');

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

--
-- Contenu de la table `tiff_client`
--

INSERT INTO `tiff_client` (`id_client`, `nom_client`, `prenom_client`, `mail`, `login_client`, `mdp_client`) VALUES
('CLI00001', 'Blanc', 'Lucas', 'chose@gmail.com', 'blanco', 'ouranos');

-- --------------------------------------------------------

--
-- Structure de la table `tiff_employe`
--

CREATE TABLE IF NOT EXISTS `tiff_employe` (
  `id_employe` int(10) NOT NULL AUTO_INCREMENT,
  `nom_employe` varchar(40) DEFAULT NULL,
  `prenom_employe` varchar(50) DEFAULT NULL,
  `competenceA` char(8) DEFAULT NULL,
  `competenceB` char(8) DEFAULT NULL,
  `competenceC` char(8) DEFAULT NULL,
  `telephone_emp` char(10) NOT NULL,
  `adresse_emp` varchar(200) NOT NULL,
  `mail_emp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `tiff_employe`
--

INSERT INTO `tiff_employe` (`id_employe`, `nom_employe`, `prenom_employe`, `competenceA`, `competenceB`, `competenceC`, `telephone_emp`, `adresse_emp`, `mail_emp`) VALUES
(12, 'Digot', 'Julien', 'PRES0001', 'PRES0002', 'PRES0003', '0565784220', 'Bâtiment D résidence st Eloi 12000 Rodez', 'jddu12@gmail.com'),
(13, 'Blanc', 'Lucas', 'PRES0002', '', '', '0357481266', '15 Avenue des contrebandiers', 'alkogol@yahoo.com');

-- --------------------------------------------------------

--
-- Structure de la table `tiff_planning`
--

CREATE TABLE IF NOT EXISTS `tiff_planning` (
  `id_agenda` int(150) NOT NULL AUTO_INCREMENT,
  `code_employe` char(8) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `tiff_planning`
--

INSERT INTO `tiff_planning` (`id_agenda`, `code_employe`, `LundiM`, `LundiA`, `MardiM`, `MardiA`, `MercrediM`, `MercrediA`, `JeudiM`, `JeudiA`, `VendrediM`, `VendrediA`, `SamediM`, `SamediA`) VALUES
(1, '12', 1, 1, 0, 0, 1, 0, 0, 1, 0, 1, 1, 0),
(2, '13', 1, 1, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0);

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

--
-- Contenu de la table `tiff_prestation`
--

INSERT INTO `tiff_prestation` (`id_presta`, `descriptif_presta`, `prix`, `paypal`, `duree`) VALUES
('PRES0001', 'test', '10.00', 1, 30),
('PRES0002', 'test2', '13.00', 1, 50),
('PRES0003', 'test3', '5.00', 1, 10);

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

--
-- Contenu de la table `tiff_reserv`
--

INSERT INTO `tiff_reserv` (`id_reserv`, `client`, `employe`, `presta`, `paye`, `date`, `heure`) VALUES
('RES00001', 'CLI00001', '12', 'PRES0001', 1, '2015-12-05', '10:30:00'),
('RES00002', 'CLI00001', '12', 'PRES0002', 0, '2015-12-07', '12:40:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
