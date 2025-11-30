-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 17 nov. 2025 à 09:47
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gogoleform`
--

-- --------------------------------------------------------

--
-- Structure de la table `MDP`
--

CREATE TABLE `MDP` (
  `idutilisateur` int(11) NOT NULL,
  `login` varchar(11) NOT NULL,
  `MDP` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `MDP`
--

INSERT INTO `MDP` (`idutilisateur`, `login`, `MDP`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

CREATE TABLE `propositions` (
  `id_question` int(11) NOT NULL,
  `proposition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id_question` int(11) NOT NULL,
  `intitule` text NOT NULL,
  `id_sondage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id_question`, `intitule`, `id_sondage`) VALUES
(1, 'chocolat', 1),
(2, 'fqsfqsdf', 1),
(3, 'veux tu moi ?', 1),
(4, 'veux tu serrer', 1),
(5, 'oui ?', 2),
(6, 'Fourchette ou cuillère ?', 2);

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id_rep` int(11) NOT NULL,
  `valeur` text NOT NULL,
  `id_question` int(11) NOT NULL,
  `hash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id_rep`, `valeur`, `id_question`, `hash`) VALUES
(8, 'blanc', 1, 1),
(9, 'caca', 1, 1),
(10, 'qsdqd', 2, 1),
(11, 'uiluiu', 2, 1),
(12, 'bien evidemment', 3, 1),
(13, 'Antoine Daniel (Jack)', 3, 1),
(14, 'tournevis', 4, 1),
(15, 'caquerelle', 4, 1),
(16, 'peut être', 5, 1),
(17, 'surement', 5, 1),
(18, 'grss', 5, 1),
(19, 'ISS', 5, 1),
(20, 'cuillère mais c\'est moi la petite', 6, 1),
(21, 'un coup, quatre trous', 6, 1),
(22, 'surement', 5, 1),
(23, 'cuillère mais c\'est moi la petite', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sondage`
--

CREATE TABLE `sondage` (
  `id_sondage` int(11) NOT NULL,
  `titre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sondage`
--

INSERT INTO `sondage` (`id_sondage`, `titre`) VALUES
(1, 'recette'),
(2, 'Sondage du 2025-11-17 09:33:59');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `hash` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `idutilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`hash`, `nom`, `prenom`, `idutilisateur`) VALUES
(1, 'Admin', 'Super', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `MDP`
--
ALTER TABLE `MDP`
  ADD PRIMARY KEY (`idutilisateur`),
  ADD KEY `idutilisateur` (`idutilisateur`);

--
-- Index pour la table `propositions`
--
ALTER TABLE `propositions`
  ADD PRIMARY KEY (`id_question`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_sondage` (`id_sondage`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `id_question` (`id_question`),
  ADD KEY `hash` (`hash`);

--
-- Index pour la table `sondage`
--
ALTER TABLE `sondage`
  ADD PRIMARY KEY (`id_sondage`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`hash`),
  ADD UNIQUE KEY `hash_3` (`hash`),
  ADD KEY `hash` (`hash`),
  ADD KEY `hash_2` (`hash`),
  ADD KEY `idutilisateur` (`idutilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id_rep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `sondage`
--
ALTER TABLE `sondage`
  MODIFY `id_sondage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `MDP`
--
ALTER TABLE `MDP`
  ADD CONSTRAINT `MDP_ibfk_1` FOREIGN KEY (`idutilisateur`) REFERENCES `utilisateurs` (`idutilisateur`);

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_sondage`) REFERENCES `sondage` (`id_sondage`);

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`),
  ADD CONSTRAINT `reponses_ibfk_2` FOREIGN KEY (`hash`) REFERENCES `utilisateurs` (`hash`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
