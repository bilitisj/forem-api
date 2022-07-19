-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 19 juil. 2022 à 15:00
-- Version du serveur :  5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `visio_sfc`
--

-- --------------------------------------------------------

--
-- Structure de la table `centre`
--

CREATE TABLE `centre` (
  `id_centre` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `centre`
--

INSERT INTO `centre` (`id_centre`, `name`) VALUES
(1, 'Cepegra'),
(2, 'Technobel'),
(3, 'Corail');

-- --------------------------------------------------------

--
-- Structure de la table `comportement`
--

CREATE TABLE `comportement` (
  `id_comportement` int(10) UNSIGNED NOT NULL,
  `label` text NOT NULL,
  `id_savoir` int(11) NOT NULL,
  `niveau` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comportement`
--

INSERT INTO `comportement` (`id_comportement`, `label`, `id_savoir`, `niveau`) VALUES
(1, 'Je me fie à mon instinct et je commence à travailler sans réflexion', 1, 1),
(2, 'Je consulte le web à la recherche d\'une solution toute faite. Je fais appel à quelqu\'un pour m\'aider.', 1, 2),
(3, 'Je décompose un problème en sous-éléments en utilisant un schéma. Je consulte différentes ressources & documentations pour parvenir à une solution.', 1, 3),
(4, 'Je décompose un problème en sous-éléments en utilisant un schéma. Je consulte différentes ressources & documentations pour parvenir à une solution.', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id_evaluation` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `id_inscription` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `analyse` tinyint(4) DEFAULT NULL,
  `curiosite` tinyint(4) DEFAULT NULL,
  `autonomie` tinyint(4) DEFAULT NULL,
  `critique` tinyint(4) DEFAULT NULL,
  `organisation` tinyint(4) DEFAULT NULL,
  `motivation` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id_inscription` int(10) UNSIGNED NOT NULL,
  `id_session` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `metier`
--

CREATE TABLE `metier` (
  `id_metier` int(10) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `metier`
--

INSERT INTO `metier` (`id_metier`, `label`) VALUES
(1, 'WebDesigner Front-End'),
(2, 'Infographie'),
(3, 'Imprimeur');

-- --------------------------------------------------------

--
-- Structure de la table `savoir`
--

CREATE TABLE `savoir` (
  `id_savoir` int(10) UNSIGNED NOT NULL,
  `id_metier` int(11) NOT NULL,
  `definition` text NOT NULL,
  `theme` enum('organisation','analyse','curiosite','autonomie','critique','motivation') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `savoir`
--

INSERT INTO `savoir` (`id_savoir`, `id_metier`, `definition`, `theme`) VALUES
(1, 1, 'J\'analyse les problèmes pour y trouver des solutions\r\nCapacité de réfléchir et de faire montre de logique et de jugement face à des décisions, d\'évaluer des problèmes ou des situations en faisant les recherches nécessaires et en analysant les différentes composantes', 'analyse'),
(2, 1, 'Je suis curieux intellectuellement pour ce qui touche à mon métier\r\nCapacité d\'ouvrir son champ de connaissance, d\'avoir l\'esprit ouvert, d\'acquérir continuellement de nouvelles connaissances et d\'apprendre de ses expériences antérieures', 'curiosite'),
(3, 1, 'Je mène ma barque: Capacité de se prendre en charge, selon ses responsabilités, de façon à poser des actions au moment opportun dans un contexte déterminé', 'autonomie');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id_session` int(11) NOT NULL,
  `id_metier` int(11) NOT NULL,
  `label` varchar(200) NOT NULL,
  `id_centre` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_start` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id_session`, `id_metier`, `label`, `id_centre`, `id_user`, `date_start`) VALUES
(1, 1, 'Web Front 11', 1, 1, '2023-06-11'),
(2, 0, 'Dot Net 12', 2, 1, NULL),
(3, 2, 'Infographie', 2, 1, '2023-01-15');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `level` enum('stagiaire','secrétaire','formateur','admin') NOT NULL DEFAULT 'stagiaire'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `lastname`, `firstname`, `level`) VALUES
(1, 'pierre.charlier@forem.be', 'test', 'Charlier', 'Pierre', 'formateur'),
(2, 'louis.michel@belga.be', 'test', 'Michel', 'Louis', 'stagiaire'),
(3, 'francoise.devos@forem.be', 'test', 'Devos', 'Françoise', 'secrétaire'),
(4, 'admin@cepegra.be', 'pass', 'Forem', 'Damien', 'admin'),
(5, 'jambon_bilitis@hotmail.com', 'test', 'Jambon', 'Bilitis', 'stagiaire'),
(6, 'o.belery@gmail.com', 'test', 'Belery', 'Olivier', 'formateur');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `centre`
--
ALTER TABLE `centre`
  ADD PRIMARY KEY (`id_centre`);

--
-- Index pour la table `comportement`
--
ALTER TABLE `comportement`
  ADD PRIMARY KEY (`id_comportement`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id_evaluation`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id_inscription`);

--
-- Index pour la table `metier`
--
ALTER TABLE `metier`
  ADD PRIMARY KEY (`id_metier`);

--
-- Index pour la table `savoir`
--
ALTER TABLE `savoir`
  ADD PRIMARY KEY (`id_savoir`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `centre`
--
ALTER TABLE `centre`
  MODIFY `id_centre` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comportement`
--
ALTER TABLE `comportement`
  MODIFY `id_comportement` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id_evaluation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id_inscription` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `metier`
--
ALTER TABLE `metier`
  MODIFY `id_metier` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `savoir`
--
ALTER TABLE `savoir`
  MODIFY `id_savoir` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
