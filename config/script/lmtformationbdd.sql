-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 07 juil. 2022 à 14:38
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lmtformationbdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `be_paid`
--

DROP TABLE IF EXISTS `be_paid`;
CREATE TABLE IF NOT EXISTS `be_paid` (
  `financing_type_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `facture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`financing_type_id`,`session_id`),
  KEY `IDX_BFF53065E4D10BA9` (`financing_type_id`),
  KEY `IDX_BFF53065613FECDF` (`session_id`),
  KEY `financing_type_id` (`financing_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `be_paid`
--

INSERT INTO `be_paid` (`financing_type_id`, `session_id`, `facture`) VALUES
(1, 1, NULL),
(2, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `company_type`
--

DROP TABLE IF EXISTS `company_type`;
CREATE TABLE IF NOT EXISTS `company_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `company_type`
--

INSERT INTO `company_type` (`id`, `name`) VALUES
(1, 'Organisme de formation'),
(2, 'Mairie'),
(3, 'Equipementier'),
(4, 'SSII'),
(5, 'Constructeur'),
(6, 'Industrie'),
(7, 'Batiment');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_type_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `civility` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `landline_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C62E6385F63AD12` (`contact_type_id`),
  KEY `IDX_4C62E6389395C3F3` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `contact_type_id`, `customer_id`, `civility`, `name`, `firstname`, `mail`, `mobile_phone`, `landline_phone`) VALUES
(34, 1, 40, 'Mme', 'ABOR', 'Laetitia', 'labor@manteslajolie.fr', '', '01.34.78.81.54'),
(36, 2, 42, 'Mme', 'HANNIERE', 'Sandrine', '', '', ''),
(37, 1, 42, 'Mme', 'GOMIS', 'Elisabeth', '', '', ''),
(38, 2, 43, 'M', 'Moulard', 'Willy', 'w.moulard@aforp.fr', '06 23 28 59 72', ''),
(39, 1, 45, '', 'SABI', 'Abdelkader', '', '+33663107084', '');

-- --------------------------------------------------------

--
-- Structure de la table `contact_type`
--

DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE IF NOT EXISTS `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contact_type`
--

INSERT INTO `contact_type` (`id`, `name`) VALUES
(1, 'Technico-commercial'),
(2, 'Facturation'),
(3, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_81398E09E51E9644` (`company_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `company_type_id`, `name`, `website`, `address`, `country`, `city`, `postal`) VALUES
(40, 2, 'Mairie de Mantes La Jolie', '', '31 rue Gambetta', '', 'Mantes La Jolie', 78200),
(42, 1, 'ALTRAN', '', 'avenue Paul Dautier', 'France', 'Vélizy', 78140),
(43, 1, 'AFORP', '', '64 Avenue de la plaine', '', 'Tremblay- en - France', 93290),
(44, 1, 'SABI', '', '3 rue Saint Vincent de Paul', 'Abdelkader', 'Chartres - (28000)', 28000),
(45, 1, 'ACactusRealm', '', '3 rue Saint Vincent de Paul', 'France', 'Chartres - (28000)', 28000);

-- --------------------------------------------------------

--
-- Structure de la table `customize_training`
--

DROP TABLE IF EXISTS `customize_training`;
CREATE TABLE IF NOT EXISTS `customize_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_hours` int(11) DEFAULT NULL,
  `training_price` int(11) DEFAULT NULL,
  `materials` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `customize_training_training_request`
--

