<?php
require_once('../config/connect.php');
session_start();

function display($message) 
{
	echo '
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/setting.css"/>
		<title>Camagru</title>
	</head>
	<body>
	<div class="header">
		<div class="position_navbar">
			<div class="header_content_left">
				<a href="take_picture.php">
					<div class="logo_appareil">
						<img src="../ressources/logo_appareil.png"width="30px"height="30px">
					</div>
				</a>
				<a href="index.php">
					<div class="logo_camagru">
						<img src="../ressources/logo_name.png"width="105px"height="35px"style="margin-left7px">
					</div>
				</a>
			</div>
			<div class="header_content_right">
				<a href="profile.php">
					<div class="logo_account">
						<img src="../ressources/logo_account.png"width="30px"height="30px">
					</div>
				</a>
				<a href="sign_out.php">
					<div class="logo_logout">
						<img src="../ressources/logo_logout.png" width="30px"height="30px">
					</div>
				</a>
			</div>
		</div>
	</div>
	<div id="container">
		<div class="settings">
			<div class="settings_design">
				<div classe="title">
					<h1>Error</h1>
				</div>
				<div classe="text">
					<p>'.$message.'</p>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="footer_bar">
			<strong> © Mdauphin Lhermann </strong>
		</div>
	</div>
	</body>
	</html>
	';
}

$email = $_POST['email'];
if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
	display("$email is not a valid email address<br>");
}
$email = htmlspecialchars($_POST['email']);
// send email to the new user for notify her/his account was succesfully created
$sujet = 'Welcome on Camagru';
$message = '<html>';
$message .= '<head><title> Felicitation ! </title></head>';
$message .= '<p>Bonjour, <br> Felicitation ton compte a bien été crée ! </p>';
$message .= '<p>Rendez-vous sur Camagru.</p>';
$message .= '</html>';
$headers .= 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
mail($email, $sujet, $message, $headers);
$fn = htmlspecialchars($_POST['fullname']);
$un = htmlspecialchars($_POST['username']);
$pw =  $_POST['password'];
// check if the pseudo was available
$res = $bdd->prepare('SELECT COUNT(username) AS nb FROM user WHERE username = :un');
$res->bindValue(':un', $un, PDO::PARAM_STR);
$res->execute();
$username_check_available = $res->fetch();
if ($username_check_available['nb'] != 0){
		display( "Le pseudo " . $un . " n'est pas disponible<br>");
exit();}
$res = $bdd->prepare('SELECT COUNT(email) AS nb FROM user WHERE email = :email');
$res->bindValue(':email', $email, PDO::PARAM_STR);
$res->execute();
// check if the email was available
$email_check_available = $res->fetch();
if ($email_check_available['nb'] != 0){
		display("L'email " . $email . " n'est pas disponible<br>");
exit();}
// check if the pw have the good length
if (strlen($pw) < 8){
		display("Le mot de passe est trop court (6 caracteres minimum et doit contenir au minimum une majuscule, une minuscule et un chiffre)<br>");
exit();}
if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $pw)){
		display("Le mot de passe n'est pas assez complexe, il doit contenir au minimum une majuscule, une minuscule et un chiffre.<br>");
exit();}
$pw =  hash('whirlpool', $_POST['password']);
$res = $bdd->prepare('INSERT INTO  `user` (`email`,  `fullname`, `username`, `password`, `img`, `codepw`) VALUES (:email, :fn, :un , :pw, "", 0)');
$res->bindValue(':email', $email, PDO::PARAM_STR);
$res->bindValue(':fn', $fn, PDO::PARAM_STR);
$res->bindValue(':un', $un, PDO::PARAM_STR);
$res->bindValue(':pw', $pw, PDO::PARAM_STR);
$res->execute();
header('Location: sign_in.php');
?>