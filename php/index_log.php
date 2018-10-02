<?php
session_start();
require_once('connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/index_log.css"/>
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
				$reponse = $bdd->query('SELECT * FROM image, user WHERE image.id_user = user.id ORDER BY idimg DESC');
				while ($data = $reponse->fetch()){
				echo '
					<div class="insta_post">  
						<div class="header_post">
							<div class="roundedimage">
								<img alt="1" class="pp" src="data:image/jpeg;base64,' .base64_encode($data['img']). '"/>
							</div>
							<div class="header_name">
								<div class="header_name_sd">
									<a class="account_name_header" title="#">'.$data['pseudo'].'</a>
								</div>
							</div>
						</div>
						<div class="post_content">
							<img src="data:image/jpeg;charset:utf-8;base64,' .base64_decode($data['img_path']). '" class="display_picture">
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
								$rep = $bdd->query('SELECT * FROM user, comment, image WHERE comment.user_id = user.id AND comment.img_id = '.$data['idimg'].'');
								$repdata = $rep->fetch();
									echo '	<li class="the_comment">
										<div class="name_aera">
												<a class="name" href="#" title="#">'.$repdata['pseudo'].'</a>
												<span class="quote">'.$repdata['text'].'</span>
										</div>
									</li>';
							echo '</ul>
							</div>
							<section class="writing_area">
								<form class="enter_comment">
									<textarea class="comment_box" aria-label="Add a comment…" placeholder="Add a comment…" autocomplete="off" autocorrect="off"></textarea>
								</form>
						</section>
						</div>
					</div>';
				}
				?>				
			</div>
			<div class="container_content_right">
				<div class="header_other_user">
					<div class="header_alignment">
						<div class="header_pp_other_user">
							<a class="roundedimage_sd">
								<img src="http://placekitten.com/g/20/20" alt="1" class="pp_sd"/>
							</a>
						</div>
						<div class="alignment_name_other_user">
							<div class="name_other_user">
								<a class="account_name_header" title="#">VirgilAbloh</a>
							</div>
						</div>
					</div>
				</div>
				<div class="user">
					<span class="user_name">User</span>
					<a href="#" class="watch_all">Watch all</a>
				</div>
				<div class="position_user">
					<div class="position_user_sd">
						<div class="alignment_user">
							<div class="here_it_is">
								<div class="header_alignment">
									<div class="header_pp_other_user">
										<a class="roundedimage_sd">
											<img src="http://placekitten.com/g/20/20" alt="1" class="pp_sd"/>
										</a>
									</div>
									<div class="alignment_name_other_user">
										<div class="name_other_user">
											<a class="account_name_header" title="#">SupremeNewYork</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr class="for_beauty">
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