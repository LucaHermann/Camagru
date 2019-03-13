<?php
// ---------------------------------------------------
// fonction de REDIMENSIONNEMENT physique "NON-PROPORTIONNEL" et Enregistrement
// ---------------------------------------------------
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// ---------------------
// retourne : 1 (vrai) si le redimensionnement et l'enregistrement ont bien eu lieu, sinon rien (false)
// ---------------------// La FONCTION : fctdeformimage ($W_fin, $H_fin, $rep_Dst, $img_Dst, $rep_Src, $img_Src)
// Les paramètres :
// - $W_fin : LARGEUR finale --> ou 0
// - $H_fin : HAUTEUR finale --> ou 0
// - $rep_Dst : repertoire de l'image de Destination (déprotégé) --> ou '' (même répertoire)
// - $img_Dst : NOM de l'image de Destination --> ou '' (même nom que l'image Source)
// - $rep_Src : repertoire de l'image Source (déprotégé)
// - $img_Src : NOM de l'image Source
// ------------------------
// 3 options :
// A- si $W_fin != 0 et $H_fin != 0 : image finale a LARGEUR ET HAUTEUR fixes
// B- si $H_fin != 0 et $W_fin == 0 : image finale a HAUTEUR fixe (largeur auto)
// C- si $W_fin == 0 et $H_fin != 0 : image finale a LARGEUR fixe (hauteur auto)
// Dans TOUS les cas : redimensionnement non-proportionnel
// ------------------------
// $rep_Dst : il faut s'assurer que les droits en écriture ont été donnés au dossier (chmod)
// - si $rep_Dst = ''   : $rep_Dst = $rep_Src (même répertoire que l'image Source)
// - si $img_Dst = '' : $img_Dst = $img_Src (même nom que l'image Source)
// - si $rep_Dst='' ET $img_Dst='' : on ecrase (remplace) l'image source !
// ------------------------
// NB : $img_Dst et $img_Src doivent avoir la meme extension (meme type mime) !
// Extensions acceptées (traitees ici) : .jpg , .jpeg , .png
// Pour ajouter d autres extensions : voir la bibliotheque GD ou ImageMagick
// (GD) NE fonctionne PAS avec les GIF ANIMES ou a fond transparent !
// ------------------------
// UTILISATION (exemple) :
// $deformOK = fctredimimage(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
// if ($deformOK == 1) { echo 'Redimensionnement OK !';  }
// ---------------------------------------------------
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

$redimOK = fctdeformimage(600, 450,'','','../ressources/','50670010_2226345200986323_3588984516326195200_o (1).jpg');
if ($redimOK == 1) { echo 'Redimensionnement OK !'; }

?> 
