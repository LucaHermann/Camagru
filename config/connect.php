<?php
date_default_timezone_set('UTC');
require_once('database.php');
try
{
  $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
  die('Erreur : ' . $e->getMessage());
}
?>
