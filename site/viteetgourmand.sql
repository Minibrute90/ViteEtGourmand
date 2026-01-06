-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2026 at 06:06 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `viteetgourmand`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
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
-- Dumping data for table `avis`
--

INSERT INTO `avis` (`avis_id`, `avis_nom`, `avis_theme`, `avis_note`, `avis_description`) VALUES
(1, 'Marie L.', 'Anniversaire familial', '5', '\"Un grand merci à Julie et José ! Tout était délicieux, du début à la fin. Nos invités se sont régalés et l\'ambiance était tellement chaleureuse. On ressent vraiment le fait-maison et la passion derrière chaque plat.\"'),
(2, 'Thomas & Élodie', 'Baptême', '5', '\"Prestation parfaite ! Le buffet était magnifique et les saveurs incroyables. Vous avez contribué à rendre cette journée mémorable pour toute notre famille. Nous recommandons les yeux fermés.\"'),
(3, 'Sophie D.', 'Repas d\'entreprise', '5', '\"Professionnels, réactifs et vraiment à l\'écoute. Le menu proposé était original et raffiné, tout le monde a adoré. Une équipe humaine et passionnée !\"'),
(4, 'Nicolas R.', 'Noël en famille', '5', '\"Merci pour ce repas exceptionnel. On a eu l\'impression d\'accueillir un chef à la maison ! Les plats étaient généreux, gourmands et parfaitement présentés.\"');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
