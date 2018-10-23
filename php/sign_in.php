<?php
require_once('../config/connect.php');
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/sign_in.css"/>
<title>Camagru</title>
</head>
<body>
<div id="container">
    <div id="container_sign_in">
        <div id="mockup_iphone">
            <img id="iphone_pic" src="../ressources/mockup/mockup1.png">
        </div>
        <div id="formulary">
          <div id="formulary_td">
            <div id="formulary_title">
              <a href="index_delog.php" style="max-height: 51px;">    
                <img class="logo" src="../ressources/logo_name.png">
              </a>
            </div>
            <div id="formulary_form">
              <form method="post" action="sign_in_validation.php" name="login" action="sign_in.php" class="form_design">
                  <input type="text" name="username" id="formulary_login" placeholder="Username" autocomplete="login">
                  <input type="password" name="password" id="formulary_password" placeholder="Password" autocomplete="current-password">
                  <input class="button" type="submit" value="Log in"/>
              </form>
              <div id="formulary_decoration">OR</div>
              <div class="formulary_forget_password">
                  <a href="forgot_password.php" id="formulary_forget_password_sd">Forgot password?</a>
              </div>
              </div>
              <div id="formulary_fd"></div>
              <div id="formulary_sign_up">
                  <p id="formulary_sign_up_link">Don't have an account?<a href="sign_up.php"> Sign up</a></p>
              </div>
              <div id="formulary_index_delog">
              Go see our galery
                  <a id="fid" href="index.php">just here</a>
            </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
  <div id="footer_bar">
    <strong> © Mdauphin Lhermann </strong>
  </div>
</div>
</body>
</html>