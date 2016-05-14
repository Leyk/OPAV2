<?php

unset($erreur);

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
  echo "ok !";
}
else {
  $erreur = true;
  echo "Erreur";
}


/*try
{
    $connexion = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$pswd, array(
       PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(Exception $e)
{
    echo 'Erreur : '.$e->getMessage().'<br />';
    echo 'N° : '.$e->getCode();
}*/



?>