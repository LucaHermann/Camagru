<?php
require_once('../config/connect.php');
session_start();

$iduser = $_SESSION["id"];
$reponse = $bdd->prepare('SELECT * FROM user WHERE id = :idasked');
$reponse->bindvalue(':idasked', $iduser, PDO::PARAM_INT);
$reponse->execute();
$data = $reponse->fetch();

$code = rand(100000, 999999);

$email = $data['email'];
$sujet = 'Change Password';
$message = '<html>';
$message .= '<head><title> Change Password! </title></head>';
$message .= '<p>Bonjour, <br> code for change password: '.$code.' </p>';
$message .= '<p>Rendez-vous sur Camagru.</p>';
$message .= '</html>';
$headers .= 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
$headers .= 'From: "Camagru"<nepasrepondre@camagru.fr>'."\n";
mail($email, $sujet, $message, $headers);

try {
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $bdd->prepare('UPDATE  user  SET codepw = :code WHERE id = :iduser');
	$sql->bindvalue(':code', $code, PDO::PARAM_INT);
	$sql->bindvalue(':iduser', $iduser, PDO::PARAM_INT);
	$sql->execute();
	//header('Location: index_log.php');
	//exit();
  }
  catch(PDOException $e)
  {
	var_dump($e->getMessage());
  }
  

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
                <h1>Change password</h1>
            </div>
            <div classe="text">
                <p>You will receive an email with a code for change your password</p>
            </div>
			<form method="post" action="setting_validation.php" class="form">
				<div class="align_form">
					<label for="New_password" class="label_design">New password </label>
					<input type="password" name="New_password" id="New_password" class="input_design"/><br />
				</div>
				<div class="align_form">
					<label for="Confirm_password" class="label_design">Confirm password </label>
					<input type="password" name="Confirm_password" id="Confirm_password" class="input_design" required/><br />
				</div>
				<div class="align_form">
					<label for="code" class="label_design">Code</label>
					<input type="text" name="Code" id="Code" class="input_design" required/><br />
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