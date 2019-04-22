
<?php
require_once('../config/connect.php');
session_start();

if (isset($_POST['idimg'])){
  $idimage = $_POST['idimg'];
  try {
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = $bdd->prepare('DELETE FROM `comment` WHERE `img_id` = :idimg');
  $sql->bindvalue(':idimg', $idimage, PDO::PARAM_INT);
  $sql->execute();

  $sql = $bdd->prepare('DELETE FROM `likes` WHERE `id_image` = :idimg');
  $sql->bindvalue(':idimg', $idimage, PDO::PARAM_INT);
  $sql->execute();

  $sql = $bdd->prepare('DELETE FROM `image` WHERE `idimg` = :idimg');
  $sql->bindvalue(':idimg', $idimage, PDO::PARAM_INT);
  $sql->execute();
}
catch(PDOException $e)
{
  var_dump($e->getMessage());
}
}
?>