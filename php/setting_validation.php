<?php
require_once('../config/connect.php');
session_start();


$success = "Success !";
$fail = "Failure !";


$iduser = $_SESSION["id"];
$reponse = $bdd->prepare('SELECT * FROM user WHERE id = :idasked');
$reponse->bindvalue(':idasked', $iduser, PDO::PARAM_INT);
$reponse->execute();
$data = $reponse->fetch();

if (isset($_POST['New_password']) && isset($_POST['Confim_password'])){
	if ($_POST['New_password'] == $_POST['Confim_password']){
		try{
			$pw =  hash('whirlpool', $_POST['Confirm_password']);
			$res = $bdd->prepare('UPDATE user SET password = :pw WHERE id = :id');
			$res->bindValue(':pw', $pw, PDO::PARAM_STR);
			$res->bindValue(':id', $iduser, PDO::PARAM_INT);
			$res->execute();
			$test = "ok";
		}
		catch (Exception $e)
		{
			$test = "no";
			echo $e->getMessage();
		}
	} else {
		$test = "no";
	}
}

if (isset($_POST['New_mail']) && isset($_POST['Confim_mail'])){

}
if (isset($_POST['username'])){

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
				<?php
					if ($test = "ok"){
						echo '<h1>"'.$success.'"</h1>';
					} else {
						echo '<h1>"'.$fail.'"</h1>';
					}
				?>
            </div>
            <div classe="text">
                <p>You will receive an email with a code for change your password</p>
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