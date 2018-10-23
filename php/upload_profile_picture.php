<?php
require_once('../config/connect.php');
session_start();


$date = date("Y-m-d");
$id = $_SESSION['id'];

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
  $sql = "UPDATE user SET img = '".$decoded."' WHERE id = '".$id."'";
  $bdd->exec($sql);
  echo "New record created successfully";
  }
catch(PDOException $e)
  {
  echo $sql . "<br>" . $e->getMessage();
  }
?>