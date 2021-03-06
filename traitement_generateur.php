<?php

unset($erreur);

// Récupération du bouton de soumission (est-ce seulement un test de connexion ou bien la soumission du formulaire de la base pour afficher la constellation)
if(isset($_POST['bouton'])){
  $bouton = $_POST['bouton'];
}
else {
  $erreur = true;
}

if(!isset($erreur)){
    // == Récupération des variables transmises par formgene et détection d'éventuelles erreurs (variables obligatoires manquantes) ==
    if (isset($_POST['source']) && isset($_POST['hote']) && isset($_POST['bdname']) && isset($_POST['bduser'])){
      $source = $_POST['source'];
      $host = $_POST['hote'];
      $dbname = $_POST['bdname'];
      $user = $_POST['bduser'];
      if (isset($_POST['bdpswd'])){
        $pswd = $_POST['bdpswd'];
      }
      else {
        $pswd = "";
      }
    }
    else {
      $erreur = true;
    }
    if($bouton == "btn_validation"){ // A COMPLETER : VERIFIER LES ISSET + GERER CHAMPS SUPPLEMENTAIRES
    	$nom_root = $_POST['nom_root'];  // nom général de l'arbre
	    $nom_sphere_1 = $_POST['nom_sphere_1'];  // nom de la table 1
	    $id_sphere_1 = $_POST['id_sphere_1'];  // champ id de la table 1
	    $titre_sphere_1 = $_POST['titre_sphere_1']; // champ titre de la table 1
	    $nom_sphere_2 = $_POST['nom_sphere_2']; // nom de la table 2
	    $id_sphere_2 = $_POST['id_sphere_2']; // champ id de la table 2
	    $titre_sphere_2 = $_POST['titre_sphere_2']; // champ titre de la table 2
	    $nom_sphere_3 = $_POST['nom_sphere_3']; // nom de la table 3
	    $id_sphere_3 = $_POST['id_sphere_3']; // champ id de la table 3
	    $titre_sphere_3 = $_POST['titre_sphere_3']; // champ titre de la table 3
	    $nom_sphere_4 = $_POST['nom_sphere_4']; // nom de la table 4
	    $id_sphere_4 = $_POST['id_sphere_4']; // champ id de la table 4
	    $titre_sphere_4 = $_POST['titre_sphere_4']; // champ titre de la table 4
	    $nom_relation_2 = $_POST['nom_relation_2'];  // relation n..n
	    $id1_relation_2 = $_POST['id1_relation_2']; // relation n..n
	    $id2_relation_2 = $_POST['id2_relation_2']; // relation n..n
	    $id_relation_2 = $_POST['id_relation_2'];   // relation 1..n
	    $nom_relation_3 = $_POST['nom_relation_3']; // relation n..n
	    $id1_relation_3 = $_POST['id1_relation_3']; // relation n..n
	    $id2_relation_3 = $_POST['id2_relation_3']; // relation n..n
	    $id_relation_3 = $_POST['id_relation_3']; // relation 1..n
	    $nom_relation_4 = $_POST['nom_relation_4']; // relation n..n
	    $id1_relation_4 = $_POST['id1_relation_4']; // relation n..n
	    $id2_relation_4 = $_POST['id2_relation_4']; // relation n..n
	    $id_relation_4 = $_POST['id_relation_4']; // relation 1..n
	    $nb_niveau = $_POST['nombre_niveau'];
	}
}
  

