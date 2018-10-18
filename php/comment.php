<?php
require_once('../config/connect.php');
session_start();

$date = date("Y-m-d");

if (isset($_POST['text']) && isset($_POST['idimg'])){
    $text = $_POST['text'];
    $imgid = $_POST['idimg'];
    $userid = $_SESSION['id'];// recuperation avec session start
}

try {

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $bdd->prepare('INSERT INTO comment (user_id, img_id, text, date)
    VALUES (:iduser, :idimg , :text, :date)');
    $sql->bindvalue(':idimg', $imgid, PDO::PARAM_INT);
    $sql->bindvalue(':iduser', $userid, PDO::PARAM_INT);
    $sql->bindvalue(':text', $text, PDO::PARAM_STR);
    $sql->bindparam(':date', $date);
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