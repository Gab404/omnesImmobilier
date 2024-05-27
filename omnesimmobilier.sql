-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 mai 2024 à 20:55
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `omnesimmobilier`
--

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

DROP TABLE IF EXISTS `agent`;
CREATE TABLE IF NOT EXISTS `agent` (
  `email` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `photoPath` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`email`, `prenom`, `nom`, `photoPath`) VALUES
('shani.blumel@omnes.immobilier.com', 'Shani', 'Blumel', 'assets/agent/shaniBlumel.jpg'),
('mendy.furmansky@omnes.immobilier.com', 'Mendy', 'Furmansky', 'assets/agent/mendyFurmansky.jpg'),
('charlene.phung@omnes.immobilier.com', 'Charlene', 'Phung', 'assets/agent/charlenePhung.jpg'),
('maiky.nunez@omnes.immobilier.com', 'Maiky', 'Nunez', 'assets/agent/maikyNunez.jpg'),
('maimouna.ndiaye@omnes.immobilier.com', 'Maimouna', 'Ndiaye', 'assets/agent/maimounaNdiaye.jpg'),
('tommaso.nicolazzo@example.com', 'Tommaso', 'Nicolazzo', 'assets/agent/tommasoNicolazzo.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `photo` longblob,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`email`, `password`, `nom`, `prenom`, `adresse`, `tel`, `photo`, `id`) VALUES
('matteo.leon@edu.ece.fr', '123456789', 'leon', 'matteo', 'boulogne', '5678655789', NULL, 1),
('malik.hassanne@edu.ece.fr', '123456789', 'Hassanne', 'Malik', '45 rue clamart zoo', '0987654321', NULL, 2),
('gabrielguietdupre@gmail.com', '123456789', 'Guiet-Dupré', 'Gabriel', '37 rue des fleurs', '0768290664', 0x75706c6f6164732f49445f70686f746f2e6a7067, 3);

-- --------------------------------------------------------

--
-- Structure de la table `immobilier`
--

DROP TABLE IF EXISTS `immobilier`;
CREATE TABLE IF NOT EXISTS `immobilier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `photoPath` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `nbPiece` int NOT NULL,
  `nbChambre` int NOT NULL,
  `dimension` int NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `pathVideo` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `prix` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `immobilier`
--

INSERT INTO `immobilier` (`id`, `photoPath`, `description`, `nbPiece`, `nbChambre`, `dimension`, `adresse`, `pathVideo`, `type`, `prix`) VALUES
(1, 'assets/immobilier/0001.jpg', 'Appartement spacieux avec vue sur la ville.', 3, 2, 75, '123 Rue de la Paix, Ville A', '', 'location', 965),
(2, 'assets/immobilier/0002.jpg', 'Appartement moderne près du centre-ville.', 2, 1, 50, '456 Avenue du Général, Ville B', '', 'location', 955),
(3, 'assets/immobilier/0003.jpg', 'Charmant appartement dans un quartier calme.', 4, 3, 90, '789 Boulevard des Champs, Ville C', '', 'location', 779),
(4, 'assets/immobilier/0004.jpg', 'Appartement avec grand balcon.', 3, 2, 80, '1010 Rue des Fleurs, Ville D', '', 'location', 732),
(5, 'assets/immobilier/0005.jpg', 'Appartement lumineux avec cuisine équipée.', 2, 1, 55, '1111 Rue des Lilas, Ville E', '', 'location', 1021),
(6, 'assets/immobilier/0006.jpg', 'Appartement proche des commodités.', 3, 2, 70, '1212 Avenue des Roses, Ville F', '', 'location', 1011),
(7, 'assets/immobilier/0007.jpg', 'Appartement récemment rénové.', 4, 3, 85, '1313 Rue des Tulipes, Ville G', '', 'location', 893),
(8, 'assets/immobilier/0008.jpg', 'Appartement au dernier étage avec vue dégagée.', 3, 2, 65, '1414 Boulevard des Ormes, Ville H', '', 'location', 734),
(9, 'assets/immobilier/0009.jpg', 'Appartement idéal pour une famille.', 5, 4, 100, '1515 Avenue des Pins, Ville I', '', 'location', 1089),
(10, 'assets/immobilier/0010.jpg', 'Terrain constructible avec belle vue.', 0, 0, 500, 'Route de la Forêt, Village A', '', 'terrain', 25000),
(11, 'assets/immobilier/0011.jpg', 'Terrain agricole fertile.', 0, 0, 1000, 'Chemin des Vignes, Village B', '', 'terrain', 50000),
(12, 'assets/immobilier/0012.jpg', 'Terrain plat proche de la rivière.', 0, 0, 750, 'Route de la Rivière, Village C', '', 'terrain', 37500),
(13, 'assets/immobilier/0013.jpg', 'Grand terrain avec accès facile.', 0, 0, 1200, 'Avenue des Platanes, Village D', '', 'terrain', 60000),
(14, 'assets/immobilier/0014.jpg', 'Terrain à bâtir en zone résidentielle.', 0, 0, 800, 'Rue des Chênes, Village E', '', 'terrain', 40000),
(15, 'assets/immobilier/0015.jpg', 'Local commercial en plein centre-ville.', 5, 0, 150, '1 Place du Commerce, Ville J', '', 'commercial', 225000),
(16, 'assets/immobilier/0016.jpg', 'Bureau moderne avec open space.', 3, 0, 120, '2 Rue des Entrepreneurs, Ville K', '', 'commercial', 180000),
(17, 'assets/immobilier/0017.jpg', 'Espace de coworking lumineux.', 4, 0, 200, '3 Avenue des Startups, Ville L', '', 'commercial', 300000),
(18, 'assets/immobilier/0018.jpg', 'Commerce avec grande vitrine.', 2, 0, 100, '4 Boulevard des Artisans, Ville M', '', 'commercial', 150000),
(19, 'assets/immobilier/0019.jpg', 'Entrepôt bien situé.', 1, 0, 300, '5 Route Industrielle, Ville N', '', 'commercial', 450000),
(20, 'assets/immobilier/0020.jpg', 'Restaurant équipé prêt à l’emploi.', 6, 0, 180, '6 Rue des Gourmets, Ville O', '', 'commercial', 270000),
(21, 'assets/immobilier/0021.jpg', 'Magasin dans zone commerciale.', 3, 0, 130, '7 Centre Commercial, Ville P', '', 'commercial', 195000),
(22, 'assets/immobilier/0022.jpg', 'Maison familiale avec jardin.', 6, 4, 200, '8 Rue des Familles, Ville Q', '', 'residentiel', 400000),
(23, 'assets/immobilier/0023.jpg', 'Villa moderne avec piscine.', 7, 5, 350, '9 Avenue du Luxe, Ville R', '', 'residentiel', 700000),
(24, 'assets/immobilier/0024.jpg', 'Appartement cosy en centre-ville.', 3, 2, 80, '10 Boulevard du Centre, Ville S', '', 'residentiel', 160000),
(25, 'assets/immobilier/0025.jpg', 'Duplex avec terrasse.', 5, 3, 150, '11 Rue des Terrasses, Ville T', '', 'residentiel', 300000),
(26, 'assets/immobilier/0026.jpg', 'Maison de campagne tranquille.', 4, 3, 180, '12 Chemin des Champs, Village U', '', 'residentiel', 360000),
(27, 'assets/immobilier/0027.jpg', 'Penthouse avec vue panoramique.', 4, 2, 220, '13 Rue des Cimes, Ville V', '', 'residentiel', 440000);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
