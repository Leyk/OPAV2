<?php
// Affiche la liste des actions
$limit = 10;

require_once "inc/_var_fv.php";

$id = intval($_GET["id"]);

$sql = "SELECT * 
          FROM actions_initiatives 
          WHERE afficher > 0 
            AND id = :id
            AND initiative_titre != ''
          LIMIT 0,1";
$rs = $connexion->prepare($sql);

$rs->execute(array(':id' => $id)) or die ("Erreur : ".__LINE__." : ".$sql);
$nb_actions = $rs->rowCount();
if ($nb_actions) {
  while ($r = $rs->fetch(PDO::FETCH_ASSOC))
  {
    if (!empty($r["initiative_titre"]))
      echo "<h2>".$r["initiative_titre"]."</h2>";

    echo "<div class='row'>";
      echo "<div class='large-12 columns'>";

        $dateajout = datefr($r["dateheure_ajout"],$avecheure=true);

        // statut
        switch ($r["initiative_statut"]) {
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
        if ($r["dateheure_ajout"] != "0000-00-00 00:00:00")
          echo " posté(e) le ".$dateajout;

          // récupération des rubriques associées
          $sqlrub = "SELECT titre, id_centreinteret
                    FROM actions_initiatives_rubriques I, actions_rubriques R
                    WHERE I.id_rubrique = R.id
                      AND id_initiative = :id
                    LIMIT 0,10";
          $rsrub = $connexion->prepare($sqlrub);
          $rsrub->execute(array(':id' => $id)) or die ("Erreur : ".__LINE__." : ".$sqlrub);
          $nbrub = $rsrub->rowCount();
          if ($nbrub) {
            while ($u = $rsrub->fetch(PDO::FETCH_ASSOC))
            {
              if (!isset($rubriques)){
                  $rubriques = "";
                }
              if (!isset($i))
                $rubriques .= "<br/>Rubrique".($nbrub>1?"s":"")." : ";
              else{
                $rubriques .= ", ";
                $i++;
              }
              $rubriques .= $u["titre"];

              // récupération des centre d'intérêt associés
              $ce_centresinteret = nom_centreinteret($u["id_centreinteret"]);
              if (!isset($centresinteret,$ce_centresinteret))
              {
                if (!isset($centresinteret))
                  $centresinteret = "<br/>Centre d'intérêt : ";
                else
                  $centresinteret .= ", ";                
  
                $centresinteret .= $ce_centresinteret;
              }
              
          }
          } // nbrub

          echo $rubriques;
          echo $centresinteret;
  
        echo "</div>";


        if (!empty($r["initiative_description"]))
          echo "<p>".$r["initiative_description"]."</p>";

        if (!empty($r["initiative_motivation"]))
          echo "<p><strong>Quelles sont vos motivations ?</strong><br/>".$r["initiative_motivation"]."</p>";
        if (!empty($r["initiative_besoins"]))
          echo "<p><strong>Quelles sont vos besoins actuels ?</strong><br/>".$r["initiative_besoins"]."</p>";
        if (!empty($r["journee_demande"]))
          echo "<p><strong>Quels sont vos besoins, votre demande pour aujourd'hui ?</strong><br/>".$r["journee_demande"]."</p>";

      echo "</div>"; // div coll
      echo "</div>";

      if ((!empty($r["posteur_nom"])) || (!empty($r["posteur_email"])) || (!empty($r["posteur_siteweb"])) || (!empty($r["posteur_coordonnees"]))){
        echo "<div class='row'>";
        echo "<div id='coordonnees' class='large-12 columns callout panel'>";
      }
        if (!empty($r["posteur_nom"]))
          echo "<strong>Coordonnées de l'initiateur :</strong><br/>".$r["posteur_nom"]."<br/>";
        if (!empty($r["posteur_email"]))
          $mail_initiateur = $r["posteur_email"];
          echo "<a href='mailto:".$r["posteur_email"]."'>".$r["posteur_email"]."</a><br/>";
        if (!empty($r["posteur_siteweb"]))
          echo "<strong>Site : </strong><a href='".(stristr($r["posteur_siteweb"],'http://')?"":"http://").$r["posteur_siteweb"]."' target='_blank'>".$r["posteur_siteweb"]."</a><br/>";
        if (!empty($r["posteur_coordonnees"]))
          echo "<p>".$r["posteur_coordonnees"]."</p>";

      if ((!empty($r["posteur_nom"])) || (!empty($r["posteur_email"])) || (!empty($r["posteur_siteweb"])) || (!empty($r["posteur_coordonnees"])))
        echo "</div>";
        echo "</div>";
    //echo "</div>"; // div row
  }
}

require_once("form_contact.php");

?>


