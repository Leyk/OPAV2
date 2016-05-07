<?php
include "inc/_var_fv.php";


unset($erreur);

if (isset($_POST['destinataire']) && isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['message']) && isset($_POST['id'])){
	$destinataire = $_POST['destinataire'];
	$posteur_nom = $_POST['nom'];
	$posteur_email = $_POST['mail'];
	$posteur_msg = $_POST['message'];
	$idproj = $_POST['id'];
	if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", preg_replace("/[^a-z].-_@/i",'', strtolower($posteur_email)))){ // vérification validité adresse mail saisie dans form
		$erreur = "Erreur formulaire";
		echo $erreur;
	}
}
else {
	$erreur = "Erreur formulaire";
	echo $erreur;
}

if(!isset($erreur)){
	// récup de l'adresse à laquelle envoyer le mail
	$sql = "SELECT posteur_email FROM actions_initiatives WHERE id=".$idproj ;
	$rs = $connexion->prepare($sql);
	$rs->execute() or die ("Erreur : ".__LINE__." : ".$sql);
	$nb_lignes = $rs->rowCount();
	if($nb_lignes){
		$res = $rs->fetch();
		$mail = $res[0];
		// Vérification validité adresse mail récupérée
		if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", preg_replace("/[^a-z].-_@/i",'', strtolower($mail)))){
			echo "Failed";
		}
		else {
			if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
				$passage_ligne = "\r\n";
			}
			else {
				$passage_ligne = "\n";
			}
			// ===== Déclaration des messages au format texte et au format HTML
			$message_txt = "Salut à tous, voici un mail envoyé par un script PHP";
			$message_html = "<html><head></head><body><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";
			// ======================================

			// ====== Création de la boundary
			$boundary = "-----=".md5(rand());
			// ======================================
			
			// ====== Définition du sujet
			$sujet = "Forces Vives Contact";
			// ======================================

			// ====== Création du header du mail ====
			$header = "From \"Simon\"<savornin@msn.com>".$passage_ligne;
			$header.= "Reply-to: \"Simon\" <savornin@msn.com>".$passage_ligne; 
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
			// ======================================
 
			//=====Envoi de l'e-mail
			//mail($mail,$sujet,$message,$header);
			// ======================================
			echo "Success";
		}
	} 
	else{
		echo "Failed";
	}
}
?>