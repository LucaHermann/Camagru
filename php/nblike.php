<?php
require_once('../config/connect.php');
session_start();

if (isset($_POST['idimg'])){
  $imgid = $_POST['idimg'];
}

$nblike = $bdd->prepare('SELECT COUNT(id_utilisateur) AS nblike FROM likes WHERE id_image = '.$imgid.'');
$nblike->execute();
$datanb = $nblike->fetch();
  echo '<span id="likedisp">'.$datanb['nblike'].'</span>';

?>