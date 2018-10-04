<?php
require_once('../config/connect2.php');

$date = date("Y-m-d");

if (isset($_POST['text']) && isset($_POST['idimg'])){
    $text = $_POST['text'];
    $imgid = $_POST['idimg'];
    $userid = 1; // recuperation avec session start
}

try {
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $bdd->prepare('INSERT INTO comment (img_id, user_id, text, date)
    VALUES (:idimg , :iduser, :text, :date)');
    $sql->bindvalue(':idimg', $imgid, PDO::PARAM_INT);
    $sql->bindvalue(':iduser', $userid, PDO::PARAM_INT);
    $sql->bindvalue(':text', $text, PDO::PARAM_STR);
    $sql->bindvalue(':date', $date, PDO::PARAM_INT);
    $sql->execute();
    echo "New record created successfully";
    //header('Location: index_log.php');
    //exit();
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

 ?>