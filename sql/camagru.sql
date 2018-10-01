
SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET time_zone
= "+00:00";
--
-- Base de données :  `camagru`
--
-- --------------------------------------------------------
--
-- Structure de la table `comment`
--
CREATE TABLE `comment`
(
  `img_id` int
(11) NOT NULL,
  `user_id` int
(11) NOT NULL,
  `text` varchar
(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Structure de la table `forgot_password`
--
CREATE TABLE `forgot_password`
(
  `usr_id` int
(11) NOT NULL,
  `password` int
(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Structure de la table `image`
--
CREATE TABLE `image`
(
  `id` int
(11) NOT NULL,
  `img_path` blob NOT NULL,
  `date` date NOT NULL,
  `user_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Structure de la table `like`
--
CREATE TABLE `like`
(
  `img_id` int
(11) NOT NULL,
  `us_id` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Structure de la table `user`
--
CREATE TABLE `user`
(
  `id` int
(11) NOT NULL,
  `email` varchar
(50) NOT NULL,
  `email_confirmation` varchar
(50) NOT NULL,
  `pseudo` varchar
(20) NOT NULL,
  `password` varchar
(100) NOT NULL,
  `img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Index pour les tables déchargées
--
--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
ADD UNIQUE KEY `img_id`
(`img_id`),
ADD UNIQUE KEY `user_id`
(`user_id`);
--
-- Index pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
ADD UNIQUE KEY `usr_id`
(`usr_id`);
--
-- Index pour la table `image`
--
ALTER TABLE `image`
ADD PRIMARY KEY
(`id`),
ADD UNIQUE KEY `foreign_key`
(`user_id`);
--
-- Index pour la table `like`
--
ALTER TABLE `like`
ADD UNIQUE KEY `img_ig`
(`img_id`),
ADD UNIQUE KEY `us_id`
(`us_id`);
--
-- Index pour la table `user`
--
ALTER TABLE `user`
ADD PRIMARY KEY
(`id`);
--
-- AUTO_INCREMENT pour les tables déchargées
--
--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int
(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables déchargées
--
--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY
(`user_id`) REFERENCES `user`
(`id`),
ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY
(`img_id`) REFERENCES `image`
(`id`);
--
-- Contraintes pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
ADD CONSTRAINT `forgot_password_ibfk_1` FOREIGN KEY
(`usr_id`) REFERENCES `user`
(`id`);
--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY
(`user_id`) REFERENCES `user`
(`id`);
--
-- Contraintes pour la table `like`
--
ALTER TABLE `like`
ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY
(`img_id`) REFERENCES `image`
(`id`),
ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY
(`us_id`) REFERENCES `user`
(`id`);