<?php

require 'database.php';

try {
  $bdd = new PDO($DB_DSN_FIRST, $DB_USER, $DB_PASSWORD);
  $sql = 'CREATE DATABASE IF NOT EXISTS camagru';
  $bdd->exec($sql);
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

try {
  $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $sql = "CREATE TABLE IF NOT EXISTS comment (
    `user_id` int(11) NOT NULL,
    `img_id` int(11) NOT NULL,
    `text` varchar(140) NOT NULL,
    `date` date NOT NULL,
    `idcomment` int(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8
  ";
  $bdd->exec($sql);   // use exec() because no results are returned

  $sql = "CREATE TABLE IF NOT EXISTS `image` (
    `date` date NOT NULL,
    `id_user` int(11) NOT NULL,
    `idimg` int(11) NOT NULL,
    `img_path` varchar(1000) NOT NULL,
    `filter_path` varchar(200) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
  $bdd->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS `likes` (
    `id_image` int(11) NOT NULL,
    `id_utilisateur` int(11) NOT NULL,
    `idlike` int(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
  $bdd->exec($sql);

  $sql = "CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) NOT NULL,
    `email` varchar(50) NOT NULL,
    `fullname` varchar(50) NOT NULL,
    `username` varchar(30) NOT NULL,
    `password` varchar(1000) NOT NULL,
    `img` longblob NOT NULL,
    `codepw` int(6) NOT NULL,
    `NotifEmail` varchar(3) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `comment`
  ADD PRIMARY KEY (`idcomment`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `img_id` (`img_id`)";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `image`
  ADD PRIMARY KEY (`idimg`),
  ADD KEY `id_user` (`id_user`)";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `likes`
  ADD PRIMARY KEY (`idlike`),
  ADD KEY `id_image` (`id_image`),
  ADD KEY `id_utilisateur` (`id_utilisateur`)";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `user`
  ADD PRIMARY KEY (`id`)";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `comment`
  MODIFY `idcomment` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `image`
  MODIFY `idimg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `likes`
  MODIFY `idlike` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`img_id`) REFERENCES `image` (`idimg`)";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
";
  $bdd->exec($sql);

  $sql = "ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `image` (`idimg`);
";
  $bdd->exec($sql);

}
catch (bddException $e) {
  die('Erreur : ' . $e->getMessage());
}

$bdd = null;
?>
