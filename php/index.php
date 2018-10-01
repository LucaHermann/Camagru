<?php
session_start();
require_once(“config/connect_db.php”);
if (isset($_SESSION[‘login’]))
 require_once(“index_log.php”);
else
    require_once(“index_delog.php”);
?>