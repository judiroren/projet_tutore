-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 05 Février 2016 à 18:39
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
  `mdpAdmin` varchar(300) NOT NULL,
  PRIMARY KEY (`nomEntreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`nomEntreprise`, `mailEntreprise`, `telEntreprise`, `adresseEntreprise`, `logoEntreprise`, `descEntreprise`, `loginAdmin`, `mdpAdmin`) VALUES
('soutenance', 'toto@mail.fr', '', '', '', '', 'soutenance', 'efed1a62ec5ce43baa85739aee079beb'),
('test', 'test@mail.fr', '0677452322', '', 'images/logo-coiffeur.jpg', '', 'test', '098f6bcd4621d373cade4e832627b4f6'),
('tiff', 'toto@mail.fr', '0565784220', '10 rue des potiers', 'images/logo-coiffeur.jpg', 'coucou', 'log', 'mdp'),
('truc', 'truc@mail.com', '0565784220', '15 Rue des Pins', 'images/logo-coiffeur.jpg', 'coucou', 'truc', '45723a2af3788c4ff17f8d1114760e62');

-- --------------------------------------------------------

--
-- Structure de la table `soutenance_absence`
--

CREATE TABLE IF NOT EXISTS `soutenance_absence` (
  `id_absence` char(8) NOT NULL,
  `code_employe` char(8) NOT NULL,
  `motif` varchar(100) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `absenceFini` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_absence`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `soutenance_client`
--

CREATE TABLE IF NOT EXISTS `soutenance_client` (
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
-- Structure de la table `soutenance_employe`
--

CREATE TABLE IF NOT EXISTS `soutenance_employe` (
  `id_employe` char(8) NOT NULL,
  `nom_employe` varchar(40) DEFAULT NULL,
  `prenom_employe` varchar(50) DEFAULT NULL,
  `competenceA` char(8) DEFAULT NULL,
  `competenceB` char(8) DEFAULT NULL,
  `competenceC` char(8) DEFAULT NULL,
  `telephone_emp` char(10) DEFAULT NULL,
  `adresse_emp` varchar(200) DEFAULT NULL,
  `mail_emp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `soutenance_planning`
--

CREATE TABLE IF NOT EXISTS `soutenance_planning` (
  `id_agenda` char(8) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `soutenance_prestation`
--

CREATE TABLE IF NOT EXISTS `soutenance_prestation` (
  `id_presta` char(8) NOT NULL,
  `descriptif_presta` text,
  `prix` decimal(5,2) DEFAULT NULL,
  `paypal` tinyint(1) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_presta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `soutenance_reserv`
--

CREATE TABLE IF NOT EXISTS `soutenance_reserv` (
  `id_reserv` char(8) NOT NULL,
  `client` char(8) DEFAULT NULL,
  `employe` char(8) DEFAULT NULL,
  `presta` char(8) DEFAULT NULL,
  `paye` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  PRIMARY KEY (`id_reserv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `test_absence`
--

CREATE TABLE IF NOT EXISTS `test_absence` (
  `id_absence` char(8) NOT NULL,
  `code_employe` char(8) NOT NULL,
  `motif` varchar(100) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `absenceFini` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_absence`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `test_client`
--

CREATE TABLE IF NOT EXISTS `test_client` (
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
-- Structure de la table `test_employe`
--

CREATE TABLE IF NOT EXISTS `test_employe` (
  `id_employe` char(8) NOT NULL,
  `nom_employe` varchar(40) DEFAULT NULL,
  `prenom_employe` varchar(50) DEFAULT NULL,
  `competenceA` char(8) DEFAULT NULL,
  `competenceB` char(8) DEFAULT NULL,
  `competenceC` char(8) DEFAULT NULL,
  `telephone_emp` char(10) DEFAULT NULL,
  `adresse_emp` varchar(200) DEFAULT NULL,
  `mail_emp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `test_planning`
--

CREATE TABLE IF NOT EXISTS `test_planning` (
  `id_agenda` char(8) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `test_prestation`
--

CREATE TABLE IF NOT EXISTS `test_prestation` (
  `id_presta` char(8) NOT NULL,
  `descriptif_presta` text,
  `prix` decimal(5,2) DEFAULT NULL,
  `paypal` tinyint(1) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_presta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `test_reserv`
--

CREATE TABLE IF NOT EXISTS `test_reserv` (
  `id_reserv` char(8) NOT NULL,
  `client` char(8) DEFAULT NULL,
  `employe` char(8) DEFAULT NULL,
  `presta` char(8) DEFAULT NULL,
  `paye` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  PRIMARY KEY (`id_reserv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tiff_absence`
--

CREATE TABLE IF NOT EXISTS `tiff_absence` (
  `id_absence` char(8) NOT NULL,
  `code_employe` char(8) NOT NULL,
  `motif` varchar(100) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `absenceFini` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_absence`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tiff_absence`
--

INSERT INTO `tiff_absence` (`id_absence`, `code_employe`, `motif`, `dateDebut`, `dateFin`, `absenceFini`) VALUES
('ABSC0001', 'EMPL0001', 'maladie', '2015-12-15', '2015-12-18', 0),
('ABSC0002', 'EMPL0002', 'maladie', '2015-12-17', '2015-12-19', 0),
('ABSC0003', 'EMPL0003', 'congé', '2015-12-14', '2015-12-15', 1),
('ABSC0004', 'EMPL0003', 'Maladie', '2015-12-17', '2015-12-18', 0),
('ABSC0005', 'EMPL0003', 'Maladie', '2015-12-18', '2015-12-26', 0);

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
('CLI00001', 'Digot', 'Julien', 'jddu12@gmail.com', 'logc', 'mdpc');

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
  `telephone_emp` char(10) DEFAULT NULL,
  `adresse_emp` varchar(200) DEFAULT NULL,
  `mail_emp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tiff_employe`
--

INSERT INTO `tiff_employe` (`id_employe`, `nom_employe`, `prenom_employe`, `competenceA`, `competenceB`, `competenceC`, `telephone_emp`, `adresse_emp`, `mail_emp`) VALUES
('EMPL0001', 'Digot', 'Julien', 'PRES0001', '', 'PRES0002', '0565784220', 'Bâtiment D résidence st Eloi 12000 Rodez', 'jddu12@gmail.com'),
('EMPL0002', 'Blanc', 'Lucas', 'PRES0002', 'PRES0005', '', '0670356384', '15 Avenue des contrebandiers', 'alkogol@yahoo.com'),
('EMPL0003', 'Pascal', 'Ludovic', 'PRES0002', 'PRES0004', 'PRES0006', '', '15 Rue des Pins', 'ldvic@mail.com');

-- --------------------------------------------------------

--
-- Structure de la table `tiff_planning`
--

CREATE TABLE IF NOT EXISTS `tiff_planning` (
  `id_agenda` char(8) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tiff_planning`
--

INSERT INTO `tiff_planning` (`id_agenda`, `code_employe`, `LundiM`, `LundiA`, `MardiM`, `MardiA`, `MercrediM`, `MercrediA`, `JeudiM`, `JeudiA`, `VendrediM`, `VendrediA`, `SamediM`, `SamediA`) VALUES
('PLAN0001', 'EMPL0001', 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1),
('PLAN0002', 'EMPL0002', 1, 0, 1, 0, 1, 1, 0, 1, 0, 1, 0, 0),
('PLAN0003', 'EMPL0003', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
('PRES0001', 'prestation de test 1', '10.00', 0, 30),
('PRES0002', 'prestation de test 2', '12.00', 0, 50),
('PRES0003', 'prestation de test 3', '10.00', 1, 20),
('PRES0004', 'prestation 4', '10.00', 1, 15),
('PRES0005', 'prestation 5', '12.00', 0, 20),
('PRES0006', 'prestation 6', '12.00', 0, 15);

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

-- --------------------------------------------------------

--
-- Structure de la table `truc_absence`
--

CREATE TABLE IF NOT EXISTS `truc_absence` (
  `id_absence` char(8) NOT NULL,
  `code_employe` char(8) NOT NULL,
  `motif` varchar(100) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `absenceFini` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_absence`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `truc_absence`
--

INSERT INTO `truc_absence` (`id_absence`, `code_employe`, `motif`, `dateDebut`, `dateFin`, `absenceFini`) VALUES
('ABSC0001', 'EMPL0001', 'maladie', '2015-12-12', '2015-12-19', 0),
('ABSC0003', 'EMPL0003', 'Congé paternité', '2015-12-15', '2015-12-17', 0),
('ABSC0004', 'EMPL0002', 'Maladie', '2015-12-14', '2015-12-16', 0);

-- --------------------------------------------------------

--
-- Structure de la table `truc_client`
--

CREATE TABLE IF NOT EXISTS `truc_client` (
  `id_client` char(8) NOT NULL,
  `nom_client` varchar(40) DEFAULT NULL,
  `prenom_client` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `login_client` varchar(30) DEFAULT NULL,
  `mdp_client` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `truc_client`
--

INSERT INTO `truc_client` (`id_client`, `nom_client`, `prenom_client`, `mail`, `login_client`, `mdp_client`) VALUES
('CLIE0001', 'Digot', 'Melanie', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `truc_employe`
--

CREATE TABLE IF NOT EXISTS `truc_employe` (
  `id_employe` char(8) NOT NULL,
  `nom_employe` varchar(40) DEFAULT NULL,
  `prenom_employe` varchar(50) DEFAULT NULL,
  `competenceA` char(8) DEFAULT NULL,
  `competenceB` char(8) DEFAULT NULL,
  `competenceC` char(8) DEFAULT NULL,
  `telephone_emp` char(10) DEFAULT NULL,
  `adresse_emp` varchar(200) DEFAULT NULL,
  `mail_emp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_employe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `truc_employe`
--

INSERT INTO `truc_employe` (`id_employe`, `nom_employe`, `prenom_employe`, `competenceA`, `competenceB`, `competenceC`, `telephone_emp`, `adresse_emp`, `mail_emp`) VALUES
('EMPL0001', 'Digot', 'Julien', 'PRES0001', '', '', '', 'Bâtiment D résidence st Eloi 12000 Rodez', ''),
('EMPL0002', 'Blanc', 'Lucas', '', '', '', '', '15 Avenue des contrebandiers', ''),
('EMPL0003', 'Pascal', 'Ludovic', '', '', '', '', '10 rue des potiers', '');

-- --------------------------------------------------------

--
-- Structure de la table `truc_planning`
--

CREATE TABLE IF NOT EXISTS `truc_planning` (
  `id_agenda` char(8) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `truc_planning`
--

INSERT INTO `truc_planning` (`id_agenda`, `code_employe`, `LundiM`, `LundiA`, `MardiM`, `MardiA`, `MercrediM`, `MercrediA`, `JeudiM`, `JeudiA`, `VendrediM`, `VendrediA`, `SamediM`, `SamediA`) VALUES
('PLAN0001', 'EMPL0001', 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('PLAN0002', 'EMPL0002', 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0),
('PLAN0003', 'EMPL0003', 1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `truc_prestation`
--

CREATE TABLE IF NOT EXISTS `truc_prestation` (
  `id_presta` char(8) NOT NULL,
  `descriptif_presta` text,
  `prix` decimal(5,2) DEFAULT NULL,
  `paypal` tinyint(1) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_presta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `truc_prestation`
--

INSERT INTO `truc_prestation` (`id_presta`, `descriptif_presta`, `prix`, `paypal`, `duree`) VALUES
('PRES0001', 'coucou', '24.00', 1, 30);

-- --------------------------------------------------------

--
-- Structure de la table `truc_reserv`
--

CREATE TABLE IF NOT EXISTS `truc_reserv` (
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
-- Contenu de la table `truc_reserv`
--

INSERT INTO `truc_reserv` (`id_reserv`, `client`, `employe`, `presta`, `paye`, `date`, `heure`) VALUES
('RESV0001', 'CLIE0001', 'EMPL0001', 'PRES0001', 1, '2015-12-19', '20:10:00'),
('RESV0002', 'CLIE0001', 'EMPL0002', 'PRES0001', 1, '2015-12-14', '11:05:30'),
('RESV0003', 'CLIE0001', 'EMPL0003', 'PRES0001', 0, '2015-12-10', '09:30:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
