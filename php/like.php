<?php
require_once('../config/connect.php');
session_start();

if (isset($_POST['idimg'])){
  $imgid = $_POST['idimg'];
  $userid = $_SESSION['id'];// recuperation avec session start
}

try {

  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = $bdd->prepare('INSERT INTO likes (id_image, id_utilisateur)
  VALUES (:idimg ,:iduser)');
  $sql->bindparam(':idimg', $imgid, PDO::PARAM_INT);
  $sql->bindparam(':iduser', $userid, PDO::PARAM_INT);
  $sql->execute();
  echo "New record created successfully";
  //header('Location: index_log.php');
  //exit();
  }
catch(PDOException $e)
  {
  var_dump($e->getMessage());
  }

?>