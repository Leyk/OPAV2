<?php
include "inc/_var_fv.php";
include "PHPMailer/class.phpmailer.php";


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
	if($destinataire == "initiateur"){  // Cas où l'on souhaite contacter uniquement l'initiateur du projet
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
				echo "Erreur : l'adresse mail de l'initiateur n'est pas valide";
			}
			else {
				if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
					$passage_ligne = "\r\n";
				}
				else {
					$passage_ligne = "\n";
				}
				/*
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
				// ======================================
				//=====Envoi de l'e-mail
				//if(mail($mail,$sujet,$message,$header)){
					echo "Success";
				} else{
					echo "Erreur lors de l'envoi du mail";
				}
				// ======================================
				*/
				/*
				// ======= deuxième méthode =======
				$email = new PHPMailer();
				$email->IsSMTP();
				$email->Host='hote_smtp';
				$email->From=$posteur_email;
				$email->AddAddress($mail);
				$email->AddReplyTo=$posteur_email;
				$email->Subject='Contact forces vives';
				$email->Body=$posteur_msg;
				if(!$email->Send()){
					echo $email->ErrorInfo;
				} else{
					$email->SmtpClose();
					unset($email);
					*/
					echo "Success";
				//}
				
			}
		} 
		else {
			echo "Erreur : l'identifiant projet n'est pas valide";
		}

	}
	else if ($destinataire == "diffusion"){ // Cas où l'on souhaite contacter toutes les personnes intéressées par ce projet
		// récup des adresses auxquelles envoyer le mail
		$sql = "SELECT posteur_email FROM actions_personnes ap, actions_initiatives_personnes aip WHERE ap.id = aip.id_personne AND id_initiative=".$idproj ;
		$rs = $connexion->prepare($sql);
		$rs->execute() or die ("Erreur : ".__LINE__." : ".$sql);
		$nb_lignes = $rs->rowCount();
		$succ = false; // déterminera si au moins un mail a pu être envoyé
		$resultat = '';
		if($nb_lignes){
			while ($r = $rs->fetch(PDO::FETCH_ASSOC)){  // parcours de l'ensemble des adresses mails dispo dans la "liste de diffusion"
			 	$mail = $r['posteur_email'];

			 	// Vérification validité des adresses mail récupérées
				if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", preg_replace("/[^a-z].-_@/i",'', strtolower($mail)))){
					$resultat = "Mail invalide";
				} 
				else { // mail est valide
					if(true){  // mail est envoyé
						$succ = true;
						$resultat = "Success";

					} 
					else{  // erreur dans l'envoi du mail
						$resultat = "Echec envoi";
					}
				}
			}
			if($succ){
				echo "Success";
			}
			else{
				if($resultat === "Mail invalide"){ // Toutes les adresses mails sont valides
						echo "Erreur : les mails récupérés sont invalides. Aucun mail n'a pu être envoyé." ;
				} 
				else if ($resultat === "Echec envoi") { // Au moins une adresse n'est pas valide

					echo "Erreur : echec envoi, aucun mail n'a pu être envoyé." ;
				}
				else {
					echo "Erreur dans la récupération des adresses mails disponibles.";
				}
			}
		} 
		else {
			echo "Erreur : aucune adresse mail n'a pu être récupérée pour cette action.";
		}
	} 
	else {
		echo "Erreur dans le choix du destinataire dans la liste";
	}
}
?>