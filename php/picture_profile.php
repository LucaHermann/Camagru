<?php
require_once('../config/connect2.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/index_delog.css"/>
<title>Camagru</title>
</head>
<body>
<div class="header">
	<div class="position_navbar">
		<div class="header_content_left">
			<div class="logo_appareil"><img src="../ressources/logo_appareil.png" width="30px"height="30px"></div>
			<div class="logo_camagru"><img src="../ressources/logo_name.png" width="105px"height="35px"style="margin-left:7px"></div>
		</div>
		<div class="header_content_right">
			<a href="profile.php">
									<div class="logo_sign_in"><img src="../ressources/logo_signin.png" width="30px"height="30px"></div>
							</a>
							<a href="">
									<div class="logo_sign_up"><img src="../ressources/logo_signup.png" width="30px"height="30px"></div>
							</a>
		</div>
	</div>
</div>
<div id="container">
	<div id="layout_picture">
		<div class="container_content_left">
			<?PHP
			$reponse = $bdd->prepare('SELECT * FROM image, user WHERE image.id_user = user.id ORDER BY idimg DESC');
			$reponse->execute();
			
			while ($data = $reponse->fetch()){
			echo '
				<div class="insta_post">  
					<div class="header_post">
						<a href="profile.php?id='.$data['id'].'" class="roundedimage">
							<img alt="1" class="pp" src="data:image/jpeg;base64,' .base64_encode($data['img']). '"/>
						</a>
						<div class="header_name">
							<div class="header_name_sd">
								<a href="profile.php?id='.$data['id'].'" class="account_name_header" title="#">'.$data['pseudo'].'</a>
							</div>
						</div>
					</div>
					<div class="post_content">
						<img src="data:image/jpeg;base64,' .base64_decode($data['img_path']). '" class="display_picture">
					</div>
					<div class="post_buttons_comment">
						<section class="buttons">
							<div class="like_button">
								<img src="../ressources/logo_like.png" class="post_button">
							</div>
							<div class="comment_button">
								<img src="../ressources/logo_commentary.png" class="post_button">
							</div>
						</section>
						<section class="like_area">
							<div class="likes">
								<span>143</span> likes
							</div>
						</section>
						<div class="comments">
							<ul class="comment_area">';
							$rep = $bdd->prepare('SELECT DISTINCT text, pseudo FROM user, comment, image WHERE comment.user_id = user.id AND comment.img_id = :idimg');
							$rep->bindvalue(':idimg', $data['idimg'], PDO::PARAM_INT);
							$rep->execute();
							while($repdata = $rep->fetch()){
								echo '	<li class="the_comment">
									<div class="name_aera">
											<a class="name" href="#" title="#">'.$repdata['pseudo'].'</a>
											<span class="quote">'.$repdata['text'].'</span>
									</div>
								</li>';}
						echo '</ul>
						</div>
						<section class="writing_area">
							<form class="enter_comment" method="POST" action="comment.php"> 
								<input type="text" name="text" class="comment_box" autocomplete="off" autocorrect="off" aria-label="Add a comment…" placeholder="Add a comment…">
								<input type="hidden"  name="idimg"  value="'.$data['idimg'].'">
							</form>
					</section>
					</div>
				</div>';
			}
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