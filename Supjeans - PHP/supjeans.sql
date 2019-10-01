-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 05 mai 2019 à 22:18
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `supjeans`
--
CREATE DATABASE IF NOT EXISTS `supjeans` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `supjeans`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Nom` (`Nom`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`Id`, `Nom`) VALUES
(4, 'Chaussure'),
(1, 'Jeans'),
(2, 'T-shirt'),
(3, 'Vestes');

-- --------------------------------------------------------

--
-- Structure de la table `objets`
--

DROP TABLE IF EXISTS `objets`;
CREATE TABLE IF NOT EXISTS `objets` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Categorie` int(11) NOT NULL,
  `Prix` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Disponibilite` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Nom` (`Nom`),
  KEY `Categorie` (`Categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objets`
--

INSERT INTO `objets` (`Id`, `Categorie`, `Prix`, `Nom`, `Image`, `Description`, `Disponibilite`) VALUES
(1, 2, 10, 'T-shirt Levis Homme', 'Image/T-shirt1.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(2, 2, 20, 'T-shirt Homme Bleue', 'Image/T-shirt.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(3, 2, 40, 'T-shirt Homme noir', 'Image/T-shirt2.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(4, 2, 5, 'T-shirt Homme blanc', 'Image/T-shirt3.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(5, 4, 20, 'Chaussure de ville homme', 'Image/Chaussure2.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(6, 4, 40, 'Chaussure danse de salon femme', 'Image/Chaussure3.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(7, 4, 5, 'Basket casual', 'Image/Chaussure1.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(8, 4, 10, 'Basket confort', 'Image/Chaussure.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(9, 1, 10, 'Jeans classique', 'Image/Jeans.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(10, 1, 20, 'Jeans noir', 'Image/jeans2.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(11, 1, 40, 'Jeans Décontracté', 'Image/jeans3.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(12, 1, 5, 'Jeans Slim', 'Image/jeans4.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(13, 3, 20, 'Vestes HILFY', 'Image/Veste.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(14, 3, 40, 'Vestes en jean', 'Image/Veste1.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(15, 3, 5, 'Vestes Hiver', 'Image/Veste2.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0),
(16, 3, 10, 'Vestes mode Homme', 'Image/Veste3.jpg', '100% Coton <br>\r\n\r\nLavage en machine, 30 degre max.\r\n <br>\r\nType de col: Col rond\r\n <br>\r\nTaille normale\r\n <br>\r\nManches courtes\r\n <br>\r\n', 0);

-- --------------------------------------------------------

--
-- Structure de la table `transaction history`
--

DROP TABLE IF EXISTS `transaction history`;
CREATE TABLE IF NOT EXISTS `transaction history` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Users` varchar(255) NOT NULL,
  `Produits` text NOT NULL,
  `Prix` text NOT NULL,
  `Total` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Complete` tinyint(1) NOT NULL,
  `Address` text NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Users` (`Users`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transaction history`
--

INSERT INTO `transaction history` (`ID`, `Users`, `Produits`, `Prix`, `Total`, `Date`, `Complete`, `Address`) VALUES
(4, 'Test@mail.fr', 'T-shirt Levis Homme L,9', '20', 180, '2019-04-30', 1, '12'),
(5, 'Admin@mail.fr', 'T-shirt Levis Homme L,1', '20', 20, '2019-04-30', 1, '12'),
(6, 'Test@mail.fr', 'Jeans DÃ©contractÃ©,1', '40', 40, '2019-05-01', 0, '12 rue des camomille');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Billing Address` text NOT NULL,
  `Delivery Address` text NOT NULL,
  `Role` tinyint(1) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `Email`, `Password`, `Billing Address`, `Delivery Address`, `Role`, `Name`, `Last_Name`) VALUES
(1, 'Test@mail.fr', '$2y$10$JlviiJORV.UEZ9ja.X73ieqIvHvVNybk.cuVcHK4q5f0s3RwEM7uK', '12 rue des camomille', '12 rue des camomille', 0, 'Test', 'Man'),
(2, 'Admin@mail.fr', '$2y$10$JlviiJORV.UEZ9ja.X73ieqIvHvVNybk.cuVcHK4q5f0s3RwEM7uK', '12 address des Admins', '12 address des Admins', 1, 'Admin', 'Admin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `objets`
--
ALTER TABLE `objets`
  ADD CONSTRAINT `Categorie` FOREIGN KEY (`Categorie`) REFERENCES `categorie` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `transaction history`
--
ALTER TABLE `transaction history`
  ADD CONSTRAINT `Users` FOREIGN KEY (`Users`) REFERENCES `users` (`Email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
