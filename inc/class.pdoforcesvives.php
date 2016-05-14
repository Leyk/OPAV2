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

	// Retourne l'ensemble des adresses mails (la liste de diffusion) liées à l'action passée en paramètre SAUF l'adresse mail passée en paramètre
	public function getListeDiffusionRestrict($idac, $mail){
		$sql = 'SELECT posteur_email FROM actions_personnes ap, actions_initiatives_personnes aip WHERE ap.id = aip.id_personne AND id_initiative='.$idac.' AND posteur_email !="'.$mail.'"' ;
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
	public function insertPersonne($nom, $prenom, $mail) {
		$sql = 'INSERT INTO actions_personnes (nom, prenom, posteur_email) VALUES ("'.$nom.'","'.$prenom.'","'.$mail.'")';
		$rs = PdoForcesVives::$monPdo->exec($sql);
		return $rs;
	}

	// Insertion de l'adresse mail passée en paramètre dans la liste de diffusion de l'action passée en paramètre
	// Retourne true si l'insertion s'est réalisée
	// Retourne false si problème dans l'insertion
	public function insertDiffusion($idac, $idpers){
		$sql = 'INSERT INTO actions_initiatives_personnes (id_initiative, id_personne) VALUES ('.$idac.','.$idpers.')';
		$rs = PdoForcesVives::$monPdo->exec($sql);
		return $rs;
	}
	
	// Affiche la liste des actions
	// Entrée : string $statut : Statut des actions à ramener
	//          string $limit  : Nombre d'actions à ramener
	public function affichageActions($where_statut, $limit){
		$sql = 'SELECT * FROM actions_initiatives WHERE afficher > 0 AND initiative_titre != "" AND'.$where_statut.' ORDER BY dateheure_ajout DESC LIMIT 0,'.$limit;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}

    // Affiche la liste des rubriques
	public function affichageRubriques(){
		$sql = 'SELECT * FROM actions_rubriques WHERE titre != "" ORDER BY id_centreinteret DESC, titre ASC';
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;

	}

	// Retourne le nom du centre d'intérêt dont l'id est passé en paramètre
	public function getNomCentreInteret($id){
		$sql = 'SELECT titre FROM actions_centreinteret C WHERE id ='.$id.' LIMIT 0,1';
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}

	// Retourne tous les centres d'intérêt
	public function getCentreInteret(){
		$sql = 'SELECT titre, id FROM actions_centreinteret C WHERE titre != ""';
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}

	// Retourne la liste des rubriques pour le centre d'intérêt dont l'id est passé en paramètre
	public function getRubriqueCI($id){
		$sql = 'SELECT titre, id FROM actions_rubriques WHERE titre != "" AND id_centreinteret = '.$id;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}

	// Retourne la liste des action pour la rubrique dont l'id est passé en paramètre
	public function getActionRub($id){
		$sql = 'SELECT initiative_titre,id FROM actions_initiatives I, actions_initiatives_rubriques L WHERE I.afficher > 0 AND L.id_rubrique = '.$id.' AND I.initiative_titre != "" AND I.id = L.id_initiative';
        $rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}
 


}

?>