-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 sep. 2026 à 23:17
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lesnotes`
--

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id_matiere` int NOT NULL AUTO_INCREMENT,
  `libelle_mat` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coefficient` int NOT NULL,
  `heure` int NOT NULL,
  `id_prof` int NOT NULL,
  PRIMARY KEY (`id_matiere`),
  KEY `id_prof` (`id_prof`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id_matiere`, `libelle_mat`, `coefficient`, `heure`, `id_prof`) VALUES
(1, 'anglais', 2, 2, 10),
(2, 'algorithme', 2, 2, 2),
(3, 'Francais', 2, 2, 1),
(4, 'langage C', 2, 2, 4),
(5, 'merise', 4, 4, 3),
(6, 'php', 2, 3, 1),
(7, 'architecture ', 2, 2, 2),
(9, 'economie & gestion', 2, 2, 2),
(12, 'Negotiation', 2, 1, 0),
(13, 'securite informatique', 1, 2, 1),
(14, 'mathematique general', 3, 3, 3),
(15, 'Francais', 2, 3, 5),
(16, 'droit', 2, 2, 5),
(17, 'EDHC', 1, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `moyenne`
--

DROP TABLE IF EXISTS `moyenne`;
CREATE TABLE IF NOT EXISTS `moyenne` (
  `id_moy` int NOT NULL AUTO_INCREMENT,
  `id_matiere` int NOT NULL,
  `moyenne` float NOT NULL,
  `date_moy` date NOT NULL,
  PRIMARY KEY (`id_moy`),
  KEY `id_matiere` (`id_matiere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `id_periodeNote` int NOT NULL,
  `libelle_mat` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_note` date NOT NULL,
  `note` float NOT NULL,
  `id_Prof` int NOT NULL,
  `id_matiere` int NOT NULL,
  PRIMARY KEY (`id_note`),
  KEY `id_prof` (`id_Prof`),
  KEY `id_matiere` (`id_matiere`),
  KEY `id_periodeNote` (`id_periodeNote`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_note`, `id_periodeNote`, `libelle_mat`, `date_note`, `note`, `id_Prof`, `id_matiere`) VALUES
(1, 1, 'algorithme', '2026-06-03', 15, 2, 2),
(2, 1, 'anglais', '2026-06-12', 10, 10, 1),
(6, 1, 'anglais', '2026-07-29', 14, 10, 1),
(7, 1, 'merise', '2026-08-05', 12, 11, 5),
(29, 1, 'algorithme', '2026-09-01', 15, 2, 2),
(30, 1, 'algorithme', '2026-09-10', 10, 2, 2),
(31, 2, 'algorithme', '2026-09-27', 13, 2, 2),
(32, 1, 'algorithme', '2026-09-04', 18, 2, 2),
(33, 1, 'algorithme', '2026-09-19', 14, 2, 2),
(34, 1, 'merise', '2026-09-04', 12, 11, 5),
(35, 1, 'anglais', '2026-09-17', 13, 10, 1),
(36, 1, 'anglais', '2026-09-15', 18, 10, 1),
(37, 1, 'anglais', '2026-09-16', 12, 10, 1),
(38, 1, 'Francais', '2026-09-15', 10, 9, 3),
(39, 1, 'Francais', '2026-09-18', 9, 9, 3),
(40, 1, 'Francais', '2026-09-20', 15, 9, 3),
(41, 1, 'langage C', '2026-09-16', 15, 8, 4),
(42, 1, 'langage C', '2026-09-19', 14, 8, 4),
(43, 1, 'architecture ', '2026-09-09', 15, 1, 7),
(44, 1, 'php', '2026-09-10', 15, 1, 6),
(45, 1, 'mathematique general', '2026-09-21', 12, 3, 14),
(46, 1, 'mathematique general', '2026-09-16', 16, 3, 14),
(47, 1, 'economie & gestion', '2026-09-19', 18, 7, 9),
(48, 1, 'economie & gestion', '2026-09-20', 12, 7, 9),
(49, 1, 'php', '2026-09-18', 13, 10, 6);

-- --------------------------------------------------------

--
-- Structure de la table `periodenotes`
--

DROP TABLE IF EXISTS `periodenotes`;
CREATE TABLE IF NOT EXISTS `periodenotes` (
  `id_periodeNote` int NOT NULL AUTO_INCREMENT,
  `periode` int NOT NULL,
  PRIMARY KEY (`id_periodeNote`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `periodenotes`
--

INSERT INTO `periodenotes` (`id_periodeNote`, `periode`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

DROP TABLE IF EXISTS `professeurs`;
CREATE TABLE IF NOT EXISTS `professeurs` (
  `id_Prof` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` int NOT NULL,
  `jcours` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_matiere` int NOT NULL,
  `id_note` int NOT NULL,
  PRIMARY KEY (`id_Prof`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeurs`
--

INSERT INTO `professeurs` (`id_Prof`, `nom`, `prenom`, `tel`, `jcours`, `id_matiere`, `id_note`) VALUES
(1, 'bretro', 'romuald', 184962584, 'lundi', 7, 0),
(2, 'yao', 'Ferdinand', 586850496, 'mardi', 2, 0),
(3, 'gnaore', 'gnaore', 505094852, 'lundi', 14, 0),
(4, 'yao', 'prospers ', 778780285, 'samedi', 13, 0),
(5, 'nbgoti', 'amos', 596048685, 'samedi', 5, 0),
(7, 'zoffou', 'zoffou', 156243612, 'samedi', 12, 0),
(8, 'Lamine', 'janho', 156243612, 'mercredi', 4, 0),
(9, 'kone', 'aboulay', 789562111, 'lundi', 3, 0),
(10, 'akafou', 'akafou', 778780285, 'mardi', 1, 0),
(11, 'gnakan', 'gnakan', 778780285, 'mercredi ', 5, 0),
(15, 'Bakayoko', 'moussa', 156243612, 'jeudi', 17, 0),
(16, 'Bayoko', 'moussa', 156243612, 'jeudi', 17, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gmail` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `tel` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filiere` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `gmail`, `date_naiss`, `tel`, `matricule`, `filiere`, `classe`, `mdp`) VALUES
(18, 'dosso', 'moussa', 'bamsdoss785@gmail.com', '0000-00-00', '', '', '', '', '$2y$10$r6CrYWFPoupZEIaiAUNzH.Mr0F7hC1zMHdRR5X9pUUlxphGzy38Kq'),
(15, 'dan', 'tia', 'collab45@gmail.com', '2005-07-21', '', '', '', '', '$2y$10$Z1GV8E2diC6Yl2bQT2S4fe0Xqhig4gTS91gA.1ZimhhjXSXts5nO.'),
(14, 'dosso', 'moses', 'doss_mose8@mail.com', '2026-08-25', '', '', '', '', '$2y$10$HOLXfOGJMHkdYO5GxPphsuHlCa2bHjxN167rHbkVNbo55xHlHSi2y'),
(16, 'king', 'doss', 'doss_king8@mail.com', '2007-02-14', '', '', '', '', '$2y$10$aaYXwpIpGl6N9BjFeWZwVeP7H6tpo03ZTPybAQN4cYvSs6eOX4api'),
(19, 'dosso', 'levis', 'kingdoss735@gmail.com', '0000-00-00', '', '', '', '', '$2y$10$C0dtIqpvt4OFvAVSvE6mvOafS62e/mtbqbPgCp0/VTq4Vur5mHXMa');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_Prof`) REFERENCES `professeurs` (`id_Prof`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`id_matiere`) REFERENCES `matieres` (`id_matiere`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
