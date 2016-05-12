<?php
// Affiche la liste des actions
$limit = 10;

require_once "inc/_var_fv.php";

$id = intval($_GET["id"]);
$infosAction = $pdo->getInfosActions($id);  // Récupération de toutes les données relatives à une action

if(is_array($infosAction)){
  if (!empty($infosAction["initiative_titre"])){
    echo "<h2>".$infosAction["initiative_titre"]."</h2>";
  }

  echo "<div class='row'>";
    echo "<div class='large-12 columns'>";

      $dateajout = datefr($infosAction["dateheure_ajout"],$avecheure=true);

      // statut
      switch ($infosAction["initiative_statut"]) {
        case 'idee':
            echo "<div class='panel callout'>Idée d'action";
          break;
        case 'importOPA':
            echo "<div class='panel callout'>Initiative importée du site <a href='http://www.onpassealacte.fr' target='_blank'>www.onpassealacte.fr</a>";
          break;
        case 'partager':
            echo "<div class='panel callout'>Partage d'expérience";
          break;
        case 'developper':
            echo "<div class='panel callout'>Action en cours, à développer";
          break;
      }
      if ($infosAction["dateheure_ajout"] != "0000-00-00 00:00:00"){
        echo " posté(e) le ".$dateajout;
      }

      // récupération des rubriques associées
      $rubAction = $pdo->getRubAction($id);
      if (is_array($rubAction)) {
        foreach($rubAction as $u){
          if (!isset($rubriques)){
              $rubriques = "";
          }
          if (!isset($i)){
            $rubriques .= "<br/>Rubrique(s)";
          }
          else{
            $rubriques .= ", ";
            $i++;
          }
          $rubriques .= $u["titre"];

          // récupération des centre d'intérêt associés
          $ce_centresinteret = nom_centreinteret($u["id_centreinteret"]);
          if (!isset($centresinteret,$ce_centresinteret)) {
            if (!isset($centresinteret)){
              $centresinteret = "<br/>Centre d'intérêt : ";
            }
            else {
              $centresinteret .= ", ";                
            }
            $centresinteret .= $ce_centresinteret;
          }
          
        }
      } 

      echo $rubriques;
      echo $centresinteret;

    echo "</div>";


    if (!empty($infosAction["initiative_description"]))
      echo "<p>".$infosAction["initiative_description"]."</p>";

    if (!empty($infosAction["initiative_motivation"]))
      echo "<p><strong>Quelles sont vos motivations ?</strong><br/>".$infosAction["initiative_motivation"]."</p>";
    if (!empty($infosAction["initiative_besoins"]))
      echo "<p><strong>Quelles sont vos besoins actuels ?</strong><br/>".$infosAction["initiative_besoins"]."</p>";
    if (!empty($infosAction["journee_demande"]))
      echo "<p><strong>Quels sont vos besoins, votre demande pour aujourd'hui ?</strong><br/>".$infosAction["journee_demande"]."</p>";

  echo "</div>"; // div coll
  echo "</div>";

  if ((!empty($infosAction["posteur_nom"])) || (!empty($infosAction["posteur_email"])) || (!empty($infosAction["posteur_siteweb"])) || (!empty($infosAction["posteur_coordonnees"]))){
    echo "<div class='row'>";
    echo "<div id='coordonnees' class='large-12 columns callout panel'>";
  }
    if (!empty($infosAction["posteur_nom"]))
      echo "<strong>Coordonnées de l'initiateur :</strong><br/>".$infosAction["posteur_nom"]."<br/>";
    if (!empty($infosAction["posteur_email"]))
      $mail_initiateur = $infosAction["posteur_email"];
      echo "<a href='mailto:".$infosAction["posteur_email"]."'>".$infosAction["posteur_email"]."</a><br/>";
    if (!empty($infosAction["posteur_siteweb"]))
      echo "<strong>Site : </strong><a href='".(stristr($infosAction["posteur_siteweb"],'http://')?"":"http://").$infosAction["posteur_siteweb"]."' target='_blank'>".$infosAction["posteur_siteweb"]."</a><br/>";
    if (!empty($infosAction["posteur_coordonnees"]))
      echo "<p>".$infosAction["posteur_coordonnees"]."</p>";

  if ((!empty($infosAction["posteur_nom"])) || (!empty($infosAction["posteur_email"])) || (!empty($infosAction["posteur_siteweb"])) || (!empty($infosAction["posteur_coordonnees"])))
    echo "</div>";
    echo "</div>";
}

require_once("form_contact.php");

?>


