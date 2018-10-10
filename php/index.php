<?php
require_once('../config/connect.php');
session_start();
if (isset($_SESSION['username']))
    
    require('index_log.php');
else
    require('index_delog.php');
?>