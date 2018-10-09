<?php
require_once('../config/connect.php');
session_start();
if (isset($_SESSION['username']))
    
    header('Location: index_log.php');
else
    header('Location: index_delog.php');
?>