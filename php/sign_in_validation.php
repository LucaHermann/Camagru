<?php 

require_once("../config/is_connected.php");
require_once("../config/connect2.php");

$un = htmlspecialchars($_POST['login']); 
$pw = hash('whirlpool', htmlspecialchars($_POST["password"]));


$req = $bdd->prepare('SELECT COUNT(*) FROM user WHERE username = :un AND password = :pw');
$req->bindValue(':un', $un, PDO::PARAM_STR);
$req->bindValue(':pw', $pw, PDO::PARAM_STR);
$req->execute();
$req = $req->fetch();

if ($req[0] == "1") // L'utilisateur est trouvé, connexion
{
    session_start();
    $_SESSION['username'] = $un;
    header('Location: index_log.php');
}
else // Pas d'utilisateur trouvé, erreur
{
    header('Location: ../config/is_connected.php');
}

?>