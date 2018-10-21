<?php
require_once('../config/connect.php');
session_start();

$date = date("Y-m-d");

if (isset($_POST['text']) && isset($_POST['idimg'])){
    // $req1 = $bdd->prepare('SELECT id_user FROM image WHERE idimg = :idimg');
    // $req1->bindValue(':idimg', $_POST['idimg'], PDO::PARAM_INT);
    // $req1->execute();
    // $data1[0] = $req1->fetch();
    // $req2 = $bdd->prepare('SELECT email FROM user WHERE id = :iduser');
    // $req2 = $bdd->bindvalue('iduser', $data1[0], PDO::PARAM_INT);
    // $req2->execute();
    // $data2[0] = $req2->fetch();
    $text = $_POST['text'];
    $imgid = $_POST['idimg'];
    $userid = $_SESSION['id'];// recuperation avec session start
    // $email = $data2[0]; 
    // $sujet = 'New Comment';
    // $message = '<html>';
    // $message .= '<head><title> New comment! </title></head>';
    // $message .= '<p>Bonjour, <br> Tu as recu un nouveau commentaire! </p>';
    // $message .= '<p>Rendez-vous sur Camagru.</p>';
    // $message .= '</html>';
    // $headers = 'MIME-Version: 1.0'."\r\n";
    // $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    // $headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
    // mail($email, $sujet, $message, $headers);
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