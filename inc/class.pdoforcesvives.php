<?php

/**
 * Classe d'accès aux données
 */

class PdoForcesVives{
	private static $serveur='mysql:host=127.0.0.1';
	private static $bd='dbname=forcesviueopa';
	private static $user='root';
	private static $mdp='';
	private static $monPdo;
	private static $monPdoForcesVives=null;

	// Crée l'instance de PDO qui sera sollicitée pour toutes les méthodes de la classe 
	private function __construct(){
		try{
			PdoForcesVives::$monPdo = new PDO(PdoForcesVives::$serveur.';'.PdoForcesVives::$bd, PdoForcesVives::$user, PdoForcesVives::$mdp);
			PdoForcesVives::$monPdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			PdoForcesVives::$monPdo->query("SET CHARACTER SET utf8");
		}
		catch (PDOException $e){
			echo "Erreur de connexion au serveur : ", $e->getMessage();
		}	
	}

	public function _destruct(){
		PdoForcesVives::$monPdo = null ;
	}

	// Crée l'unique instance de la classe 
	public static function getPdoForcesVives(){
		if(PdoForcesVives::$monPdoForcesVives==null){
			PdoForcesVives::$monPdoForcesVives = new PdoForcesVives();
		}
		return PdoForcesVives::$monPdoForcesVives;
	}

	// Retourne toutes les informations relatives à l'action passée en paramètre
	public function getInfosActions($idac){
		$sql = 'SELECT * FROM actions_initiatives WHERE id ="'.$idac.'" AND initiative_titre != "" LIMIT 0,1';
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetch();
		return $ligne;
	}

	// Retourne les rubriques associées à l'action passée en paramètre
	public function getRubAction($idac){
		$sql = 'SELECT titre, id_centreinteret FROM actions_initiatives_rubriques I, actions_rubriques R WHERE I.id_rubrique = R.id AND id_initiative ="'.$idac.'" LIMIT 0,10';
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}

	// Retourne l'adresse mail de l'initiateur de l'action passée en paramètre
	public function getMailInitiateur($idac){
		$sql = 'SELECT posteur_email FROM actions_initiatives WHERE id='.$idac ;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetch();
		return $ligne;
	}

	// Retourne l'ensemble des adresses mails (la liste de diffusion) liées à l'action passée en paramètre
	public function getListeDiffusion($idac){
		$sql = 'SELECT posteur_email FROM actions_personnes ap, actions_initiatives_personnes aip WHERE ap.id = aip.id_personne AND id_initiative='.$idac ;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}	

	// Vérifie si l'adresse mail passée en paramètre existe dans la liste de diffusion de l'action passée en paramètre
	// Retourne true si elle existe
	// Retourne false sinon
	public function existeMailDiff($idac, $mail){
		$sql = 'SELECT posteur_email FROM actions_personnes ap, actions_initiatives_personnes aip WHERE ap.id = aip.id_personne AND id_initiative='.$idac.' AND posteur_email ="'.$mail.'"' ;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetch();
		if(!is_array($ligne)){
			return false;
		}
		else {
			return true;
		}
	}

	
	// Retourne les infos de la personne correspondante à l'adresse mail passée en paramètre
	public function getPersonneByMail($mail){
		$sql = 'SELECT * FROM actions_personnes WHERE posteur_email ="'.$mail.'"';
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetch();
		return $ligne;
	}

	// Insertion en bd de la personne dont les données sont passées en paramètre 
	// Retourne true si l'insertion s'est réalisée
	// Retourne false si l'adresse mail existe déjà en bd ou si problème dans l'insertion 
	/*public function insertPersonne($nom, $prenom, $mail) {
		if (!is_array(getPersonneByMail($mail)){
			$sql = 'INSERT INTO actions_personnes (nom, prenom, posteur_email) VALUES ("'.$nom.'","'.$prenom.'","'.$mail.'")';
			$rs = PdoForcesVives::$monPdo->exec($sql);
			return $rs;
		}
		else {
			return false;
		}	
	}*/
	public function insertPersonne($nom, $prenom, $mail) {
			$sql = 'INSERT INTO actions_personnes (nom, prenom, posteur_email) VALUES ("'.$nom.'","'.$prenom.'","'.$mail.'")';
			$rs = PdoForcesVives::$monPdo->exec($sql);
			return $rs;
	}

	// Insertion de l'adresse mail passée en paramètre dans la liste de diffusion de l'action passée en paramètre
	// Si l'adresse mail n'existe pas déjà dans la base de données, elle y est également ajoutée
	// Retourne true si l'insertion s'est réalisée
	// Retourne false si problème dans l'insertion
	/*public function insertDiffusion($idac, $nom, $prenom, $mail){
		if (!getPersonneByMail($mail)){ // test : l'adresse mail n'existe pas en bd
			$ins = insertPersonne($nom, $prenom, $mail);
			if($ins){ // insertion ok
				$idpers = getPersonneByMail($mail);
				$sql = 'INSERT INTO actions_initiatives_personnes (id_initiative, id_personne) VALUES ('.$idac.','.$idpers.')';
				$rs = PdoForcesVives::$monPdo->exec($sql);
				return $rs;
			}
			else { // insertion échouée
				return false;
			}
		}
		else { // l'adresse mail existe déjà en bd, on ne fait donc que le lien entre celle-ci et l'action
			$idpers = getPersonneByMail($mail);
			$sql = 'INSERT INTO actions_initiatives_personnes (id_initiative, id_personne) VALUES ('.$idac.','.$idpers.')';
			$rs = PdoForcesVives::$monPdo->exec($sql);
			return $rs;
		}
	}*/
	public function insertDiffusion($idac, $idpers){
		$sql = 'INSERT INTO actions_initiatives_personnes (id_initiative, id_personne) VALUES ('.$idac.','.$idpers.')';
		$rs = PdoForcesVives::$monPdo->exec($sql);
		return $rs;
	}
	
}

?>