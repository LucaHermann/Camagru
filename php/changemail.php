<?php
require_once('../config/connect.php');
session_start();

$iduser = $_SESSION["id"];

$reponse = $bdd->prepare('SELECT * FROM user WHERE id = :idasked');
$reponse->bindvalue(':idasked', $iduser, PDO::PARAM_INT);
$reponse->execute();
$data = $reponse->fetch()
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/setting.css"/>
	<title>Camagru</title>
</head>
<body>
<div class="header">
	<div class="position_navbar">
		<div class="header_content_left">
			<a href="take_picture.php">
				<div class="logo_appareil">
					<img src="../ressources/logo_appareil.png"width="30px"height="30px">
				</div>
							</a>
							<a href="index.php">
									<div class="logo_camagru">
					<img src="../ressources/logo_name.png"width="105px"height="35px"style="margin-left7px">
				</div>
							</a>
		</div>
		<div class="header_content_right">
			<a href="profile.php">
				<div class="logo_account">
					<img src="../ressources/logo_account.png"width="30px"height="30px">
				</div>
			</a>
			<a href="sign_out.php">
									<div class="logo_logout">
					<img src="../ressources/logo_logout.png" width="30px"height="30px">
				</div>
							</a>
		</div>
	</div>
</div>
<div id="container">
	<div class="settings">
		<div class="settings_design">
            <div classe="title">
                <h1>Change mail</h1>
            </div>
            <div classe="text">
                <p>You can change your email adress here</p>
            </div>
			<form method="post" action="setting_validation.php" class="form">
				<div class="align_form">
					<label for="New_mail" class="label_design">New mail </label>
					<input type="text" name="New_mail" id="New_mail" class="input_design"  placeholder="New mail"/><br />
				</div>
				<div class="align_form">
					<label for="Confirm_mail" class="label_design">Confirm mail </label>
					<input type="text" name="Confirm_mail" id="Confirm_mail" class="input_design" placeholder="Confirm mail" required/><br />
                </div>
                <div class="submit_bouton">
					<input type="submit"  class="submit_butt" value="Send"/><br />
				</div>
			</form>
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