<?php
require_once('../config/connect.php');
session_start();

$date = date("Y-m-d");

if (isset($_POST['text']) && isset($_POST['idimg'])){
  $id_img = $_POST['idimg'];
  $req1 = $bdd->prepare('SELECT id_user FROM image WHERE idimg = :idimg');
  $req1->execute(array('idimg' => $id_img));

  if ($test = $req1->fetch())
  {
    $id_user = $test['id_user'];
  }
  $req2 = $bdd->prepare('SELECT email FROM user WHERE id = :iduser');
  $req2->execute(array('iduser' => $id_user));    
  if ($test2 = $req2->fetch())
  {
    $email = $test2['email'];
  }
  $text = $_POST['text'];
  $antixss = $text;
  $antixss = strip_tags($antixss);
  $new_text = htmlspecialchars($antixss, ENT_NOQUOTES);
  $text = $new_text;
  $imgid = $_POST['idimg'];
  $userid = $_SESSION['id'];// recuperation avec session start
  $email = $email;
  $sujet = 'New Comment';
  $message = '<html>';
  $message .= '<head><title> New comment! </title></head>';
  $message .= '<p>Bonjour, <br> Tu as recu un nouveau commentaire! </p>';
  $message .= '<p>Rendez-vous sur Camagru.</p>';
  $message .= '</html>';
  $headers .= 'MIME-Version: 1.0'."\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
  $headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
  mail($email, $sujet, $message, $headers);

  try {
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = $bdd->prepare('INSERT INTO comment (user_id, img_id, text, date)
    VALUES (:iduser, :idimg , :text, :date)');
    $sql->bindvalue(':idimg', $imgid, PDO::PARAM_INT);
    $sql->bindvalue(':iduser', $userid, PDO::PARAM_INT);
    $sql->bindvalue(':text', $text, PDO::PARAM_STR);
    $sql->bindparam(':date', $date);
    $sql->execute();
  }
  catch(PDOException $e)
  {
    var_dump($e->getMessage());
  }
}

if (isset($_POST['idcom'])){
  $idcomment = $_POST['idcom'];
  try {
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = $bdd->prepare('DELETE FROM comment WHERE idcomment = :idcomment');
  $sql->bindvalue(':idcomment', $idcomment, PDO::PARAM_INT);
  $sql->execute();
}
catch(PDOException $e)
{
  var_dump($e->getMessage());
}
}


?>