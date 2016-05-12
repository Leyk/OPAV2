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
}

?>