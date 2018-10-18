<?php
date_default_timezone_set('UTC');
try
{
        $bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'root');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>
