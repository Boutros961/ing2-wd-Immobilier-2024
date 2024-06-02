-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2024 at 05:14 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `omnesimmobilier`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `ID` int(11) NOT NULL,
  `UtilisateurID` int(11) NOT NULL,
  `Specialite` varchar(100) DEFAULT NULL,
  `Disponibilite` text,
  `CV` text,
  `Lundi_AM` tinyint(1) DEFAULT NULL,
  `Lundi_PM` tinyint(1) DEFAULT NULL,
  `Mardi_AM` tinyint(1) DEFAULT NULL,
  `Mardi_PM` tinyint(1) DEFAULT NULL,
  `Mercredi_AM` tinyint(1) DEFAULT NULL,
  `Mercredi_PM` tinyint(1) DEFAULT NULL,
  `Jeudi_AM` tinyint(1) DEFAULT NULL,
  `Jeudi_PM` tinyint(1) DEFAULT NULL,
  `Vendredi_AM` tinyint(1) DEFAULT NULL,
  `Vendredi_PM` tinyint(1) DEFAULT NULL,
  `Samedi_AM` tinyint(1) DEFAULT NULL,
  `Samedi_PM` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`ID`, `UtilisateurID`, `Specialite`, `Disponibilite`, `CV`, `Lundi_AM`, `Lundi_PM`, `Mardi_AM`, `Mardi_PM`, `Mercredi_AM`, `Mercredi_PM`, `Jeudi_AM`, `Jeudi_PM`, `Vendredi_AM`, `Vendredi_PM`, `Samedi_AM`, `Samedi_PM`) VALUES
(1, 2, 'Immobilier Résidentiel', NULL, 'CV de Marie Curie', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `creneauxhoraires`
--

CREATE TABLE `creneauxhoraires` (
  `ID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `Jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi') NOT NULL,
  `Heure` time NOT NULL,
  `Disponible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `creneauxhoraires`
--

INSERT INTO `creneauxhoraires` (`ID`, `AgentID`, `Jour`, `Heure`, `Disponible`) VALUES
(61, 1, 'Lundi', '08:00:00', 0),
(62, 1, 'Lundi', '09:00:00', 0),
(63, 1, 'Lundi', '10:00:00', 0),
(64, 1, 'Lundi', '11:00:00', 0),
(65, 1, 'Lundi', '12:00:00', 0),
(66, 1, 'Lundi', '13:00:00', 1),
(67, 1, 'Lundi', '14:00:00', 0),
(68, 1, 'Lundi', '15:00:00', 1),
(69, 1, 'Lundi', '16:00:00', 1),
(70, 1, 'Lundi', '17:00:00', 1),
(71, 1, 'Lundi', '18:00:00', 1),
(72, 1, 'Mercredi', '08:00:00', 0),
(73, 1, 'Mercredi', '09:00:00', 1),
(74, 1, 'Mercredi', '10:00:00', 1),
(75, 1, 'Mercredi', '11:00:00', 1),
(76, 1, 'Mercredi', '12:00:00', 1),
(77, 1, 'Mercredi', '13:00:00', 1),
(78, 1, 'Mercredi', '14:00:00', 1),
(79, 1, 'Mercredi', '15:00:00', 1),
(80, 1, 'Mercredi', '16:00:00', 1),
(81, 1, 'Mercredi', '17:00:00', 1),
(82, 1, 'Mercredi', '18:00:00', 1),
(83, 1, 'Vendredi', '08:00:00', 1),
(84, 1, 'Vendredi', '09:00:00', 1),
(85, 1, 'Vendredi', '10:00:00', 1),
(86, 1, 'Vendredi', '11:00:00', 1),
(87, 1, 'Vendredi', '12:00:00', 1),
(88, 1, 'Vendredi', '13:00:00', 1),
(89, 1, 'Vendredi', '14:00:00', 1),
(90, 1, 'Vendredi', '15:00:00', 1),
(91, 1, 'Vendredi', '16:00:00', 1),
(92, 1, 'Vendredi', '17:00:00', 1),
(93, 1, 'Vendredi', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `propriete`
--

CREATE TABLE `propriete` (
  `ID` int(11) NOT NULL,
  `Adresse` text NOT NULL,
  `Type` enum('Résidentiel','Commercial','Terrain','Appartement') NOT NULL,
  `Description` text,
  `Prix` decimal(10,2) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `Images` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `propriete`
--

INSERT INTO `propriete` (`ID`, `Adresse`, `Type`, `Description`, `Prix`, `AgentID`, `Images`) VALUES
(1, '789 Rue de la Propriété, 75003 Paris', 'Résidentiel', 'Belle maison à Paris', '500000.00', 1, 'image1.jpg,image2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `ID` int(11) NOT NULL,
  `ProprieteID` int(11) NOT NULL,
  `AgentID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `Statut` enum('Confirmé','Annulé') NOT NULL,
  `heure_rendezvous` time DEFAULT NULL,
  `date_rendezvous` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rendezvous`
--

INSERT INTO `rendezvous` (`ID`, `ProprieteID`, `AgentID`, `ClientID`, `Statut`, `heure_rendezvous`, `date_rendezvous`) VALUES
(4, 1, 1, 1, 'Confirmé', '12:00:00', 'Lundi'),
(5, 1, 1, 1, 'Confirmé', '08:00:00', 'Mercredi'),
(6, 1, 1, 1, 'Confirmé', '14:00:00', 'Lundi');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MotDePasse` varchar(255) NOT NULL,
  `Adresse` text,
  `Type` enum('Client','Agent','Administrateur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `Nom`, `Prenom`, `Email`, `MotDePasse`, `Adresse`, `Type`) VALUES
(1, 'VICTOR', 'Dupont', 'VICTOR@GMAIL.COM', 'password', '12rue ', 'Client'),
(2, 'Marie', 'Curie', 'marie.curie@example.com', 'password', '456 Avenue de France, 75002 Paris', 'Agent');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UtilisateurID` (`UtilisateurID`);

--
-- Indexes for table `creneauxhoraires`
--
ALTER TABLE `creneauxhoraires`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AgentID` (`AgentID`);

--
-- Indexes for table `propriete`
--
ALTER TABLE `propriete`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AgentID` (`AgentID`);

--
-- Indexes for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProprieteID` (`ProprieteID`),
  ADD KEY `AgentID` (`AgentID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `creneauxhoraires`
--
ALTER TABLE `creneauxhoraires`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `propriete`
--
ALTER TABLE `propriete`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `agent_ibfk_1` FOREIGN KEY (`UtilisateurID`) REFERENCES `utilisateur` (`ID`);

--
-- Constraints for table `creneauxhoraires`
--
ALTER TABLE `creneauxhoraires`
  ADD CONSTRAINT `creneauxhoraires_ibfk_1` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`ID`);

--
-- Constraints for table `propriete`
--
ALTER TABLE `propriete`
  ADD CONSTRAINT `propriete_ibfk_1` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`ID`);

--
-- Constraints for table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`ProprieteID`) REFERENCES `propriete` (`ID`),
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`AgentID`) REFERENCES `agent` (`ID`),
  ADD CONSTRAINT `rendezvous_ibfk_3` FOREIGN KEY (`ClientID`) REFERENCES `utilisateur` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
