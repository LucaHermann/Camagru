<?php
require_once('../config/connect.php');
session_start();

if (isset($_POST['idimg'])){
  $imgid = $_POST['idimg'];
}

$reponselike = $bdd->prepare('SELECT * FROM likes WHERE id_utilisateur = :iduser');
$reponselike->bindvalue(':iduser',  $_SESSION['id'], PDO::PARAM_INT);
$reponselike->execute();
$datalike =  $reponselike->fetchAll();
$i = 0;
$da = 0;
while($datalike[$i]){
  if ($datalike[$i]['id_image'] == $imgid){
      $da = 1;
      while($datalike[$i]){
          $i++;
      }
  }
  else{
      // echo $datalike[$i]['id_image'];
      // echo $data['idimg'];
      $da = 0;
  }
  $i++;
}

if ($da == 1) {
  echo '<img onclick="like_send(this)" alt="1" name="'.$idimg.'" id="like" src="../ressources/logo_liked.png" class="post_button">';
  //break;
}
else{
  echo '<img onclick="like_send(this)" alt="2" name="'.$idimg.'" id="like" src="../ressources/logo_like.png" class="post_button">';
}

?>