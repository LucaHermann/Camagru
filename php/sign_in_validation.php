<?php 

//require_once("../config/is_connected.php");
require_once("../config/connect.php");

$un = htmlspecialchars($_POST['username']); 
$pw = hash('whirlpool', htmlspecialchars($_POST["password"]));


$req = $bdd->prepare('SELECT id, username FROM user WHERE username = :un AND password = :pw');
$req->bindValue(':un', $un, PDO::PARAM_STR);
$req->bindValue(':pw', $pw, PDO::PARAM_STR);
$req->execute();
$user = $req->fetch();

$rep = $bdd->prepare('SELECT id FROM user WHERE username = :un AND password = :pw');
$rep->bindValue(':un', $un, PDO::PARAM_STR);
$rep->bindValue(':pw', $pw, PDO::PARAM_STR);
$rep->execute();
$rep = $rep->fetch();


if ($user) // L'utilisateur est trouvé, connexion
{
    session_start();
    $_SESSION['username'] = $un;
    $_SESSION['id'] = $rep[0];
    header('Location: index.php');
}
else // Pas d'utilisateur trouvé, erreur
{
    header('Location: sign_in.php');
}
?>