if(!isset($erreur)){
  	try { // Connexion à la base. Pb : connexion à une base externe impossible
	    $ma_connexion = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$pswd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    if($bouton == "btn_connexion"){
	    	echo "Success";
	    }
  	}
    catch(Exception $e){
	    echo 'Erreur : '.$e->getMessage().'<br />';
	    echo 'N° : '.$e->getCode();
  	}


// CREATION DU JSON A PARTIR DES REQUETES SUR LA BASE : A RETRAVAILLER POUR PRENDRE EN COMPTE LES DIFFERENTS CAS DE MULTIPLICITES + AJOUTS CHAMPS SUPPL SUR LES FEUILLES + FAIRE BOUCLE POUR GERER LES DIFFERENTS NIVEAUX (profondeur du JSON)
    if($bouton == "btn_validation") {
    	if($nb_niveau==3){ // CREATION D'UN JSON A 3 NIVEAUX (avec cardinalités max (1..n) entre niveau 1 et 2 puis (n..n) entre niveau 2 et 3)
  
	// Recup liste de la sphère de niveau 1
		$sqlci = "SELECT ".$titre_sphere_1.",".$id_sphere_1."
		            FROM ".$nom_sphere_1."
		            WHERE ".$titre_sphere_1." != ''";
	    $rsci = $ma_connexion->prepare($sqlci);
	    $rsci->execute() or die ("Erreur : ".__LINE__." : ".$sqlci);
	    $nbci = $rsci->rowCount();
	    if ($nbci) {

	    // Début arbre parent
	    $aff =
	        "{
	         \"name\": \"".$nom_root."\",
	         \"children\": [";
	    while ($c = $rsci->fetch(PDO::FETCH_ASSOC))
	    {
	      // Nouvelle entrée de niveau 1
	      if (isset($aff_ci)) $aff_ci .= ",";
	      if(!isset($aff_ci)) $aff_ci = "";
	      $aff_ci .= "\n{
	        \"name\": \"".$c[$titre_sphere_1]."\",
	        \"children\": [";

	      // Recup liste des infos sphère niveau 2 
	      $sqlru = "SELECT ".$titre_sphere_2.",".$id_sphere_2."
	                FROM ".$nom_sphere_2."
	                WHERE ".$titre_sphere_2." != ''
	                AND ".$id_relation_2." = ".$c[$id_sphere_1];  
	      $rsru = $ma_connexion->prepare($sqlru);
	      $rsru->execute() or die ("Erreur : ".__LINE__." : ".$sqlru);
	      $nb_rub = $rsru->rowCount();
	      if ($nb_rub) {
	        while ($ru = $rsru->fetch(PDO::FETCH_ASSOC))
	        {
	          // Nouvelle entrée de niveau 2
	          if (isset($aff_ru)) $aff_ru .= ",";
	          if(!isset($aff_ru)) $aff_ru = "";
	          $aff_ru .= "\n{
	            \"name\": \"".$ru[$titre_sphere_2]."\",
	            \"children\": [";

	            // Recup liste des infos sphère niveau 3 (feuille)
	            // Compléter requete avec champs supplémentaires
	            $sqlact = "SELECT ".$titre_sphere_3.",".$id_sphere_3."
	                      FROM  ".$nom_sphere_3." I,
	                            ".$nom_relation_3." L
	                      WHERE I.afficher > 0 
	                        AND L.".$id1_relation_3." = ".$ru[$id_sphere_2]."
	                        AND I.".$titre_sphere_3." != ''
	                        AND I.".$id_sphere_3." = L.".$id2_relation_3;
	            $rsact = $ma_connexion->prepare($sqlact);
	            $rsact->execute() or die ("Erreur : ".__LINE__." : ".$sqlact);
	            $nb_actions = $rsact->rowCount();
	            if ($nb_actions) {
	              while ($ra = $rsact->fetch(PDO::FETCH_ASSOC))
	              {
	                // Nouvelle feuille
	                // A Compléter avec champs supplémentaires
	                if (isset($aff_ac)) $aff_ac .= ",";
	                if(!isset($aff_ac)) $aff_ac = "";
	                $size = strlen($ra[$titre_sphere_3])*strlen($ra[$titre_sphere_3]); // à remplacer par importance du projet (échelle de 1 à 5 par ex)
	                $aff_ac .= "\n{
	                  \"name\": \"".$ra[$titre_sphere_3]."\",
	                  \"size\": ". $size.",
	                  \"url\": \"fiche_action.php?id=".$ra[$id_sphere_3]."\"}";
	              }
	              $aff_ru .= $aff_ac;
	              unset($aff_ac);
	            }
	          $aff_ru .= "\n]}";
	        }
	        $aff_ci .= $aff_ru;
	        unset($aff_ru);
	      } // nb_rub
	      $aff_ci .= "\n]}";
	    }
	    $aff .= $aff_ci;
	    $aff .= "\n]}";    // Fin arbre parent
	  } // nbci
	  echo $aff;
	}

	else if($nb_niveau==2){ // CREATION D'UN JSON A 2 NIVEAUX (avec cardinalités max (n..n) entre niveau 1 et 2)
		$sqlci = "SELECT ".$titre_sphere_1.",".$id_sphere_1."
		            FROM ".$nom_sphere_1."
		            WHERE ".$titre_sphere_1." != ''";
	    $rsci = $ma_connexion->prepare($sqlci);
	    $rsci->execute() or die ("Erreur : ".__LINE__." : ".$sqlci);
	    $nbci = $rsci->rowCount();
	    if ($nbci) {

	    // Début arbre parent
	    $aff =
	        "{
	         \"name\": \"".$nom_root."\",
	         \"children\": [";
	    while ($c = $rsci->fetch(PDO::FETCH_ASSOC))
	    {
	      // Nouvelle entrée de niveau 1
	      if (isset($aff_ci)) $aff_ci .= ",";
	      if(!isset($aff_ci)) $aff_ci = "";
	      $aff_ci .= "\n{
	        \"name\": \"".$c[$titre_sphere_1]."\",
	        \"children\": [";

	      // Recup liste des infos sphère niveau 2 
	      $sqlru = "SELECT ".$titre_sphere_2.",".$id_sphere_2."
	                FROM ".$nom_sphere_2."
	                WHERE ".$titre_sphere_2." != ''
	                AND ".$id_relation_2." = ".$c[$id_sphere_1];  
	      $rsru = $ma_connexion->prepare($sqlru);
	      $rsru->execute() or die ("Erreur : ".__LINE__." : ".$sqlru);
	      $nb_rub = $rsru->rowCount();
	      if ($nb_rub) {
	        while ($ru = $rsru->fetch(PDO::FETCH_ASSOC))
	        {
	          // Nouvelle entrée de niveau 2
	          if (isset($aff_ru)) $aff_ru .= ",";
	          if(!isset($aff_ru)) $aff_ru = "";
	          $aff_ru .= "\n{
	            \"name\": \"".$ru[$titre_sphere_2]."\"";
	          $aff_ru .= "\n}";
	        }
	        $aff_ci .= $aff_ru;
	        unset($aff_ru);
	      } // nb_rub
	      $aff_ci .= "\n]}";
	    }
	    $aff .= $aff_ci;
	    $aff .= "\n]}";    // Fin arbre parent
	  } // nbci
	  echo $aff;

	}
	else if($nb_niveau==4){ // CREATION D'UN JSON A 2 NIVEAUX 

	}

  }
}
?>