DROP TABLE IF EXISTS `customize_training_training_request`;
CREATE TABLE IF NOT EXISTS `customize_training_training_request` (
  `customize_training_id` int(11) NOT NULL,
  `training_request_id` int(11) NOT NULL,
  PRIMARY KEY (`customize_training_id`,`training_request_id`),
  KEY `IDX_9B435A56A512D5ED` (`customize_training_id`),
  KEY `IDX_9B435A56F8C002C3` (`training_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220112121846', '2022-01-12 12:21:17', 19887),
('DoctrineMigrations\\Version20220112150059', '2022-01-12 15:01:08', 691);

-- --------------------------------------------------------

--
-- Structure de la table `financing_type`
--

DROP TABLE IF EXISTS `financing_type`;
CREATE TABLE IF NOT EXISTS `financing_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `financing_type`
--

INSERT INTO `financing_type` (`id`, `name`) VALUES
(1, 'Solo'),
(2, 'OPCO');

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

DROP TABLE IF EXISTS `formateur`;
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigram` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `urssaf` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id`, `name`, `firstname`, `trigram`, `skill`, `salary`, `urssaf`) VALUES
(1, 'TOUATI', 'Léo', 'LTO', '.', 2000, 1000),
(2, 'JACHNA', 'Emmanuel', 'EJA', 'Habilitation électrique', 150, 100),
(3, 'BACCOUCH', 'Amira', 'ABA', 'Habilitation électrique', 150, 100);

-- --------------------------------------------------------

--
-- Structure de la table `formation_type_formation`
--

DROP TABLE IF EXISTS `formation_type_formation`;
CREATE TABLE IF NOT EXISTS `formation_type_formation` (
  `formation_id` int(11) NOT NULL,
  `type_formation_id` int(11) NOT NULL,
  PRIMARY KEY (`formation_id`,`type_formation_id`),
  KEY `formation_id` (`formation_id`,`type_formation_id`),
  KEY `FK_type_formation` (`type_formation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `formation_type_formation`
--

INSERT INTO `formation_type_formation` (`formation_id`, `type_formation_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainer_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `to_do_list_id` int(11) DEFAULT NULL,
  `standard_training_id` int(11) DEFAULT NULL,
  `customize_training_id` int(11) DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nb_trainee` int(11) DEFAULT NULL,
  `estimate_price` int(11) DEFAULT NULL,
  `number_estimate` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_order` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D044D5D4B3AB48EB` (`to_do_list_id`),
  KEY `IDX_D044D5D4FB08EDF6` (`trainer_id`),
  KEY `IDX_D044D5D46BF700BD` (`status_id`),
  KEY `IDX_D044D5D48C2B84E9` (`standard_training_id`),
  KEY `IDX_D044D5D4A512D5ED` (`customize_training_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `trainer_id`, `status_id`, `to_do_list_id`, `standard_training_id`, `customize_training_id`, `place`, `nb_trainee`, `estimate_price`, `number_estimate`, `purchase_order`, `note`) VALUES
(1, NULL, 1, 1, 3, NULL, ' rue du boucher', 3, 120, NULL, NULL, 'rien'),
(2, NULL, 6, 2, 18, NULL, 'cz', 4, 1200, NULL, NULL, 'dz');

-- --------------------------------------------------------

--
-- Structure de la table `session_customer`
--

DROP TABLE IF EXISTS `session_customer`;
CREATE TABLE IF NOT EXISTS `session_customer` (
  `session_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`session_id`,`customer_id`),
  KEY `IDX_A95EE61613FECDF` (`session_id`),
  KEY `IDX_A95EE619395C3F3` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session_customer`
--

INSERT INTO `session_customer` (`session_id`, `customer_id`) VALUES
(1, 42),
(2, 40);

-- --------------------------------------------------------

--
-- Structure de la table `session_date`
--

DROP TABLE IF EXISTS `session_date`;
CREATE TABLE IF NOT EXISTS `session_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) DEFAULT NULL,
  `day` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_formation` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6CEF3750613FECDF` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session_date`
--

INSERT INTO `session_date` (`id`, `session_id`, `day`, `date_formation`) VALUES
(112, 1, 'JOUR_0', '2020-12-23'),
(113, 2, 'JOUR_0', '2020-12-23');

-- --------------------------------------------------------

--
-- Structure de la table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `skills_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`skills_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `skills`
--

INSERT INTO `skills` (`skills_id`, `name`) VALUES
(1, 'connaître les lois de l\'électricité, ainsi que les normes à respecter.'),
(2, 'savoir adopter une vision globale du projet.'),
(3, 'être capable de respecter des délais stricts.'),
(4, 'mécanique'),
(5, 'électronique '),
(6, 'logiciel');

-- --------------------------------------------------------

--
-- Structure de la table `standard_training`
--

DROP TABLE IF EXISTS `standard_training`;
CREATE TABLE IF NOT EXISTS `standard_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `training_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_hours` int(11) DEFAULT NULL,
  `training_price` int(11) DEFAULT NULL,
  `materials` longtext COLLATE utf8mb4_unicode_ci,
  `reference` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5731DBA018721C9D` (`training_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `standard_training`
--

INSERT INTO `standard_training` (`id`, `training_type_id`, `name`, `nb_hours`, `training_price`, `materials`, `reference`, `family`) VALUES
(1, 1, 'Fonctionnement d\'un véhicule électrique/hybride', 14, 1400, NULL, 'FRM_001-B', NULL),
(2, NULL, 'Lecture de schéma électrique', 7, 500, NULL, 'FRM_Perso_AJC', NULL),
(3, NULL, 'Habilitation électrique BRL B1L B2L BCR BEL Essai', 14, 1700, NULL, 'FRM_002-A', NULL),
(4, NULL, 'Habilitation électrique B1 B2 BC BR BE essai', 21, 1518, NULL, 'FRM_002-D', NULL),
(5, NULL, 'Habilitation électrique BS-BE Manoeuvre', 14, 1012, NULL, 'FRM_002-E', NULL),
(6, NULL, 'Etude de l\'outil Dyagalyzer', 7, 750, NULL, 'FRM_010', NULL),
(7, NULL, 'Etude du protocole Ethernet Automobile', 14, 1615, NULL, 'FRM_004', NULL),
(8, NULL, 'Etude des protocoles de communication automobile', 21, 1815, NULL, 'FRM_026', NULL),
(9, NULL, 'Etude du protocole CAN & outil CANalyzer', 14, 1700, NULL, 'FRM_018-B', NULL),
(13, NULL, 'Habilitation électrique H0 B0', 7, 1027, NULL, 'FRM_002-B', NULL),
(14, NULL, 'Habilitation électrique BS BE Manoeuvre Recyclage', 10, 1390, NULL, 'FRM_002-E', NULL),
(15, NULL, 'Architecture embarquée', 28, 4600, NULL, 'FRM_019', NULL),
(16, NULL, 'PAC Pompes A Chaleur', 35, 2500, NULL, 'FRM_ perso ETC', NULL),
(17, NULL, 'Analyse Fonctionnelle', 14, 1000, NULL, 'FRM_ 027', NULL),
(18, NULL, 'SDF ISO 26262', 14, 1000, NULL, 'FRM_029', NULL),
(19, NULL, 'Etude des protocoles de communication automobile', 21, 1500, NULL, 'FRM_026', NULL),
(20, NULL, 'AGILE', 14, 1000, NULL, 'FRM_ perso ETC', NULL),
(21, NULL, 'Introduction aux ADAS et véhicule autonome', 14, 1000, NULL, 'FRM_028', NULL),
(22, NULL, 'Les fondamentaux d\'un ECU embarquée et les nouveaux systèmes', 14, 1000, NULL, 'FRM_040', NULL),
(25, NULL, 'Habilitation électrique B1-B2-BC-BR', 21, 1855, NULL, 'FRM_002-D', NULL),
(26, NULL, 'Habilitation électrique B1-B2-BC-BR Recyclage', 14, 1435, NULL, 'FRM_002-D', NULL),
(28, NULL, 'autre', NULL, NULL, NULL, NULL, NULL),
(29, NULL, 'IRVE', 7, 950, NULL, 'FRM_037', NULL),
(30, NULL, 'Gestion et tracabilité des exigences', 21, 2940, NULL, 'FRM_035', NULL),
(31, NULL, 'Developpement en langage CAPL', 7, 450, NULL, 'FRM_009', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `standard_training_training_request`
--

DROP TABLE IF EXISTS `standard_training_training_request`;
CREATE TABLE IF NOT EXISTS `standard_training_training_request` (
  `standard_training_id` int(11) NOT NULL,
  `training_request_id` int(11) NOT NULL,
  PRIMARY KEY (`standard_training_id`,`training_request_id`),
  KEY `IDX_22A2867E8C2B84E9` (`standard_training_id`),
  KEY `IDX_22A2867EF8C002C3` (`training_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `standard_training_training_request`
--

INSERT INTO `standard_training_training_request` (`standard_training_id`, `training_request_id`) VALUES
(1, 7),
(6, 8),
(9, 7),
(9, 8),
(15, 6),
(22, 7);

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Confirmée'),
(2, 'Réalisée'),
(6, 'En Option'),
(7, 'Annulée'),
(8, 'À Planifier');

-- --------------------------------------------------------

--
-- Structure de la table `to_do_list`
--

DROP TABLE IF EXISTS `to_do_list`;
CREATE TABLE IF NOT EXISTS `to_do_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract` bit(1) DEFAULT NULL,
  `agreement` bit(7) DEFAULT NULL,
  `convocation` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trainer_folder` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `certificate` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empowerment_title` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `survey` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settlement` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign_in_sheet` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_page` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `to_do_list`
--

INSERT INTO `to_do_list` (`id`, `contract`, `agreement`, `convocation`, `trainer_folder`, `certificate`, `empowerment_title`, `invoice`, `survey`, `settlement`, `sign_in_sheet`, `front_page`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `to_know`
--

DROP TABLE IF EXISTS `to_know`;
CREATE TABLE IF NOT EXISTS `to_know` (
  `skills_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  PRIMARY KEY (`skills_id`,`trainer_id`),
  KEY `FK_trainer` (`trainer_id`),
  KEY `skills_id` (`skills_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `to_know`
--

INSERT INTO `to_know` (`skills_id`, `trainer_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `training_request`
--

DROP TABLE IF EXISTS `training_request`;
CREATE TABLE IF NOT EXISTS `training_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_request` datetime NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E6A91F919395C3F3` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `training_request`
--

INSERT INTO `training_request` (`id`, `customer_id`, `name`, `firstname`, `mail`, `phone`, `date_request`, `note`, `status`) VALUES
(6, 42, 'OUERTANI', 'Wissem', 'wissem.ouertani@gmail.com', '0614020244', '2022-05-12 00:00:00', 'ALTRAN ce monnsieur a fait la formation chez qualifelec mais a payé chez afnor Besoin d\'une formation en inter pour une personne mais avec peut être deux personnes si possible la deuxième sera gratuite Envoi d\'un devis sur 3 personnes avec une réduction vu que cela se fasse chez sa société', NULL),
(7, 42, 'BRULE', 'Philippe', 'philippe.brule66@gmail.com', '0631388376', '2022-05-25 00:00:00', '                                                                                                            BRL Conseils prestataire Prevact inter FRM 001 C fonctionnement véh hybride élec Bonjour Patrick, nous nous sommes rencontrés chez Jean-Charles Bossi au barbecue du mois d\'août. Je suis indépendant et j\'anime des formations BT pour Prévact. Je m\'intéresse aux véhicules électriques et souhaiterais me former sur le sujet... Etant indépendant, comment puis-je participer à une de vos formations ? Quelle formation me conseilles-tu ? Merci pour tes conseils. Cordialement, Philippe Brulé.\r\n                                \r\n                                \r\n                                ', NULL),
(8, 40, 'VERDIER', 'Bertrand', 'bertrand.verdier@capgemini.com', '', '2022-05-05 00:00:00', 'CANalyzer, DIAGalyzer', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `training_type`
--

DROP TABLE IF EXISTS `training_type`;
CREATE TABLE IF NOT EXISTS `training_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `training_type`
--

INSERT INTO `training_type` (`id`, `name`) VALUES
(1, 'Architecture automobile'),
(2, 'Eléctrotechnique'),
(3, 'Diagnostic automobile'),
(4, 'Protocole de communication'),
(5, 'Outil de développement et de validation');

-- --------------------------------------------------------

--
-- Structure de la table `training_type_skills`
--

DROP TABLE IF EXISTS `training_type_skills`;
CREATE TABLE IF NOT EXISTS `training_type_skills` (
  `training_type_id` int(11) NOT NULL,
  `skills_id` int(11) NOT NULL,
  PRIMARY KEY (`training_type_id`,`skills_id`),
  KEY `training_type_id` (`training_type_id`,`skills_id`),
  KEY `FK_skills` (`skills_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `training_type_skills`
--

INSERT INTO `training_type_skills` (`training_type_id`, `skills_id`) VALUES
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `be_paid`
--
ALTER TABLE `be_paid`
  ADD CONSTRAINT `FK_BFF53065613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `FK_BFF53065E4D10BA9` FOREIGN KEY (`financing_type_id`) REFERENCES `financing_type` (`id`);

--
-- Contraintes pour la table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_4C62E6385F63AD12` FOREIGN KEY (`contact_type_id`) REFERENCES `contact_type` (`id`),
  ADD CONSTRAINT `FK_4C62E6389395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Contraintes pour la table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `FK_81398E09E51E9644` FOREIGN KEY (`company_type_id`) REFERENCES `company_type` (`id`);

--
-- Contraintes pour la table `customize_training_training_request`
--
ALTER TABLE `customize_training_training_request`
  ADD CONSTRAINT `FK_9B435A56A512D5ED` FOREIGN KEY (`customize_training_id`) REFERENCES `customize_training` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9B435A56F8C002C3` FOREIGN KEY (`training_request_id`) REFERENCES `training_request` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_D044D5D46BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `FK_D044D5D48C2B84E9` FOREIGN KEY (`standard_training_id`) REFERENCES `standard_training` (`id`),
  ADD CONSTRAINT `FK_D044D5D4A512D5ED` FOREIGN KEY (`customize_training_id`) REFERENCES `customize_training` (`id`),
  ADD CONSTRAINT `FK_D044D5D4B3AB48EB` FOREIGN KEY (`to_do_list_id`) REFERENCES `to_do_list` (`id`),
  ADD CONSTRAINT `FK_D044D5D4FB08EDF6` FOREIGN KEY (`trainer_id`) REFERENCES `formateur` (`id`);

--
-- Contraintes pour la table `session_customer`
--
ALTER TABLE `session_customer`
  ADD CONSTRAINT `FK_A95EE61613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A95EE619395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `session_date`
--
ALTER TABLE `session_date`
  ADD CONSTRAINT `FK_6CEF3750613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);

--
-- Contraintes pour la table `standard_training`
--
ALTER TABLE `standard_training`
  ADD CONSTRAINT `FK_5731DBA018721C9D` FOREIGN KEY (`training_type_id`) REFERENCES `training_type` (`id`);

--
-- Contraintes pour la table `standard_training_training_request`
--
ALTER TABLE `standard_training_training_request`
  ADD CONSTRAINT `FK_22A2867E8C2B84E9` FOREIGN KEY (`standard_training_id`) REFERENCES `standard_training` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_22A2867EF8C002C3` FOREIGN KEY (`training_request_id`) REFERENCES `training_request` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `training_request`
--
ALTER TABLE `training_request`
  ADD CONSTRAINT `FK_E6A91F919395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
