<?php
    
    require_once('../config/connect2.php');
    session_start();
    
    $un = htmlspecialchars($_POST['login']);
    $pw =  hash('whirlpool', $_POST['password']);

    $req = $bdd->prepare("SELECT id, username, password FROM user WHERE username = :un");
    $req->bindValue(':un', $un, PDO::PARAM_STR);
    $req->execute();

    $un_log = $req->fetch(PDO::FETCH_ASSOC);
    if ($un_log === false){
        die('Incorrect username / password combination! 1 ');}
    else{
          $validPassword = password_verify($pw, $un_log['password']);
        if ($validPassword){
            $_SESSION['user_id'] = $un['id'];
            $_SESSION['logged_in'] = time();
            header('Location: index_log.php');
            exit;
        }
        else{
            die('Incorrect username / password combination! 2');}
    }
?>