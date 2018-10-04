<?php
require_once('../config/connect2.php');

$date = date("Y-m-d");


if (isset($_POST['photo'])){
    $data = htmlentities($_POST['photo'], ENT_QUOTES);
    $data = str_replace(" ", "+", $data);
    $tab  = explode(",", $data);
    echo "ca marche presque.";
    $base = $tab[1];
    $decoded = base64_encode($base);
    //file_put_contents($decoded);
}   

try {
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO image (img_path, date, id_user)
    VALUES ('".$decoded."', '".$date."', 3)";
    $bdd->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
 ?>
<!-- <!DOCTYPE html>
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
				<a href="index_log.php"> <!-- a changer en index.php quand bdd faite 
					<div class="logo_camagru"><img src="../ressources/logo_name.png"width="105px"height="35px"style="margin-left:7px"></div>
				</a>
			</div>
			<div class="header_content_right">
				<a href="profile.php">
					<div class="logo_account"><img src="../ressources/logo_account.png"width="30px"height="30px"></div>
				</a>
				<a href="">
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


//  if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
    //  echo "lol1";
    //  if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;
    //  echo "lol2";
    //  $ext = strtolower(substr(strrchr($_FILES[$index]['name'],'.'),1));
    //  if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;
    //  print_r($_FILES['pic']);
    //  $image = file_get_contents($_FILES['pic']['tmp_name']);
    //  if (isset($image)){
    //     $data = htmlentities($image, ENT_QUOTES);
    //     $data = str_replace(" ", "+", $image);
    //     $tab  = explode(",", $data);
    //     $base = $tab[1];
    //     $decoded = base64_encode($image);
    //     //file_put_contents($decoded);
    // }
    </html> -->