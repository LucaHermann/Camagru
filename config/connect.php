<?php
        require_once("database.php");
        try{
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e)
        {
        die('Erreur : ' . $e->getMessage());
        }
        if (isset($_SESSION["login"]))
        {
        $auth = $bdd->query('SELECT * FROM user WHERE username = "'.$_SESSION["username"].'"')->fetch();
        }
?>