<?PHP
echo '<ul class="comment_area" >';
require_once('../config/connect.php');
if(isset($_POST['idimg'])){
  $rep = $bdd->prepare('SELECT DISTINCT text, username FROM user, comment, image WHERE comment.user_id = user.id AND comment.img_id = :idimg');
    $rep->bindvalue(':idimg', $_POST['idimg'], PDO::PARAM_INT);
    $rep->execute();
    while($repdata = $rep->fetch()){
        echo '	<li class="the_comment">
                <div class="name_aera">
                  <a class="name" href="#" title="#">'.$repdata['username'].'</a>
                  <span class="quote">'.htmltspecialchars($repdata['text']).'</span>
                </div>
                </li>';
            }
}
echo "</ul>";
?>