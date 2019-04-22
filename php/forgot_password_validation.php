<?php
require_once("../config/connect.php");
session_start();

function generatePIN($digits = 4){
  $i = 0; //counter
  $pin = ""; //our default pin is blank.
  while($i < $digits){
      //generate a random number between 0 and 9.
      $pin .= mt_rand(0, 9);
      $i++;
  }
  return $pin;
}

$email = $_POST['email'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo("$email is a valid email address<br>");
  } else {
  echo("$email is not a valid email address<br>");
  }
$res = $bdd->prepare('SELECT COUNT(email) AS nb FROM user WHERE email = :email');
$res->bindValue(':email', $email, PDO::PARAM_STR);
$res->execute();
// check if the email was on the bdd 
$email_check_available = $res->fetch();
if ($email_check_available['nb'] != 1){
	echo "L'email " . $email . " n'est pas attibuer a un compte existant<br>";
exit();}
//If I want a 4-digit PIN code.
$pin = generatePIN();
echo $pin, '<br>';

$sujet = 'Password Problem';
$message = '<html>';
$message .= '<head><title> New Password ! </title></head>';
$message .= '<p> Hello</p>, <br> If you not ask for new password ignor this mail ! </p>';
$message .= '<p> also go on http://localhost/Camagru/php/new_password.php for change your password</p>';
$message .= '<p> enter your $pin and the new password </p>';
$message .= '<p> go on Camagru.</p>';
$message .= '</html>';
$headers .= 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
mail($email, $sujet, $message, $headers);
header('Location: sign_in.php');
?>