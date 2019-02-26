<?php
// --------------------------------------------------------------------------------------------------
// fonction de REDIMENSIONNEMENT physique "proportionnel" et ENREGISTREMENT
// --------------------------------------------------------------------------------------------------
// retourne : 1 (vrai) si le redimensionnement et l enregistrement ont bien eu lieu, sinon rien (false)
// --------------------------------------------------------------------------------------------------
// La FONCTION : fct_redim_image($Wmax, $Hmax, $rep_Dst, $img_Dst, $rep_Src, $img_Src)
// Les paramètres :
// - $Wmax : LARGEUR maxi finale ----> ou 0 : largeur libre
// - $Hmax : HAUTEUR maxi finale ----> ou 0 : hauteur libre
// - $rep_Dst : répertoire de l image de Destination (déprotégé) ----> ou '' : même répertoire
// il faut s'assurer que les droits en écriture ont été donnés au dossier (chmod ou via logiciel FTP)
// - $img_Dst : NOM de l image de Destination ----> ou '' : même nom que l image Src
// - $rep_Src : répertoire de l image Source (déprotégé)
// - $img_Src : NOM de l image Source
// --------------------------------------------------------------------------------------------------
// si $rep_Dst = ''   : $rep_Dst=$rep_Src (même répertoire)
// si $img_Dst = '' : $img_Dst=$img_Src (même nom)
// Attention : si $rep_Dst='' ET $img_Dst='' : on écrase (remplace) l image source ($img_Src) !
// NB : $img_Dst et $img_Src doivent avoir la même extension (même type mime) !
// --------------------------------------------------------------------------------------------------
// 3 options :
// A- $Wmax != 0 et $Hmax != 0 : a LARGEUR maxi ET HAUTEUR maxi fixes
// B- si $Wmax = 0 : image finale a LARGEUR maxi fixe (hauteur libre)
// C- si $Hmax = 0 : image finale a HAUTEUR maxi fixe (largeur libre)
// --------------------------------------------------------------------------------------------------
// Extensions acceptees (traitees ici) : .jpg , .jpeg , .png
// Pour ajouter d autres extensions : voir la bibliothèque GD ou ImageMagick
// (GD) NE FONCTIONNE PAS avec les GIF ANIMES ou a fond transparent !
// --------------------------------------------------------------------------------------------------
// UTILISATION (exemple) :
// $redimOK = fct_redim_image(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
// if ($redimOK == 1) { echo 'Redimensionnement OK !';  }
// --------------------------------------------------------------------------------------------------
function fct_redim_image($Wmax, $Hmax, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
  // ------------------------------------------------------------------
 $condition = 0;
  // Si certains paramètres ont pour valeur '' :
   if ($rep_Dst == '') { $rep_Dst = $rep_Src; }  // (meme repertoire)
   if ($img_Dst == '') { $img_Dst = $img_Src; }  // (meme nom)
   if ($Wmax == '') { $Wmax = 0; }
   if ($Hmax == '') { $Hmax = 0; }
  // ------------------------------------------------------------------
  // si le fichier existe dans le répertoire, on continue...
 if (file_exists($rep_Src.$img_Src) && ($Wmax!=0 || $Hmax!=0)) { 
    // ----------------------------------------------------------------
    // extensions acceptées : 
   $ExtfichierOK = '" jpg jpeg png"';  // (l espace avant jpg est important)
    // extension
   $tabimage = explode('.',$img_Src);
   $extension = $tabimage[sizeof($tabimage)-1];  // dernier element
   $extension = strtolower($extension);  // on met en minuscule
    // ----------------------------------------------------------------
    // extension OK ? on continue ...
   if (strpos($ExtfichierOK,$extension) != '') {
       // -------------------------------------------------------------
       // récupération des dimensions de l image Src
      $size = getimagesize($rep_Src.$img_Src);
      $W_Src = $size[0];  // largeur
      $H_Src = $size[1];  // hauteur
       // -------------------------------------------------------------
       // condition de redimensionnement et dimensions de l image finale
       // -------------------------------------------------------------
       // A- LARGEUR ET HAUTEUR maxi fixes
      if ($Wmax != 0 && $Hmax != 0) {
         $ratiox = $W_Src / $Wmax;  // ratio en largeur
         $ratioy = $H_Src / $Hmax;  // ratio en hauteur
         $ratio = max($ratiox,$ratioy);  // le plus grand
         $W = $W_Src/$ratio;
         $H = $H_Src/$ratio;   
         $condition = ($W_Src>$W) || ($W_Src>$H);  // 1 si vrai (true)
      }
       // -------------------------------------------------------------
       // B- LARGEUR maxi fixe
      if ($Hmax != 0 && $Wmax == 0) {
         $H = $Hmax;
         $W = $H * ($W_Src / $H_Src);
         $condition = $H_Src > $Hmax;  // 1 si vrai (true)
      }
       // -------------------------------------------------------------
       // C- HAUTEUR maxi fixe
      if ($Wmax != 0 && $Hmax == 0) {
         $W = $Wmax;
         $H = $W * ($H_Src / $W_Src);         
         $condition = $W_Src > $Wmax;  // 1 si vrai (true)
      }
       // -------------------------------------------------------------
       // on REDIMENSIONNE si la condition est vraie
       // -------------------------------------------------------------
      if ($condition == 1) {
          // création de la ressource-image"Src" en fonction de l extension
          // et on crée une ressource-image"Dst" vide aux dimensions finales
         switch($extension) {
         case 'jpg':
         case 'jpeg':
           $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
           $Ress_Dst = ImageCreateTrueColor($W,$H);
           break;
         case 'png':
           $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
           $Ress_Dst = ImageCreateTrueColor($W,$H);
            // fond transparent (pour les png avec transparence)
           imagesavealpha($Ress_Dst, true);
           $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
           imagefill($Ress_Dst, 0, 0, $trans_color);
           break;
         }
          // ----------------------------------------------------------
          // REDIMENSIONNEMENT (copie, redimensionne, ré-echantillonne)
         ImageCopyResampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src); 
          // ----------------------------------------------------------
          // ENREGISTREMENT dans le répertoire (avec la fonction appropriée)
         switch ($extension) { 
         case 'jpg':
         case 'jpeg':
           ImageJpeg ($Ress_Dst, $rep_Dst.$img_Dst);
           break;
         case 'png':
           imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
           break;
         }
          // ----------------------------------------------------------
          // libération des ressources-image
         imagedestroy ($Ress_Src);
         imagedestroy ($Ress_Dst);
      }
       // -------------------------------------------------------------
   }
 }
// --------------------------------------------------------------------------------------------------
  // retourne : 1 (vrai) si le redimensionnement et l enregistrement ont bien eu lieu, sinon rien (false)
  // si le fichier a bien été créé
 if ($condition == 1 && file_exists($rep_Dst.$img_Dst)) { return true; }
 else { return false; }
}
// --------------------------------------------------------------------------------------------------
?> 
