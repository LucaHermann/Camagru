<?php
require_once('../config/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/camagru.css"/>
<link rel="stylesheet" type="text/css" href="../css/sign_up.css"/>
<title>Camagru</title>
</head>
<body>
<div id="container">
			<div id="container_sign_up">
					<div id="formulary">
			<div id="formulary_top_container">
				<div id="formulary_title">
						<img class="logo" src="../ressources/logo_name.png">
				</div>
				<div id="formulary_annoucement">
					<h2 class="annoucement">Sign up to see photos from your friends.</h2>
				</div>
				<div id="formulary_form">
					<form method="post" action="sign_up_validation.php" class="form_design">
							<input type="text" name="email" id="formulary_email" placeholder="Email" autocomplete="email">
							<input type="text" name="fullname" id="formulary_fullname" placeholder="Fullname"  autocomplete="fullname">
							<input type="text" name="username" id="formulary_username" placeholder="Username"  autocomplete="username">
							<input type="password" name="password" id="formulary_password" placeholder="Password"  autocomplete="current-password">
							<input class="button" type="submit" name="register" value="Register"/>
						</form>
				</div>
			</div>
			<div id="formulary_sd"></div>
			<div id="formulary_bot_container">
				<p id="formulary_sign_up_link"> Have an account?<a href="sign_in.php">Sign in </a></p>
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