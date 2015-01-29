-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2015 at 11:43 AM
-- Server version: 5.5.41-0ubuntu0.14.04.1-log
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `archi_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `_interetAdresse`
--

CREATE TABLE IF NOT EXISTS `_interetAdresse` (
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idHistoriqueAdresse` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  KEY `fk__interetAdresse_utilisateur1_idx` (`idUtilisateur`),
  KEY `fk__interetAdresse_historiqueAdresse1_idx` (`idHistoriqueAdresse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_interetPays`
--

CREATE TABLE IF NOT EXISTS `_interetPays` (
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idPays` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`,`idPays`),
  KEY `fk__interetPays_utilisateur1_idx` (`idUtilisateur`),
  KEY `fk__interetPays_pays1_idx` (`idPays`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_interetPersonne`
--

CREATE TABLE IF NOT EXISTS `_interetPersonne` (
  `idPersonne` int(10) unsigned NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`idPersonne`,`idUtilisateur`),
  KEY `fk_table1_personne1_idx` (`idPersonne`),
  KEY `fk_table1_utilisateur1_idx` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_interetQuartier`
--

CREATE TABLE IF NOT EXISTS `_interetQuartier` (
  `idQuartier` int(10) unsigned NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`idQuartier`,`idUtilisateur`),
  KEY `fk__interetQuartier_quartier1_idx` (`idQuartier`),
  KEY `fk__interetQuartier_utilisateur1_idx` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_interetRue`
--

CREATE TABLE IF NOT EXISTS `_interetRue` (
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idRue` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`,`idRue`),
  KEY `fk__interetRue_utilisateur1_idx` (`idUtilisateur`),
  KEY `fk__interetRue_rue1_idx` (`idRue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_interetSousQuartier`
--

CREATE TABLE IF NOT EXISTS `_interetSousQuartier` (
  `idSousQuartier` int(10) unsigned NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`idSousQuartier`,`idUtilisateur`),
  KEY `fk_interetSousQuartier_sousQuartier1_idx` (`idSousQuartier`),
  KEY `fk_interetSousQuartier_utilisateur1_idx` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_interetVille`
--

CREATE TABLE IF NOT EXISTS `_interetVille` (
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idVille` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`,`idVille`),
  KEY `fk__interetVille_utilisateur1_idx` (`idUtilisateur`),
  KEY `fk__interetVille_ville1_idx` (`idVille`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `_interetAdresse`
--
ALTER TABLE `_interetAdresse`
  ADD CONSTRAINT `fk__interetAdresse_historiqueAdresse1` FOREIGN KEY (`idHistoriqueAdresse`) REFERENCES `historiqueAdresse` (`idHistoriqueAdresse`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk__interetAdresse_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `_interetPays`
--
ALTER TABLE `_interetPays`
  ADD CONSTRAINT `fk__interetPays_pays1` FOREIGN KEY (`idPays`) REFERENCES `pays` (`idPays`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk__interetPays_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `_interetPersonne`
--
ALTER TABLE `_interetPersonne`
  ADD CONSTRAINT `fk_table1_personne1` FOREIGN KEY (`idPersonne`) REFERENCES `personne` (`idPersonne`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_table1_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `_interetQuartier`
--
ALTER TABLE `_interetQuartier`
  ADD CONSTRAINT `fk__interetQuartier_quartier1` FOREIGN KEY (`idQuartier`) REFERENCES `quartier` (`idQuartier`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk__interetQuartier_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `_interetRue`
--
ALTER TABLE `_interetRue`
  ADD CONSTRAINT `fk__interetRue_rue1` FOREIGN KEY (`idRue`) REFERENCES `rue` (`idRue`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk__interetRue_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `_interetSousQuartier`
--
ALTER TABLE `_interetSousQuartier`
  ADD CONSTRAINT `fk_interetSousQuartier_sousQuartier1` FOREIGN KEY (`idSousQuartier`) REFERENCES `sousQuartier` (`idSousQuartier`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_interetSousQuartier_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `_interetVille`
--
ALTER TABLE `_interetVille`
  ADD CONSTRAINT `fk__interetVille_utilisateur1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk__interetVille_ville1` FOREIGN KEY (`idVille`) REFERENCES `ville` (`idVille`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;