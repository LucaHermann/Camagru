<?php
require_once('../config/connect.php');
session_start();
if (isset($_SESSION['username']))
  require_once('index_log.php');
else
  require_once('index_delog.php');
?>