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

	// Renvoi l'adresse mail de l'initiateur du projet passé en paramètre
	public function getMailInitiateur($idproj){
		$sql = "SELECT posteur_email FROM actions_initiatives WHERE id=".$idproj ;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetch();
		return $ligne;
	}

	// Retourne l'ensemble des adresses mails (la liste de diffusion) liées au projet passé en paramètre
	public function mailListeDiff($idproj){
		$sql = "SELECT posteur_email FROM actions_personnes ap, actions_initiatives_personnes aip WHERE ap.id = aip.id_personne AND id_initiative=".$idproj ;
		$rs = PdoForcesVives::$monPdo->query($sql);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}
}
?>