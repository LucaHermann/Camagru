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

// function fct_redim_image($Wmax, $Hmax, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
//   $condition = 0;
//   // Si certains paramètres ont pour valeur '' :
//     if ($rep_Dst == '') { $rep_Dst = $rep_Src; }  // (meme repertoire)
//     if ($img_Dst == '') { $img_Dst = $img_Src; }  // (meme nom)
//     if ($Wmax == '') { $Wmax = 0; }
//     if ($Hmax == '') { $Hmax = 0; }
//   // si le fichier existe dans le répertoire, on continue...
//   if (file_exists($rep_Src.$img_Src) && ($Wmax!=0 || $Hmax!=0)) { 
//     // extensions acceptées : 
//     $ExtfichierOK = '" jpg jpeg png"';  // (l espace avant jpg est important)
//     // extension
//     $tabimage = explode('.',$img_Src);
//     $extension = $tabimage[sizeof($tabimage)-1];  // dernier element
//     $extension = strtolower($extension);  // on met en minuscule
//     // extension OK ? on continue ...
//     if (strpos($ExtfichierOK,$extension) != '') {
//         // récupération des dimensions de l image Src
//       $size = getimagesize($rep_Src.$img_Src);
//       $W_Src = $size[0];  // largeur
//       $H_Src = $size[1];  // hauteur
//         // condition de redimensionnement et dimensions de l image finale
//         // A- LARGEUR ET HAUTEUR maxi fixes
//       if ($Wmax != 0 && $Hmax != 0) {
//           $ratiox = $W_Src / $Wmax;  // ratio en largeur
//           $ratioy = $H_Src / $Hmax;  // ratio en hauteur
//           $ratio = max($ratiox,$ratioy);  // le plus grand
//           $W = $W_Src/$ratio;
//           $H = $H_Src/$ratio;   
//           $condition = ($W_Src>$W) || ($W_Src>$H);  // 1 si vrai (true)
//       }
//         // B- LARGEUR maxi fixe
//       if ($Hmax != 0 && $Wmax == 0) {
//           $H = $Hmax;
//           $W = $H * ($W_Src / $H_Src);
//           $condition = $H_Src > $Hmax;  // 1 si vrai (true)
//         // C- HAUTEUR maxi fixe
//       if ($Wmax != 0 && $Hmax == 0) {
//           $W = $Wmax;
//           $H = $W * ($H_Src / $W_Src);         
//           $condition = $W_Src > $Wmax;  // 1 si vrai (true)
//       }
//         // on REDIMENSIONNE si la condition est vraie
//       if ($condition == 1) {
//           // création de la ressource-image"Src" en fonction de l extension
//           // et on crée une ressource-image"Dst" vide aux dimensions finales
//           switch($extension) {
//           case 'jpg':
//           case 'jpeg':
//             $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
//             $Ress_Dst = ImageCreateTrueColor($W,$H);
//             break;
//           case 'png':
//             $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
//             $Ress_Dst = ImageCreateTrueColor($W,$H);
//             // fond transparent (pour les png avec transparence)
//             imagesavealpha($Ress_Dst, true);
//             $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
//             imagefill($Ress_Dst, 0, 0, $trans_color);
//             break;
//           }
//           // REDIMENSIONNEMENT (copie, redimensionne, ré-echantillonne)
//           ImageCopyResampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
//           // ENREGISTREMENT dans le répertoire (avec la fonction appropriée)
//           switch ($extension) { 
//           case 'jpg':
//           case 'jpeg':
//             ImageJpeg ($Ress_Dst, $rep_Dst.$img_Dst);
//             break;
//           case 'png':
//             imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
//             break;
//           }
//           // libération des ressources-image
//           imagedestroy ($Ress_Src);
//           imagedestroy ($Ress_Dst);
//       }
//     }
//   }
//   // retourne : 1 (vrai) si le redimensionnement et l enregistrement ont bien eu lieu, sinon rien (false)
//   // si le fichier a bien été créé
//   if ($condition == 1 && file_exists($rep_Dst.$img_Dst)) { return true; }
//   else { return false; }
// }

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
imagecopymerge($destination, $source, $positionfiltre[0], $positionfiltre[1], 0, 0, $largeur_source, $hauteur_source, 100);
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