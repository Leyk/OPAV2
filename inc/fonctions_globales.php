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


// Cette fonction vérifie si une adresse mail est valide
// Return false si adresse mail non valide
// Returne true si adresse mail valide
function valideMail($mail){
  if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", preg_replace("/[^a-z].-_@/i",'', strtolower($mail)))){
    return true; // le mail est valide
  }
  else {
    return false;
  }
}

// Envoi un email à partir des infos passées en paramètre
function envoiMail($mail_dest, $posteur_nom, $posteur_email, $posteur_msg){
  if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail_dest)){
          $passage_ligne = "\r\n";
        }
        else {
          $passage_ligne = "\n";
        }
        // ===== Déclaration des messages au format texte et au format HTML
        $message_txt = $posteur_msg;
        $message_html = "<html><head></head><body>".$posteur_msg."</body></html>";
        // ======================================

        // ====== Création de la boundary
        $boundary = "-----=".md5(rand());
        // ======================================
        
        // ====== Définition du sujet
        $sujet = "Forces Vives Contact";
        // ======================================

        // ====== Création du header du mail ====
        $header = "From: \"".$posteur_nom."\"<".$posteur_email.">".$passage_ligne;   // A changer
        $header.= "Reply-to: \"".$posteur_nom."\"<".$posteur_email.">".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne."boundary=\"$boundary\"".$passage_ligne."boundary=\"$boundary\"".$passage_ligne;
        // ======================================

        // ====== Création du message
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        // Ajout message au format texte
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        // ======================================
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        // Ajout message au format HTML
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        // =======================================
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //=====Envoi de l'e-mail
        if(true /*mail($mail_dest,$sujet,$message,$header)*/){   // A UTILISER SUR SERVEUR
          return true;
        }
        else{
          return false;
        }

        /*
        // ======= deuxième méthode =======
        $email = new PHPMailer();
        $email->IsSMTP();
        $email->Host='hote_smtp';
        $email->From=$posteur_email;
        $email->AddAddress($mail_dest);
        $email->AddReplyTo=$posteur_email;
        $email->Subject='Contact forces vives';
        $email->Body=$posteur_msg;
        if(!$email->Send()){
          echo $email->ErrorInfo;
        } else{
          $email->SmtpClose();
          unset($email);
        }
          */
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
      if (valideMail($mail)){
        $succ = true; // le mail est valide
      } 
    }
    return $succ; // false si aucun mail vérifié n'est valide, true si au moins une est valide
  }
  else { // aucune ligne = aucune adresse mail
    return false;
  }
}

// Renvoi l'adresse mail de l'initiateur du projet passé en paramètre
function getMailInitiateur($idproj){
  global $connexion;
  $sql = "SELECT posteur_email FROM actions_initiatives WHERE id=".$idproj ;
  $rs = $connexion->prepare($sql);
  $rs->execute() or die ("Erreur : ".__LINE__." : ".$sql);
  $ligne = $rs->fetch();
  return $ligne;
}

?>