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

// Cette fonction vérifie si pour une action donnée, au moins une adresse mail est valide
// Return false si aucune adresse mail valide
// Return true si au moins une adresse mail est valide
function mailListeDiff($idproj){
  global $connexion;
  $sql = "SELECT posteur_email FROM actions_personnes ap, actions_initiatives_personnes aip WHERE ap.id = aip.id_personne AND id_initiative=".$idproj ;
  $rs = $connexion->prepare($sql);
  $rs->execute() or die ("Erreur : ".__LINE__." : ".$sql);
  $nb_lignes = $rs->rowCount();
  $succ = false; // déterminera si au moins un mail est valide
  if($nb_lignes){
    while ($r = $rs->fetch(PDO::FETCH_ASSOC) and $succ == false){  // parcours de l'ensemble des adresses mails dispo dans la "liste de diffusion"
      $mail = $r['posteur_email'];
      // Vérification validité des adresses mail récupérées
      if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", preg_replace("/[^a-z].-_@/i",'', strtolower($mail)))){
        $succ = true; // le mail est valide
      } 
    }
    return $succ; // false si aucun mail vérifié n'est valide, true si au moins une est valide
  }
  else { // aucune ligne = aucune adresse mail
    return false;
  }
}

?>