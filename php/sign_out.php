<?php 
session_start();
$_SESSION['login'] = "";
session_destroy();
header('Location: connexion.php?status=1');
?>