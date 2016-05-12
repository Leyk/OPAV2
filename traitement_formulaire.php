<?php
include "inc/_var_fv.php";


unset($erreur);

if (isset($_POST['destinataire']) && isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['message']) && isset($_POST['id'])){
	$destinataire = $_POST['destinataire'];
	$posteur_nom = $_POST['nom'];
	$posteur_email = $_POST['mail'];
	$posteur_msg = $_POST['message'];
	$idproj = $_POST['id'];
	if (!valideMail($posteur_email)){ // vérification validité adresse mail saisie dans form
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
		$res = getMailInitiateur($idproj);
		if(is_array($res)){
			$mail = $res[0];
			// Vérification validité adresse mail récupérée
			if (!valideMail($mail)){
				echo "Erreur : l'adresse mail de l'initiateur n'est pas valide";
			}
			else {
				if(envoiMail($mail, $posteur_nom, $posteur_email, $posteur_msg)){
					echo "Success";
				}
				else{
					echo "Erreur lors de l'envoi du mail.";
				}		
			}
		} 
		else {
			echo "Erreur : l'identifiant projet n'est pas valide";
		}
	}
	else if ($destinataire == "diffusion"){ // Cas où l'on souhaite contacter toutes les personnes interessées par ce projet
		// récup des adresses auxquelles envoyer le mail
		$lesMails = $pdo->getListeDiffusion($idproj);
		$succ = false; // déterminera si au moins un mail a pu être envoyé
		$resultat = '';
		if(is_array($lesMails)){
			foreach ($lesMails as $r){  // parcours de l'ensemble des adresses mails dispo dans la "liste de diffusion"
			 	$mail = $r['posteur_email'];

			 	// Vérification validité des adresses mail récupérées
				if (!valideMail($mail)){
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