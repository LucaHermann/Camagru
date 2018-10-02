<?php
session_start();
require_once('../config/connect2.php');
if (isset($_SESSION['username']))
    require_once('index_log.php');
else
    require_once('index_delog.php');
?>