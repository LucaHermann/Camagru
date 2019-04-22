<?php
require_once('../config/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/index_log.css"/>
	<script src="../js/comment.js"></script>
	<script src="../js/like.js"></script>
	<title>Camagru</title>
</head>
<body>
<div class="header">
	<div class="position_navbar">
		<div class="header_content_left">
			<a href="take_picture.php">
				<div class="logo_appareil"><img src="../ressources/logo_appareil.png" width="30px"height="30px"></div>
			</a>
			<div class="logo_camagru"><img src="../ressources/logo_name.png" width="105px"height="35px"style="margin-left:7px"></div>
		</div>
		<div class="header_content_right">
			<a href="profile.php">
									<div class="logo_profile"><img src="../ressources/logo_account.png" width="30px"height="30px"></div>
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
						// echo $datalike[$i]['id_image'];
						// echo $data['idimg'];
						$da = 0;
					}
					$i++;
				}
				//echo $da;
			echo '
				<div class="insta_post">  
					<div class="header_post">
						<a href="profile.php?id='.$data['id'].'" class="roundedimage">
							<img alt="1" class="pp" src="data:image/jpeg;base64,' .base64_decode($data['img']). '"/>
						</a>
						<div class="header_name">
							<div class="header_name_sd">
								<a href="profile.php?id='.$data['id'].'" class="account_name_header" title="#">'.$data['username'].'</a>
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
							$nblike = $bdd->prepare('SELECT COUNT(id_image) AS nblike FROM likes WHERE id_image = '.$data['idimg'].'');
							$nblike->execute();
							$datanb = $nblike->fetch();
							echo '<span id="likedisp'.$data['idimg'].'">'.$datanb['nblike'].'</span> likes';
							echo '</div>
						</section>
						<div class="comments" id="comment'.$data['idimg'].'">';
							echo '<ul class="comment_area">';
							$rep = $bdd->prepare('SELECT DISTINCT id, text, username, idcomment FROM user, comment, image WHERE comment.user_id = user.id AND comment.img_id = :idimg');
							$rep->bindvalue(':idimg', $data['idimg'], PDO::PARAM_INT);
							$rep->execute();
							while($repdata = $rep->fetch()){
								echo '	<li class="the_comment" id="com'.$repdata['idcomment'].'">
									<div class="name_aera">
											<a class="name" href="profile.php?id='.$repdata['id'].'" title="#">'.$repdata['username'].'</a>
											<span class="quote">'.$repdata['text'].'</span>';
											if ($_SESSION['id'] == $repdata['id']){
												echo '<img onclick="deletecom(this)" src="../ressources/trash.png" class="trash_icon" name="'.$repdata['idcomment'].'" alt="'.$data['idimg'].'"/> ';
											}
									echo '</div>
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
					<div class="alignment_name_other_user">
						<div class="name_other_user">
							<a href="profile.php?id='.$_SESSION['id'].'" class="account_name_header" title="#">'.$datauser['username'].'</a>
						</div>
					</div>
				</div>';
			?>
			</div>
			<div class="user">
				<span class="user_name">User</span>
				<a href="#" class="watch_all">Watch all</a>
			</div>
			<div class="position_user">
				<div class="position_user_sd">
					<div class="alignment_user">
					<?PHP
					$repotheruser = $bdd->prepare('SELECT id, username, img FROM user WHERE id != :idusr');
					$repotheruser->bindvalue(':idusr', $_SESSION['id'], PDO::PARAM_INT);
					$repotheruser->execute();
					while($dataotheruser = $repotheruser->fetch()){
						echo '
						<div class="here_it_is">
							<div class="header_alignment">
								<div class="header_pp_other_user" >
									<a href="profile.php?id='.$dataotheruser['id'].'" class="roundedimage_sd">
										<img src="data:image/jpeg;base64,'.base64_decode($dataotheruser['img']).'" alt="1" class="pp_sd"/>
									</a>
								</div>
								<div class="alignment_name_other_user">
									<div class="name_other_user">
										<a href="profile.php?id='.$dataotheruser['id'].'" class="account_name_header" title="#">'.$dataotheruser['username'].'</a>
									</div>
								</div>
							</div>
						</div>';
					}?>
					</div>
				</div>
			</div>
			<hr class="for_beauty">
		</div>
	</div>
</div>
<div id="footer">
	<div id="footer_bar">
		<strong> © Mdauphin </strong>
	</div>
</div>
</body>
</html>