<?php

unset($erreur);

if(isset($_POST['bouton'])){
  $bouton = $_POST['bouton'];
}
else {
  $erreur = true;
}

if(!isset($erreur)){
  if ($bouton == "btn_connexion"){
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

    if(!isset($erreur)){
      try {
        $connexion = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$pswd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        echo "Success";
      }
      catch(Exception $e){
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
      }
    }
  }
  else if($bouton == "btn_validation") {
    echo "cool";

  }
}



?>