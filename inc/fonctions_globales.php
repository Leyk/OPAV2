<?php

/** Convertit la date au format français
------------------------------------------------------------------------ 
 *  Entrée : string $date_us : date au format US
             Boolean $avecheure : afficher l'heure ?
 *  Sortie : string $date_fr : chaine formaté
------------------------------------------------------------------------ 
 */
function datefr($date_us,$avecheure=false) { 
  $annee = substr($date_us,0,4);
  $mois = substr($date_us,5,2);
  $jour = substr($date_us,8,2);
  $date_fr = $jour."/".$mois."/".$annee;
  
  if ($avecheure && (substr($date_us,-9)!=" 00:00:00"))
  {
   $heu = substr($date_us,11,2);
   $min = substr($date_us,14,2);
   $sec = substr($date_us,17,2);
   $date_fr .= " à ".$heu.":".$min.":".$sec;
  }
  return $date_fr;
}

/** Couper une chaine au nb_car caractere
------------------------------------------------------------------------ 
 *  Entrée : string $chaine : chaîne à couper
             int $nb_car : nombre de carractères maximum
             booleen $aff_suite : affiche [...] si vrai
 *  Sortie : string $url : la chaîne coupée
------------------------------------------------------------------------ 
 */
function coupe_chaine($chaine, $nb_car,$aff_suite=false)
{
  if(strlen($chaine)>=$nb_car)
  {
   // Supprime les tags html
   $chaine=strip_tags(nl2br($chaine));
   // Met la portion de chaine dans $chaine
   $chaine=substr($chaine,0,$nb_car); 
   // position du dernier espace
   $espace=strrpos($chaine," "); 
   // test si il ya un espace
   if($espace)
    // si ya 1 espace, coupe de nouveau la chaine
    $chaine=substr($chaine,0,$espace);
   // Ajoute ... à la chaine
   if ($aff_suite) $chaine .= ' [...]';
  }
 // Renvoi url rewritée
 return $chaine;
}
?>