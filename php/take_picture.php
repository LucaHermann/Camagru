<?php
require_once('../config/connect.php');
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/take_picture.css"/>
		<title>Camagru</title>
	</head>
<body>
	<div class="header">
		<div class="position_navbar">
			<div class="header_content_left">
				<a href="take_picture.php">
					<div class="logo_appareil"><img src="../ressources/logo_appareil.png"width="30px"height="30px"></div>
				</a>
				<a href="index.php">
					<div class="logo_camagru"><img src="../ressources/logo_name.png"width="105px"height="35px"style="margin-left:7px"></div>
				</a>
			</div>
			<div class="header_content_right">
				<a href="profile.php">
					<div class="logo_account"><img src="../ressources/logo_account.png"width="30px"height="30px"></div>
				</a>
				<a href="sign_out.php">
          <div class="logo_logout"><img src="../ressources/logo_logout.png" width="30px"height="30px"></div>
        </a>
			</div>
		</div>
	</div>
	<div id="container">
		<div id="layout_picture">
			<div class="container_content_top">
				<div class="container_content_left">
					<div class="insta_post">  
						<div class="post_content">
							<div style="position:absolute;width:100%;height:100%;"><img id="fifi" src=""></div>
							<div id="prev"></div>
							<video id="sourcevid" width='600' autoplay="true" style="display:none;margin-bottom: 15px;margin-top: 15px;"></video>
							<canvas id="cvs" style="display:none;"></canvas>      
						</div> 
					</div>			
				</div>
				<div class="container_content_right">
					<div class="header_other_user">
					<?PHP 
					$repuser = $bdd->prepare('SELECT id, username, img FROM user WHERE id = :idusr');
					$repuser->bindvalue(':idusr', $_SESSION['id'], PDO::PARAM_INT);
					$repuser->execute();
					$datauser = $repuser->fetch();
					echo 
						'<div class="header_alignment">
							<div class="header_pp_other_user">
								<a href="profile.php?id='.$datauser['id'].'" class="roundedimage_sd">
									<img  src="data:image/jpeg;base64,'.base64_decode($datauser['img']).'" alt="1" class="pp_sd"/>
								</a>
							</div>
							<button onclick="ouvrir_camera()" >Open</button>
							<button onclick="photo()" class="logo_take_pic"><img src="../ressources/logo_appareil.png" class="logo_take_pic"></button>
							<button onclick="fermer()" >Close</button>
						</div>';
					?>
					</div>
					<div class="user">
						<span class="user_name">Choose</span>
					</div>
					<div class="position_user">
						<div class="position_user_sd">
							<div class="alignment_user">
								<div class="here_it_is">
									<div class="header_alignment">
										<img onclick="filtre(this)" src="../ressources/test.png" style="width:50px; height:50px; margin-left:30px;" name="margin-top: 166px; margin-left: 10px;" alt="margin-top: 62.5px; width:172px; height:162.5px;">
										<!-- <img onclick="filtre(this)" src="../ressources/test_sd.png" style="width:50px; height:50px; margin-left:30px;" name="margin-top: 50px; margin-left: 200px; width:200px; height:200px;" alt="margin-top: 25px; margin-left: 100px; width:100px; height:100px;">
										<img onclick="filtre(this)" src="../ressources/test_td.png" style="width:50px; height:50px; margin-left:30px;" name="margin-left: 150px; min-width:300px; height:300px;" alt="margin-left: 75px; width:150px; height:150px;"> -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr class="for_beauty">
					<form class="button_up_pic">
						<input id="file" type="file"/>
						<div class="but_pic" id="dispbut">
						<button onclick='env()' id="saveup">Save uploaded picture</button>
						</div>
						<div id="jaxa" class="but_pic">
							<button onclick='prepare_envoi()' id="savecam">Save picture !</button>
						</div>
					</form>
				</div>
			</div>
			<div class="container_content_bot">
				<div class="filter_pic">
					<?PHP 
					$reppicfilter = $bdd->prepare('SELECT * FROM image WHERE filter_path != "" ORDER BY idimg DESC');
					$reppicfilter->execute();
					while($datafilter = $reppicfilter->fetch()){
					echo 
						'<div class="last_post">
							<img  name="a" class="display_picture_filter" src="'.$datafilter['img_path'].'"/>
						</div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="footer_bar">
			<strong> © Mdauphin Lhermann </strong>
		</div>
	</div>
	<script src="../js/take_pic.js"></script>
</body>
</html>