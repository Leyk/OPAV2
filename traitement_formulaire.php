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
	else if ($destinataire == "diffusion"){

	} 
	else {
		echo "Erreur dans le choix du destinataire dans la liste";
	}
}
?>