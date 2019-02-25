<?php
require_once('../config/connect.php');
session_start();

$date_name = date("H-i__d:m:Y");
$date = date("Y-m-d");
$trick = "../ressources/";


if (isset($_POST['photo'])){
  $data = htmlentities($_POST['photo'], ENT_QUOTES);
  $data = str_replace(" ", "+", $data);
  $tab  = explode(",", $data);
  echo "ca marche presque.";
  $base = $tab[1];
  
  //file_put_contents($decoded);
}

if (isset($_POST['filter_path'])){
    $tmp = explode("/", $_POST['filter_path']);
    if ($tmp[5] == "take_picture.php" || $tmp[5] == "take_picture.php?"){ 
        $path = "";
    }
    else{
    $path = $trick.$tmp[5];
    }
}

$repond = $bdd->prepare('SELECT username, id FROM user WHERE id = :id');
		      $repond->bindvalue(':id', $_SESSION['id'], PDO::PARAM_INT);
          $repond->execute();
          $pd = $repond->fetch();
          $username = str_replace(" ", "_", $pd['username']);

function setTransparency($new_image,$image_source) 
{ 
    
        $transparencyIndex = imagecolortransparent($image_source); 
        $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255); 
         
        if ($transparencyIndex >= 0) { 
            $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);    
        } 
        
        $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
        imagefill($new_image, 0, 0, $transparencyIndex); 
         imagecolortransparent($new_image, $transparencyIndex); 
    
}
$data = $base;
$data = base64_decode($data);
$im = imagecreatefromstring($data);
$destination = $im;
$source = imagecreatefrompng($path); // Le logo est la source
setTransparency($source,$destination);
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
$destination_x = $largeur_destination - $largeur_source;
$destination_y =  $hauteur_destination - $hauteur_source;
imagecopymerge($destination, $source, 0, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);
imagejpeg($destination, "../pic_taken/$username.$date_name.jpg");
$decoded = "../pic_taken/$username.$date_name.jpg";


try {
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO image (img_path, date, id_user, filter_path)
  VALUES ('".$decoded."', '".$date."', '".$_SESSION['id']."', '".$path."')";
  $bdd->exec($sql);
  echo "New record created successfully";
  }
catch(PDOException $e)
  {
  echo $sql . "<br>" . $e->getMessage();
  }
?>