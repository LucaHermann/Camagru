-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 10 oct. 2018 à 18:38
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `camagru`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--
CREATE TABLE `comment` (
  `user_id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL,
  `text` varchar(140) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `forgot_password`
--
CREATE TABLE `forgot_password` (
  `user_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--
CREATE TABLE `image` (
  `date` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `idimg` int(11) NOT NULL,
  `img_path` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `img_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `img` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `img_id` (`img_id`);

--
-- Index pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD KEY `user_id` (`user_id`);
--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`idimg`),
  ADD KEY `id_user` (`id_user`);
--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD KEY `img_id` (`img_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `idimg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`img_id`) REFERENCES `image` (`idimg`);

--
-- Contraintes pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD CONSTRAINT `forgot_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `like`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`img_id`) REFERENCES `image` (`idimg`);
