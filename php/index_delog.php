<?php
require_once('../config/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/index_delog.css"/>
<script src="../js/comment_delog.js"></script>
<script src="../js/like_delog.js"></script>
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
			<a href="sign_in.php">
									<div class="logo_sign_in"><img src="../ressources/logo_signin.png" width="30px"height="30px"></div>
							</a>
							<a href="sign_up.php">
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
			$reponselike = $bdd->prepare('SELECT * FROM likes WHERE id_utilisateur = :iduser');
			$reponselike->bindvalue(':iduser',  $_SESSION['id'], PDO::PARAM_INT);
			$reponselike->execute();
			$datalike =  $reponselike->fetchAll();
			$j = 0;
			
			while ($data = $reponse->fetch()){
				$i = 0;
				$da = 0;
				while($datalike[$i]){
					if ($datalike[$i]['id_image'] == $data['idimg']){
						$da = 1;
						while($datalike[$i]){
							$i++;
						}
					}
					else{
						$da = 0;
					}
					$i++;
				}
			echo '
				<div class="insta_post">  
					<div class="header_post">
						<div class="roundedimage">
							<img alt="1" class="pp" src="data:image/jpeg;base64,' .base64_decode($data['img']). '"/>
						</div>
						<div class="header_name">
							<div class="header_name_sd">
								<p  class="account_name_header"> '.$data['username'].' </p>
							</div>
						</div>
					</div>
					<div class="post_content">
						<img src="'.$data['img_path'].'" class="display_picture">
					</div>
					<div class="post_buttons_comment">
						<section class="buttons">
							<div class="like_button">';
							if ($da == 1) {
								echo '<img onclick="like_send(this)" alt="1" name="'.$data['idimg'].'" id="like" src="../ressources/logo_liked.png" class="post_button">';
								//break;
							}
							else{
								echo '<img onclick="like_send(this)" alt="2" name="'.$data['idimg'].'" id="like" src="../ressources/logo_like.png" class="post_button">';
							}
							echo '</div>
							<div class="comment_button">
								<img src="../ressources/logo_commentary.png" class="post_button">
							</div>
						</section>
						<section class="like_area">
							<div class="likes" >
							<input type="hidden" id="likesss" value="'.$j.'">';
							$nblike = $bdd->prepare('SELECT COUNT(id_image) AS nblike FROM likes WHERE id_image = :idimg');
							$nblike->bindvalue(':idimg', $data['idimg'], PDO::PARAM_INT);
							$nblike->execute();
							$datanb = $nblike->fetch();
							echo '<span id="likedisp'.$data['idimg'].'">'.$datanb['nblike'].'</span> likes';
							echo '</div>
						</section>
						<div class="comments" id="comment'.$data['idimg'].'">';
							echo '<ul class="comment_area">';
							$rep = $bdd->prepare('SELECT DISTINCT id, text, username FROM user, comment, image WHERE comment.user_id = user.id AND comment.img_id = :idimg');
							$rep->bindvalue(':idimg', $data['idimg'], PDO::PARAM_INT);
							$rep->execute();
							while($repdata = $rep->fetch()){
								echo '	<li class="the_comment">
									<div class="name_aera">
											<a class="name" href="profile.php?id='.$repdata['id'].'" title="#">'.$repdata['username'].'</a>
											<span class="quote">'.$repdata['text'].'</span>
									</div>
								</li>';}
						echo '</ul>
						</div>
						<section class="writing_area">';
							?><form class="enter_comment" onkeypress="if (event.key == 'Enter'){comment_send(this); return false;}" <?PHP echo 'method="POST">
							<input id="comment_index'.$data['idimg'].'" type="text" name="text" class="comment_box" autocomplete="off" autocorrect="off" aria-label="Add a comment…" placeholder="Add a comment…">
							<input type="hidden" id="idimg" name="idimg"  value="'.$data['idimg'].'">
							</form>';
					echo '</section>
					</div>
				</div>';
				$j++;
			}
			?>				
		<div>
	</div>
</div>
<div id="footer">
	<div id="footer_bar">
		<strong> © Mdauphin </strong>
	</div>
</div>
</body>
</html>