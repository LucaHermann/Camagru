<?php
require_once('../config/connect.php');
session_start();


$date = date("Y-m-d");
$trick = "..";


if (isset($_POST['photo'])){
    $data = htmlentities($_POST['photo'], ENT_QUOTES);
    $data = str_replace(" ", "+", $data);
    $tab  = explode(",", $data);
    echo "ca marche presque.";
    $base = $tab[1];
    $decoded = base64_encode($base);
    //file_put_contents($decoded);
}

if (isset($_POST['filter_path']) && isset($_POST['filter_style'])){
    $path = $trick.substr($_POST['filter_path'], -23);
    $style = $_POST['filter_style'];
}
else{
    $path = "";
    $style = "";
}

try {
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO image (img_path, date, id_user, filter_path, filter_style)
    VALUES ('".$decoded."', '".$date."', '".$_SESSION['id']."', '".$path."', '".$style."')";
    $bdd->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
 ?>