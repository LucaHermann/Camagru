<?php
require_once('../config/connect.php');
session_start();


$success = "Success !";
$fail = "Failure !";


$iduser = $_SESSION["id"];

if (isset($_POST['New_password']) && isset($_POST['Confirm_password']) && isset($_POST['Code'])){
	$verif = $bdd->prepare('SELECT codepw FROM user WHERE id = :id');
	$verif->bindValue(':id', $iduser, PDO::PARAM_INT);
	$verif->execute();
	$datacode = $verif->fetch();
	if ($_POST['New_password'] == $_POST['Confirm_password']){
		if ($_POST['Code'] == $datacode['codepw']){
			try{
				$pw =  hash('whirlpool', $_POST['Confirm_password']);
				$res = $bdd->prepare('UPDATE user SET password = :pw WHERE id = :id');
				$res->bindValue(':pw', $pw, PDO::PARAM_STR);
				$res->bindValue(':id', $iduser, PDO::PARAM_INT);
				$res->execute();
				$test = "ok";
				$message = "Your password has been changed";
			}
			catch (Exception $e)
			{
				$test = "no";
				$message = "Something goes wrong..";
				echo $e->getMessage();
			}
		} else {
			$message = "You have to wite the same code for confirmation";
			$test = "no";
		}
	} else {
		$message = "You have to wite the same password for confirmation";
		$test = "no";
	}
}

if (isset($_POST['New_mail']) && isset($_POST['Confim_mail'])){
	if ($_POST['New_mail'] == $_POST['Confirm_mail']){
		try{
			$res = $bdd->prepare('UPDATE user SET email = :mail WHERE id = :id');
			$res->bindValue(':mail', $_POST['Confirm_mail'], PDO::PARAM_STR);
			$res->bindValue(':id', $iduser, PDO::PARAM_INT);
			$res->execute();
			$test = "ok";
			$message = "Your mail has been changed";
		}
		catch (Exception $e)
		{
			$test = "no";
			$message = "You have to write the same mail for confirmation";
			echo $e->getMessage();
		}
	} else {
		$message = "Something goes wrong..";
		$test = "no";
	}
}
if (isset($_POST['username'])){
	try{
		$un = htmlspecialchars($_POST['username']);
		$res = $bdd->prepare('UPDATE user SET username = :un WHERE id = :id');
		$res->bindValue(':un', $un, PDO::PARAM_STR);
		$res->bindValue(':id', $iduser, PDO::PARAM_INT);
		$res->execute();
		$test = "ok";
		$message = "Your username has been changed";
	}
	catch (Exception $e)
	{
		$test = "no";
		$message = "Something goes wrong..";
		echo $e->getMessage();
	}
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
                <?php echo '<p>'.$message.'</p>'?>
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