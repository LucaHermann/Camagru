<?php

session_start() or die("Failed to resume session\n");

if (!isset($_SESSION['logged_user'])) {
  require_once('config/setup.php');
  header("Location: php/sign_up.php"); // redirection vers page connexion
}
else
  header("Location: php/index.php"); // redirection vers page webcam

?>