<?php
require_once('../config/connect.php');
session_start();



if(isset($_GET['id']))
{
	if ($_GET['id'] == $_SESSION['id'])
	{
		$uppic = "block";
	}
	else
	{
		$uppic = "none";
	}
	$idasked = $_GET['id'];
}
else{
	$idasked = $_SESSION['id'];
	$uppic = "block";
}

$reponse = $bdd->prepare('SELECT * FROM user WHERE id = :idasked');
$reponse->bindvalue(':idasked', $idasked, PDO::PARAM_INT);
$reponse->execute();
while ($data = $reponse->fetch())
{
?>
<html>
<div id="overlay" >
	<div class="off" onclick="off()">
	</div>
	<div class="aff_img_profile">
		<div class="content_img_profile">
			<article class="content_img_profile_sd">
					<div class="header_other_user">
						<?PHP 
						$repuser = $bdd->prepare("SELECT id, username, img FROM user WHERE id = :idasked");
						$repuser->bindvalue(':idasked', $idasked, PDO::PARAM_INT);
						$repuser->execute();
						$datauser = $repuser->fetch();
						echo 
							'<div class="header_alignment">
								<div class="header_pp_other_user">
									<a href="profile.php?id='.$datauser['id'].'" class="roundedimage_sd">
										<img  src="data:image/jpeg;base64,'.base64_decode($datauser['img']).'" alt="1" class="pp_sd"/>
									</a>
								</div>
								<div class="alignment_name_other_user">
									<div class="name_other_user">
										<a href="profile.php?id='.$datauser['id'].'" class="account_name_header" title="#">'.$datauser['username'].'</a>
									</div>
								</div>
							</div>';
						?>
					</div>
					<div class="img_overlay">
							<div class="pos_article">
								<div class="pos_article_sd" id="img_over">
									<div style="position:absolute;z-index:1;" class="dislay_pic" ><img id="fifioverlay" src="" style="" ></div>
								</div>						
							</div>
					</div>
					<div class="comment_profil_area">
						<section class="buttons">
							<div class="like_button" id="like_button">
							</div>
							<div class="comment_button">
								<img src="../ressources/logo_commentary.png" class="post_button">
							</div>
							<?php
								if ($uppic == "block"){
									echo'	<div class="trash_button">
												<img onclick="deleteimg(this)" id="trash" src="../ressources/trash.png" class="trash_icon_sd" name=""/>
											</div>';
								}
							?>
					</section>
						<section class="like_area">
							<div class="likes">
							<?PHP echo '<span id="likedisp"></span> likes';?>
							</div>
						</section>
						<section class="writing_area">
							<form class="enter_comment" name="com" method="POST"> 
								<input id="comment" onkeypress="if (event.key == 'Enter'){comment_send(); return false;}" type="text" name="text" class="comment_box" autocomplete="off" autocorrect="off" aria-label="Add a comment…" placeholder="Add a comment…">
								<input type="hidden"  id="idimg" >
							</form>
					</section>
						<div class="comments"  id="comment_profile">
						</div>
					</div>
			</article>
		</div>
	</div> 
</div>
<?php echo '<div style="display:'.$uppic.';">';?>
<div id="overlay_sd" onclick="off_sd()">
	<div id="prev" style="display:none;">
	</div>
	<div class="add_img_profile">
		<div class="content_upload">
			<div class="title_upload">
				<h3 classe="title">Change Profile Photo</h3>
			</div>
			<div class="div_button">
				<!-- <button id="files" type="file" class="up_button"> Upload Photo</button> -->
				<form enctype="multipart/form-data" style="border-top: 1px solid #efefef;    margin-bottom: 0;">
					<label for="file" class="up_button">Upload Photo</label>
					<input id="file" type="file" style="display:none;"/>
				</form>
				<button class="up_button_cancel">Cancel</button>
			</div>

		</div>
	</div>
</div>
<div id="overlay_td" onclick="off_td()">
	<div class="add_img_profile">
		<div class="content_upload">
			<div class="title_upload">
				<h3 classe="title">Settings</h3>
			</div>
			<div class="div_button">
				<a href="changepassword.php" style="text-decoration: none; color: black;">	
					<div class="settings_choice">
						<p>Change password</p>					
					</div>
				</a>
				<a href="changeusername.php" style="text-decoration: none; color: black;">
					<div class="settings_choice">
						<p>Change username</p>
					</div>
				</a>
				<a href="changemail.php" style="text-decoration: none; color: black;">
					<div class="settings_choice">
						<p>Change mail adress</p>
					</div>
				</a>
				<button class="up_button_cancel">Cancel</button>
			</div>

		</div>
	</div>
</div>
<!-- CSS A REGLER -->
</div>
<head>
	<link rel="stylesheet" type="text/css" href="../css/profile.css"/>
	<script src="../js/profile.js"></script>
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
		<?php
			if ($uppic == "none"){
				echo '<a href="profile.php">
						<div class="logo_account"><img src="../ressources/logo_account.png"width="30px"height="30px"></div>
					  </a>';
			} else {
				echo '<div onclick="on_td()" class="logo_setting"><img src="../ressources/logo_setting.png"width="30px"height="30px"></div>';
			}
			?>
			<a href="sign_out.php">
				<div class="logo_logout"><img src="../ressources/logo_logout.png" width="30px"height="30px"></div>
			</a>
		</div>
	</div>
</div>
<div id="container">
	<div class="layout_profile">
		<div id="header_profile">
			<div class="header_profile_picture">
				<div onclick="on_sd()" class="header_profile_picture_sd">
					<?php
						echo '<img class="roundimage" src="data:image/jpeg;base64,' .base64_decode($data['img']). '"/>';
					?>
				</div>
				</div>
			</div>
			<div class="layout_profile_info">
				<div class="header_profile_name">
					<h1><?php echo $data['username'];?></h1>
				</div>
				<ul class="header_profile_info">
					<li class="info_post">
					<?php
					$reponse->closeCursor();
					$reponse = $bdd->prepare("SELECT COUNT(idimg) AS nbpost FROM image WHERE id_user = '.$idasked.'");
					$reponse->execute();
					$data = $reponse->fetch();
					$reponse->closeCursor();
					?>
						<span><?PHP echo ''.$data['nbpost']. ' posts' ?></span>
					</li>			
				</ul>
			</div>
		</div>
		<?php 
		}
		$reponse = $bdd->prepare("SELECT * FROM image WHERE id_user = ".$idasked." ORDER BY idimg DESC"); //risque injection
		$reponse->execute();
		?>
		<div id="container_profile_picture">
				<?php
				$j = 0;					
				while ($data = $reponse->fetchAll())
				{
					$nbdata = count($data);
					while ($j <= $nbdata)
					{
						echo '<div class="profile_row_picture">';
						$i = 0;
						while ($i <= 2)
						{
							if ($j == $nbdata)
								break;
							echo ' <div id="prof"  class="profile_picture">
										<img onclick="on(this)" name="'.$uppic.'" class="dislay_pic" id="'.$data[$j]['idimg'].'" value="'.$j.'" src="'.$data[$j]['img_path'].'"/>						      
									</div>';
							$j++;
							$i++;
							if ($j == $nbdata){
								if($i == 1){
										echo ' <div id="prof"  class="profile_picture">
													<div class="dislay_pic" style="background-color: rgba(250, 250, 250, 1);"></div>						      
												</div>';
										echo ' <div id="prof"  class="profile_picture">
											<div class="dislay_pic" style="background-color: rgba(250, 250, 250, 1);"></div>						      
										</div>';
								}
							}
							if ($j == $nbdata){
								if($i == 2){
										echo ' <div id="prof"  class="profile_picture">
													<div class="dislay_pic" style="background-color: rgba(250, 250, 250, 1);"></div>						      
												</div>';
								}
							}
							}
							echo '</div>';
						if ($j == $nbdata){
								break;
						}
					}	
				}
				$reponse->closeCursor();
				?>
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