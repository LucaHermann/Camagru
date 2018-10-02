<?php
    
    require_once('../config/connect2.php');
    session_start();
    
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
    $pw =  hash('whirlpool', $_POST['password']);
    $img = $_POST['file'];
    echo "test1";
    // check if the pseudo was available
    $res = $bdd->query('SELECT COUNT(username) AS nb FROM user WHERE username = :un');
    $res->execute(array('username' => $un));
    echo "test2";
    $username_check_available = $res->fetch();
    if ($username_check_available['nb'] != 0){
            echo "Le pseudo " . $un . " n'est pas disponible<br>";
            exit();}
    echo "test3";
    $res = $bdd->query('SELECT COUNT(email) AS nb FROM user WHERE email = :email');
    $res->execute(array('email' => $email));
    echo "test4";
    // check if the email was available
    $email_check_available = $res->fetch();
    if ($email_check_available['nb'] != 0){
            echo "L'email " . $email . " n'est pas disponible<br>";
            exit();}
            echo "test5";
    // check if the pw have the good length
    if (strlen($pw) < 8){
    echo "Le mot de passe est trop court (8 caracteres minimum)<br>";
    exit();}
    echo "test6";
    if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/gm', $pw)){
    echo "Le mot de passe n'est pas assez complexe, il doit contenir au minimum une majuscule, une minuscule et un chiffre.<br>";
    exit();}
    echo "test7";
    $var = $bdd->prepare('INSERT INTO  `user` (`email`,  `fullname`, `username`, `password`) VALUES (:email, :fn, :un , :pw)');
    $var->execute(array('email' => $email, 'fn' => $fn, 'un' => $un, 'pw' => $pw));
    echo "test8";
    header('Location: /Camagru/php/sign_in.php');
?>