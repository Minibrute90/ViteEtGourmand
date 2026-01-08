-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 07 jan. 2026 à 09:56
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `viteetgourmand`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `avis_id` int NOT NULL AUTO_INCREMENT,
  `avis_nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avis_theme` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avis_note` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avis_description` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`avis_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`avis_id`, `avis_nom`, `avis_theme`, `avis_note`, `avis_description`) VALUES
(1, 'Marie L.', 'Anniversaire familial', '5', '\"Un grand merci à Julie et José ! Tout était délicieux, du début à la fin. Nos invités se sont régalés et l\'ambiance était tellement chaleureuse. On ressent vraiment le fait-maison et la passion derrière chaque plat.\"'),
(2, 'Thomas & Élodie', 'Baptême', '5', '\"Prestation parfaite ! Le buffet était magnifique et les saveurs incroyables. Vous avez contribué à rendre cette journée mémorable pour toute notre famille. Nous recommandons les yeux fermés.\"'),
(3, 'Sophie D.', 'Repas d\'entreprise', '5', '\"Professionnels, réactifs et vraiment à l\'écoute. Le menu proposé était original et raffiné, tout le monde a adoré. Une équipe humaine et passionnée !\"'),
(4, 'Nicolas R.', 'Noël en famille', '5', '\"Merci pour ce repas exceptionnel. On a eu l\'impression d\'accueillir un chef à la maison ! Les plats étaient généreux, gourmands et parfaitement présentés.\"');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `menu-id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `regime` varchar(20) NOT NULL,
  `entree` varchar(50) NOT NULL,
  `plat` varchar(50) NOT NULL,
  `dessert` varchar(50) NOT NULL,
  `allergene` varchar(100) NOT NULL,
  `Nombre-minimum-de-personnes` int NOT NULL,
  `prix` double NOT NULL,
  `conditions` varchar(250) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`menu-id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`menu-id`, `titre`, `description`, `regime`, `entree`, `plat`, `dessert`, `allergene`, `Nombre-minimum-de-personnes`, `prix`, `conditions`, `stock`) VALUES
(1, 'Noël Gourmand', 'Menu festif aux saveurs traditionnelles revisitées, idéal pour les repas de fin d’année.', 'Classique', 'Foie gras maison', 'Suprême de volaille, sauce forestière', 'Bûche chocolat noisette', 'lactose, gluten, fruits à coque.', 10, 480, 'commande minimum 14 jours avant – stockage au frais requis.', 5),
(2, 'Noël Végétarien', 'Alternative festive sans viande, tout aussi généreuse.', 'Végétarien', 'Tarte fine légumes d’hiver', 'Risotto aux champignons', 'Bûche fruits rouges', 'gluten, lactose', 8, 360, 'commande 10 jours avant.', 6),
(3, 'Pâques Tradition', 'Menu familial inspiré des grandes tablées de printemps.', 'Classique', 'Œufs mimosa', 'Gigot d’agneau, jus réduit', 'Nid de Pâques chocolat', 'œufs, moutarde, gluten, lactose. ', 10, 450, 'commande 10 jours avant.', 8),
(4, 'Classique Gourmand', 'Menu polyvalent pour tout type d’événement.', 'Classique', 'Salade de saison', 'Bœuf mijoté, légumes fondants', 'Tarte aux pommes', 'fruits à coque, gluten', 6, 270, 'commande 7 jours avant.', 10),
(5, 'Vegan Essentiel', 'Cuisine végétale savoureuse et équilibrée.', 'Vegan', 'Houmous & légumes croquants', 'Curry de légumes au lait de coco', 'Salade de fruits frais', 'Sésame', 6, 300, 'commande 5 jours avant.', 7),
(6, 'Événement Entreprise', 'Menu pratique et élégant pour réunions et séminaires.', 'Mixte', 'Verrines salées', 'Suprême de poulet / alternative végétarienne', 'Assortiment de mignardises', 'gluten, lactose, fruits à coque.', 15, 675, 'commande 7 jours avant.', 12),
(7, 'Printemps Fraîcheur', 'Menu léger mettant à l’honneur les produits du printemps.', 'Mixte', 'Asperges vinaigrette', 'Poisson du jour, légumes verts', 'Fraises au sucre et menthe', 'moutarde, poisson', 8, 360, 'commande 6 jours avant.', 9),
(8, 'Buffet Convivial', 'Menu libre et généreux, idéal pour les grandes tablées.', 'Classique', 'Charcuterie & fromages', 'Quiches variées', 'Cakes maison', 'gluten, œufs, lactose', 20, 800, 'commande 10 jours avant', 6),
(9, 'Sans Gluten', 'Menu adapté aux intolérances, sans compromis sur le goût.', 'Sans gluten', 'Salade composée', 'Poulet rôti, pommes de terre', 'Crème dessert maison', 'Lactose', 6, 330, 'commande 7 jours avant.\r\n', 5),
(10, 'Sur-Mesure Signature', 'Menu personnalisable selon vos envies et contraintes.', 'Tous', 'Entrée à définir avec le client', 'Plat à définir avec le client', 'Dessert à définir avec le client', 'Allergènes précisés à la validation', 10, 0, 'commande minimum 3 semaines avant', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
