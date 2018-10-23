<?php
session_start();
require_once('../config/connect.php');


$date = date("Y-m-d");


if (isset($_POST['photo'])){
  $data = htmlentities($_POST['photo'], ENT_QUOTES);
  $data = str_replace(" ", "+", $data);
  $tab  = explode(",", $data);
  echo "ca marche presque.";
  $base = $tab[1];
  $decoded = base64_encode($base);
  //file_put_contents($decoded);
}   

try {
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO image (img_path, date, id_user)
  VALUES ('".$decoded."', '".$date."','".$_SESSION['id']."')";
  $bdd->exec($sql);
  echo "New record created successfully";
  }
catch(PDOException $e)
  {
  echo $sql . "<br>" . $e->getMessage();
  }
?>