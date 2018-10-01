<?php
date_default_timezone_set('UTC');
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', '41500');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>