<?php
session_start();
require_once('../config/connect.php');

$idasked = $_GET['id'];

$reponse = $bdd->prepare('SELECT * FROM user WHERE id = '.$idasked.'');
//$reponse = $bdd->bindValue('id', $idasked, PDO::PARAM_INT);
$reponse->execute();
while ($data = $reponse->fetch())
{
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/profile.css"/>
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
				<a href="setting.php">
					<div class="logo_setting"><img src="../ressources/logo_setting.png"width="30px"height="30px"></div>
				</a>
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
					<div class="header_profile_picture_sd">
							<?php
								echo '<img class="roundimage" src="data:image/jpeg;base64,' .base64_encode($data['img']). '"/>';
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
			$reponse = $bdd->prepare("SELECT * FROM image WHERE id_user = ".$idasked." ORDER BY idimg DESC");
			$reponse->execute();
			?>
			<div id="container_profile_picture">
				<div class="profile_picture_base">
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
								echo '<div class="profile_picture">
										<img class="dislay_pic" src="data:image/jpeg;charset:utf-8;base64,' .base64_decode($data[$j]['img_path']). '" width="293px" height="293px"/>
									 </div>';
								$j++;
								$i++;
							}
							echo '</div>';
							if ($j == $nbdata)
									break;
						}
						
					}
					$reponse->closeCursor();
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
</body>
</html>