<?php
/*
  2 posteur_nom varchar(255) 
  3 posteur_email varchar(255) 
  4 posteur_coordonnees text 
  5 initiative_statut varchar(15)
  initiative_titre
  6 initiative_description  text 
  7 initiative_motivation text 
  8 initiative_besoins  text 
  9 journee_demande text 
  10  journee_a_crier tinyint(1)
  11  journee_a_tourner tinyint(1)
  12  dateheure_modif timestamp  
  13  dateheure_ajout timestamp
  afficher
*/

function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);
    return $value;
}

// supprime les /
$_POST = stripslashes_deep($_POST);

include "inc/_var_fv.php";

// Sécurisation des variables d'entrées
$posteur_nom = preg_replace("/[^a-zA-Z ._-\s]/i",'', strtolower($_POST["posteur_nom"])); // ajouter les accents
$posteur_email = preg_replace("/[^a-z].-_@/i",'', strtolower($_POST["posteur_email"]));
if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $posteur_email))
{
  $erreur = true;
  $erreurmsg = "Adresse email invalide.";  
}
$posteur_siteweb = $_POST["posteur_siteweb"];

$posteur_coordonnees = $_POST["posteur_coordonnees"];
$initiative_titre = $_POST["initiative_titre"];
$initiative_statut = preg_replace("/[^a-z\s]/i",'', strtolower($_POST["initiative_statut"]));

$initiative_description = $_POST["initiative_description"];
$initiative_motivation = $_POST["initiative_motivation"];
$initiative_besoins = $_POST["initiative_besoins"];
$journee_demande = $_POST["journee_demande"];
$afficher = 1;

$rubrique = intval($_POST["liste_rubriques"]);

if (isset($_POST['journee_a_crier']) && $_POST['journee_a_crier'] == '1') 
  $journee_a_crier = 1;
else
  $journee_a_crier = 0;
if (isset($_POST['journee_a_tourner']) && $_POST['journee_a_tourner'] == '1') 
  $journee_a_tourner = 1;
else
  $journee_a_tourner = 0;

// Champs obligatoires : 
if (empty($initiative_titre)) $erreur = true;

if (!$erreur)
{
  $sql = "INSERT INTO actions_initiatives VALUES (
    '',
    :posteur_nom, 
    :posteur_email,
    :posteur_siteweb,
    :posteur_coordonnees, 
    :initiative_statut, 
    :initiative_titre, 
    :initiative_description, 
    :initiative_motivation, 
    :initiative_besoins, 
    :journee_demande, 
    :journee_a_crier, 
    :journee_a_tourner, 
    CURRENT_TIMESTAMP, 
    NOW(), 
    :afficher
    )";

  $valeurs = array(
    ':posteur_nom' => $posteur_nom,
    ':posteur_email' => $posteur_email,
    ':posteur_siteweb' => $posteur_siteweb,
    ':posteur_coordonnees' => $posteur_coordonnees,
    ':initiative_statut' => $initiative_statut,
    ':initiative_titre' => $initiative_titre,
    ':initiative_description' => $initiative_description,
    ':initiative_motivation' => $initiative_motivation,
    ':initiative_besoins' => $initiative_besoins,
    ':journee_demande' => $journee_demande,
    ':journee_a_crier' => $journee_a_crier,
    ':journee_a_tourner' => $journee_a_tourner,
    ':afficher' => $afficher
  );
  // print_r($valeurs);
  $rs = $connexion->prepare($sql);
  $sqlok = $rs->execute($valeurs) or die ("Erreur ".__LINE__.$sql);

  $id_action = $connexion->lastInsertId();

  if ($sqlok && $rubrique)
  {
    $sqlrub = "INSERT INTO actions_initiatives_rubriques VALUES (
      :id_action, 
      :rubrique
    )";

    $valeursrub = array(
      ':id_action' => $id_action,
      ':rubrique' => $rubrique
    );
    // print_r($valeursrub);
    $rsrub = $connexion->prepare($sqlrub);
    $sqlok = $rsrub->execute($valeursrub) or die ("Erreur ".__LINE__.$sqlrub);
  }

}

if ($sqlok)
  echo "1";
elseif ($erreur)
{
  echo "Erreur dans l'ajout de votre initiative.";
  if ($erreurmsg)
    echo " ".$erreurmsg;
  else
    echo " Les champs marqués * sont obligatoires.";
} else
  echo "Erreur dans l'ajout de votre initiative.";
?>