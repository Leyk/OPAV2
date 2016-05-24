<?php
include "inc/_var_fv.php";

unset($erreur);
unset($maReponse);
unset($lesErreurs);
unset($lesResultats);
// variables de retour au formulaire
$lesErreurs = array();
$lesResultats = array();

// == Récupération des variables transmises par form_contact et détection d'éventuelles erreurs (variables obligatoires manquantes) ==
if (isset($_POST['destinataire']) && isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['id'])){
	$destinataire = $_POST['destinataire'];
	$posteur_nom = $_POST['nom'];
	$posteur_email = $_POST['mail'];
	$idproj = $_POST['id'];
	if (!valideMail($posteur_email)){ // vérification validité adresse mail saisie dans form
		$erreur = true;
	}
	if($destinataire == "initiateur"){ // vérification du champ message si l'on contacte un initiateur
		if(isset($_POST['message'])){
			$posteur_msg = $_POST['message'];
		}
		else {
			$erreur = true;
		}
	}
	else if ($destinataire == "diffusion"){
		if ($pdo->getListeDiffusion($idproj)){
			if(isset($_POST['message'])){
				$posteur_msg = $_POST['message']; // vérification du champ message si l'on contacte la liste de diffusion ET qu'il y a bien des adresses mails dans cette liste
			}
			else {
				$erreur = true;
			}
		}
	}
}
else {
	$erreur = true;
}
// =======================================================================================================================================
// on ne traite le formulaire que si tous les champs obligatoires sont remplis
if(!isset($erreur)){
	if(isset($_POST['prenom'])){
		$posteur_prenom = $_POST['prenom'];
	}
	else {
		$posteur_prenom = "";
	}
	if($destinataire == "initiateur"){  // Cas où l'on souhaite contacter uniquement l'initiateur du projet

		// récup de l'adresse à laquelle envoyer le mail
		$res = $pdo->getMailInitiateur($idproj);
		if(is_array($res)){
			$mail = $res[0];
			// Vérification validité adresse mail récupérée
			if (!valideMail($mail)){
				$lesErreurs[] = "Erreur : l'adresse mail de l'initiateur n'est pas valide.<br/>";
			}
			else {
				if(envoiMail($mail, $posteur_nom, $posteur_email, $posteur_msg)){
					$lesResultats[] = "Votre message a été envoyé avec succès !<br/>";
				}
				else{
					$lesErreurs[] = "Erreur lors de l'envoi du mail.<br/>";
				}		
			}
		} 
		else {
			$lesErreurs[] = "Erreur : l'identifiant projet n'est pas valide.<br/>";
		}
	}
	else if ($destinataire == "diffusion"){ // Cas où l'on souhaite contacter toutes les personnes interessées par ce projet
	// ================================== Traitement de l'insertion de l'adresse mail en BD ======================================
		if(!$pdo->existeMailDiff($idproj, $posteur_email)){ // Cas où l'adresse mail n'existe pas encore dans la liste de diffusion pour le projet choisi
			$pers = $pdo->getPersonneByMail($posteur_email); // on tente de vérifier si l'adresse mail existe déjà en bd
			if(is_array($pers)){
				$idpers = $pers[0];
				$insertDiff = $pdo->insertDiffusion($idproj, $idpers); // si elle existe, on ajoute juste une liaison entre le projet et la personne
				if ($insertDiff){
					$insertion = "Success";
				}
				else {
					$insertion = "Erreur";
				}
			} // end is_array($pers)
			else { // si l'adresse mail n'existe pas encore en bd on l'ajoute
				$insertPers = $pdo->insertPersonne($posteur_nom, $posteur_prenom, $posteur_email);
				if ($insertPers){
					$pers = $pdo->getPersonneByMail($posteur_email); // on récupère l'ID de la personne insérée
					$idpers = $pers[0];
					$insertDiff = $pdo->insertDiffusion($idproj, $idpers); // on ajoute la liaison entre le projet et la personne
					if ($insertDiff){
						$insertion = "Success";
					}
					else {
						$insertion = "Erreur";
					}
				}
				else {
					$insertion = "Erreur";
				}
			}
		}
		else {
			$insertion = "None";
		}
		// =============================================================================================================================
		if(isset($posteur_msg)){
			// récup des adresses auxquelles envoyer le mail
			$lesMails = $pdo->getListeDiffusionRestrict($idproj, $posteur_email);
			$succ = false; // déterminera si au moins un mail a pu être envoyé
			$resultat = '';
			if (is_array($lesMails)){
				foreach ($lesMails as $r) {  // parcours de l'ensemble des adresses mails dispo dans la "liste de diffusion"
					$mail = $r['posteur_email'];
					// Vérification validité des adresses mail récupérées
					if (!valideMail($mail)){
						$resultat = "Mail invalide";
					}
					else { // mail est valide
						if(envoiMail($mail, $posteur_nom, $posteur_email, $posteur_msg)) { // mail est envoyé
							$succ = true;
							$resultat = "Success";
						}
						else { // erreur dans l'envoi du mail
							$resultat = "Echec envoi";
						}
					}
				}
				if ($succ) {
					$lesResultats[] = "Votre message a été envoyé avec succès !<br/>";
				}
				else {
					if ($resultat == "Mail invalide") { // Toutes les adresses mails sont valides
						$lesErreurs[] = "Erreur : les mails récupérés sont invalides. Aucun mail n'a pu être envoyé.<br/>";
					}
					else if ($resultat == "Echec envoi") { // Au moins une adresse n'est pas valide
						$lesErreurs[] = "Erreur : echec envoi, aucun mail n'a pu être envoyé.<br/>";
					}
					else {
						$lesErreurs[] = "Erreur dans la récupération des adresses mails disponibles.<br/>"; 
					}
				}
			}
			else {
				$lesErreurs[] = "Erreur : aucune adresse mail autre que la vôtre n'a pu être récupérée pour cette action.<br/>";
			}
		}
		if ($insertion == "Success"){
			$lesResultats[] = "Votre adresse mail a bien été ajoutée à la liste de diffusion de cette action !<br/>";
		}
		else if ($insertion == "Erreur") {
			$lesErreurs[] = "Un problème est survenu lors de l'ajout de votre adresse mail à la liste de diffusion de cette action.<br/>";
		}
		else {
			$lesErreurs[] = "Votre adresse mail appartenait déjà à la liste de diffusion de cette action.<br/>";
		}

	}	
	else {
		$lesErreurs[] = "Erreur dans le choix du destinataire dans la liste. <br/>";
	}			
}
else {
	$lesErreurs[] = "Erreur formulaire. <br/>";
}

$maReponse = array('Erreur'=> $lesErreurs,'Success'=> $lesResultats);
echo json_encode($maReponse);
?>