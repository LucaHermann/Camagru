<?php
session_start();
require_once('../config/connect.php');
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
			<div class="container_content_left">
				<div class="insta_post">  
					<div class="post_content">
					<div id="prev" ></div>
						<video id="sourcevid" width='400' autoplay="true"></video>
							<canvas id="cvs" ></canvas>
							<img src="../ressources/logo_name.png" >        
					</div>
				</div>				
			</div>
			<div class="container_content_right">
				<div class="header_other_user">
					<div class="header_alignment">
						<div class="header_pp_other_user">
							<a class="roundedimage_sd">
								<img src="http://placekitten.com/g/30/30" alt="1" class="pp_sd"/>
							</a>
						</div>
						<button onclick='ouvrir_camera()' >ouvrir camera</button>
						<button onclick='photo()' class="logo_take_pic"><img src="../ressources/logo_appareil.png" class="logo_take_pic"></button>
						<button onclick='fermer()' >fermer camera</button>
						<div class="alignment_name_other_user">
							<div class="name_other_user">
								<a class="account_name_header" title="#">Filters</a>
							</div>
						</div>
					</div>
				</div>
				<div class="user">
					<span class="user_name">Choose</span>
				</div>
				<div class="position_user">
					<div class="position_user_sd">
						<div class="alignment_user">
							<div class="here_it_is">
								<div class="header_alignment">
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr class="for_beauty">
				<input id="file" type="file"/>
				<button onclick='env()'>Save uploaded picture</button>
				<div id="jaxa">
					<button onclick='prepare_envoi()'>Save picture !</button>
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