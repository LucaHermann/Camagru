<?php
require_once('../config/connect.php');
$req1 = $bdd->prepare('SELECT id_user FROM image WHERE idimg = :idimg');
    $req1->bindValue(':idimg', $_POST['idimg'], PDO::PARAM_INT);
    $req1->execute();
    $data1[0] = $req1->fetch();
    echo 'req1ok<br>';
    $req2 = $bdd->prepare('SELECT email FROM user WHERE id = :iduser');
    echo '1<br>';
    $req2 = $bdd->bindvalue('iduser', $data2[0], PDO::PARAM_INT);
    echo '2<br>';
    $req2->execute();
    echo '3<br>';
    $data2[0] = $req2->fetch();
    echo 'req2 ok';
    $email = $data2[0]; 
    $sujet = 'New Comment';
    $message = '<html>';
    $message .= '<head><title> New comment! </title></head>';
    $message .= '<p>Bonjour, <br> Tu as recu un nouveau commentaire! </p>';
    $message .= '<p>Rendez-vous sur Camagru.</p>';
    $message .= '</html>';
    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
    mail($email, $sujet, $message, $headers);
?>