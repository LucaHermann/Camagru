<?php
    
	require_once('../config/connect.php');
	session_start();

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo("$email is a valid email address<br>");
	} else {
	echo("$email is not a valid email address<br>");
	}
	$email = htmlspecialchars($_POST['email']);
	// send email to the new user for notify her/his account was succesfully created
	$sujet = 'Welcome on Camagru';
	$message = '<html>';
	$message .= '<head><title> Felicitation ! </title></head>';
	$message .= '<p>Bonjour, <br> Felicitation ton compte a bien été crée ! </p>';
	$message .= '<p>Rendez-vous sur Camagru.</p>';
	$message .= '</html>';
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
	mail($email, $sujet, $message, $headers);
	$fn = htmlspecialchars($_POST['fullname']);
	$un = htmlspecialchars($_POST['username']);
	$pw =  $_POST['password'];
	// $img = $_POST['file'];
	// check if the pseudo was available
	$res = $bdd->prepare('SELECT COUNT(username) AS nb FROM user WHERE username = :un');
	$res->bindValue(':un', $un, PDO::PARAM_STR);
	$res->execute();
	$username_check_available = $res->fetch();
	if ($username_check_available['nb'] != 0){
			echo "Le pseudo " . $un . " n'est pas disponible<br>";
	exit();}
	$res = $bdd->prepare('SELECT COUNT(email) AS nb FROM user WHERE email = :email');
	$res->bindValue(':email', $email, PDO::PARAM_STR);
	$res->execute();
	// check if the email was available
	$email_check_available = $res->fetch();
	if ($email_check_available['nb'] != 0){
			echo "L'email " . $email . " n'est pas disponible<br>";
	exit();}
	// check if the pw have the good length
	if (strlen($pw) < 8){
			echo "Le mot de passe est trop court (8 caracteres minimum)<br>";
	exit();}
	if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $pw)){
			echo "Le mot de passe n'est pas assez complexe, il doit contenir au minimum une majuscule, une minuscule et un chiffre.<br>";
	exit();}  
	$pw =  hash('whirlpool', $_POST['password']);
	$res = $bdd->prepare('INSERT INTO  `user` (`email`,  `fullname`, `username`, `password`, `img`) VALUES (:email, :fn, :un , :pw, "")');
	$res->bindValue(':email', $email, PDO::PARAM_STR);
	$res->bindValue(':fn', $fn, PDO::PARAM_STR);
	$res->bindValue(':un', $un, PDO::PARAM_STR);
	$res->bindValue(':pw', $pw, PDO::PARAM_STR);
	$res->execute();
	header('Location: /Camagru/php/sign_in.php');
?>