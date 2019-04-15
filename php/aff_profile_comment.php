<?PHP
session_start();
require_once('../config/connect.php');
echo '<ul class="comment_area" >';
if(isset($_POST['idimg'])){
$rep = $bdd->prepare('SELECT DISTINCT id, text, username, idcomment FROM user, comment, image WHERE comment.user_id = user.id AND comment.img_id = :idimg');
  $rep->bindvalue(':idimg', $_POST['idimg'], PDO::PARAM_INT);
  $rep->execute();
  while($repdata = $rep->fetch()){
    echo '	<li class="the_comment">
              <div class="name_aera">
                  <a class="name" href="profile.php?id='.htmlentities($repdata['id']).'" title="#">'.htmlentities($repdata['username']).'</a>
                  <span class="quote">'.htmlentities($repdata['text']).'</span>';
                  if ($_SESSION['id'] == $repdata['id']){
                    echo '<img onclick="deletecom(this)" src="../ressources/trash.png" class="trash_icon" name="'.$repdata['idcomment'].'" alt="'.$_POST['idimg'].'"/> ';
                  }
              echo '</div>
            </li>';}
}
echo "</ul>";
?>