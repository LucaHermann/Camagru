<?php
require_once('../config/connect.php');
session_start();

$date_name = date("H-i-s__d:m:Y");
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

if (isset($_POST['position'])){
  $positionfiltre = explode("/", $_POST['position']);
}


$repond = $bdd->prepare('SELECT username, id FROM user WHERE id = :id');
		      $repond->bindvalue(':id', $_SESSION['id'], PDO::PARAM_INT);
          $repond->execute();
          $pd = $repond->fetch();
          $username = str_replace(" ", "_", $pd['username']);

function fctdeformimage($W_fin, $H_fin, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
  // Si certains paramètres ont pour valeur '' :
  if ($rep_Dst == '') { $rep_Dst = $rep_Src; } // (même répertoire)
  if ($img_Dst == '') { $img_Dst = $img_Src; } // (même nom)
// ------------------------
// si le fichier existe dans le répertoire, on continue...
if (file_exists($rep_Src.$img_Src) && ($W_fin!=0 || $H_fin!=0)) { 
  // ------------------------
  // extensions acceptées : 
  $extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
  // extension fichier Source
  $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
  // ------------------------
  // extension OK ? on continue ...
  if(in_array($extension_Src, explode(',', $extension_Allowed))) {
      // ------------------------
      // récupération des dimensions de l'image Src
      $img_size = getimagesize($rep_Src.$img_Src);
      $W_Src = $img_size[0]; // largeur
      $H_Src = $img_size[1]; // hauteur
      // ------------------------
      // condition de redimensionnement et dimensions de l'image finale
      // Dans TOUS les cas : redimensionnement non-proportionnel
      // ------------------------
      // A- LARGEUR ET HAUTEUR fixes
      if ($W_fin != 0 && $H_fin != 0) {
        $W = $W_fin;
        $H = $H_fin;
      }
      // ------------------------
      // B- HAUTEUR fixe
      if ($W_fin == 0 && $H_fin != 0) {
        $W = $W_Src;
        $H = $H_fin;
      }
      // ------------------------
      // C- LARGEUR fixe
      if ($W_fin != 0 && $H_fin == 0) {
        $W = $W_fin;
        $H = $H_Src;
      }
      // ------------------------------------------------
      // REDIMENSIONNEMENT
      // ------------------------------------------------
      // creation de la ressource-image "Src" en fonction de l extension
      switch($extension_Src) {
      case 'jpg':
      case 'jpeg':
        $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
        break;
      case 'png':
        $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
        break;
      }
      // ------------------------
      // creation d une ressource-image "Dst" aux dimensions finales
      // fond noir (par defaut)
      switch($extension_Src) {
      case 'jpg':
      case 'jpeg':
        $Ress_Dst = imagecreatetruecolor($W,$H);
        break;
      case 'png':
        $Ress_Dst = imagecreatetruecolor($W,$H);
        // fond transparent (pour les png avec transparence)
        imagesavealpha($Ress_Dst, true);
        $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
        imagefill($Ress_Dst, 0, 0, $trans_color);
        break;
      }
      // ------------------------------------------------
      // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
      imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src); 
      // ------------------------------------------------
      // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
      switch ($extension_Src) { 
      case 'jpg':
      case 'jpeg':
        imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
        break;
      case 'png':
        imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
        break;
      }
      // ------------------------
      // liberation des ressources-image
      imagedestroy ($Ress_Src);
      imagedestroy ($Ress_Dst);
      // ------------------------
  }
}
// ---------------------------------------------------
// retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
if (file_exists($rep_Dst.$img_Dst)) { return true; }
else { return false; }
// ---------------------------------------------------
};

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
if (isset($_POST['upload'])){
  imagejpeg($destination, "../pic_taken/$username.$date_name.jpg");
  $img_src = "$username.$date_name.jpg";
  $redimOK = fctdeformimage(600, 450,'','','../pic_taken/',$img_src);
  if ($redimOK == 1) { $destination = imagecreatefromjpeg("../pic_taken/$username.$date_name.jpg"); }
}
$source = imagecreatefrompng($path); // Le logo est la source
setTransparency($source,$destination);
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
$destination_x = $largeur_destination - $largeur_source;
$destination_y =  $hauteur_destination - $hauteur_source;
imagecopymerge($destination, $source, $positionfiltre[0], $positionfiltre[1], 0, 0, $largeur_source, $hauteur_source, 100);
imagejpeg($destination, "../pic_taken/$username.$date_name.jpg");
$decoded = "../pic_taken/$username.$date_name.jpg";


try {
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = $bdd->prepare('INSERT INTO `image` (img_path, date, id_user, filter_path) VALUES (:img, :date, :iduser, :path)');
  $sql->bindvalue(':img', $decoded, PDO::PARAM_STR);
  $sql->bindparam(':date', $date);
  $sql->bindvalue(':iduser', $_SESSION['id'], PDO::PARAM_INT);
  $sql->bindvalue(':path', $path, PDO::PARAM_STR);
  $sql->execute();
  echo "New record created successfully";
  }
catch(PDOException $e)
  {
  echo $sql . "<br>" . $e->getMessage();
  }
?>