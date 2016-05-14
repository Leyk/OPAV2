<?php

function affiche_tree()
{ 
  global $connexion;
  global $pdo;

  // Recup liste des centres d'intérêt
  $les_ci = $pdo->getCentreInteret();
  if (is_array($les_ci)) {

    // Début arbre parent
    $aff = "var root = 
        {
         \"name\": \"forcesvives\",
         \"children\": [";
    foreach ($les_ci as $c)
    {
      // Nouveau centre d'intérêt
      if (isset($aff_ci)) $aff_ci .= ",";
      if(!isset($aff_ci)) $aff_ci = "";
      $aff_ci .= "\n{
        \"name\": \"".$c["titre"]."\",
        \"children\": [";

      // Recup liste des rubriques de ce centre d'intérêt
      $les_rub = $pdo->getRubriqueCI($c["id"]);
      if (is_array($les_rub)) {
        foreach ($les_rub as $ru)
        {
          // Nouvelle rubrique
          if (isset($aff_ru)) $aff_ru .= ",";
          if(!isset($aff_ru)) $aff_ru = "";
          $aff_ru .= "\n{
            \"name\": \"".$ru["titre"]."\",
            \"children\": [";

            // Recup liste des actions de cette rub

            $sqlact = "SELECT initiative_titre,id
                      FROM  actions_initiatives I,
                            actions_initiatives_rubriques L
                      WHERE I.afficher > 0 
                        AND L.id_rubrique = ".$ru["id"]."
                        AND I.initiative_titre != ''
                        AND I.id = L.id_initiative";
            $rsact = $connexion->prepare($sqlact);
            $rsact->execute() or die ("Erreur : ".__LINE__." : ".$sqlact);
            $nb_actions = $rsact->rowCount();
            if ($nb_actions) {
              while ($ra = $rsact->fetch(PDO::FETCH_ASSOC))
              {
                // Nouvelle action
                if (isset($aff_ac)) $aff_ac .= ",";
                if(!isset($aff_ac)) $aff_ac = "";
                $size = strlen($ra["initiative_titre"])*strlen($ra["initiative_titre"]); // à remplacer par importance du projet (échelle de 1 à 5 par ex)
                $aff_ac .= "\n{
                  \"name\": \"".$ra["initiative_titre"]."\",
                  \"size\": ". $size.",
                  \"url\": \"fiche_action.php?id=".$ra["id"]."\"}";
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
    $aff .= "\n]};";    // Fin arbre parent
  } // nbci

  return $aff;
}

?>