<?php

/** Affiche la liste des actions
------------------------------------------------------------------------ 
 *  Entrée : string $statut : Statut des actions à ramener
             string $limit  : Nombre d'actions à ramener
 *  Sortie : string $ret : chaine prête à afficher
------------------------------------------------------------------------ 
 */
function afficheActions($statut="",$limit=1)
{
  global $pdo;
  $statut = explode("+", $statut);
  $where_statut = "( initiative_statut = '".$statut[0]."'";
  for($i=1;$i<count($where_statut);$i++) {
    $where_statut .= " OR initiative_statut = '".$statut[$i]."'";
  }
  $where_statut .= ")";
  $les_actions = $pdo->affichageActions($where_statut, $limit);
  if (is_array($les_actions)) {
    $ret = "<ul>";
    foreach ($les_actions as $r)
    {
      $ret .= "
      <li><a href='fiche_action.php?id=".$r["id"]."' data-reveal-id='lghtbox' data-reveal-ajax='true'>
        ".$r["initiative_titre"]."
      </a></li>";
    }
  }
  else $ret = "Aucune action dans cette rubrique.";

  return $ret;
}

/** Affiche la liste des rubriques
------------------------------------------------------------------------ 
 *  Entrée : string $selected : rubrique selectionnée
             string $typeliste : Type d'affichage demandé
             string $description : Phrase à afficher comme description du select (option à NULL)
 *  Sortie : string $aff : chaine prête à afficher
------------------------------------------------------------------------ 
 */
function affiche_rubriques($selected="",$typeliste="ul",$description="")
{ 
  global $pdo;
  $les_rubriques = $pdo->affichageRubriques();
  if (is_array($les_rubriques)) {
    if(!isset($aff)){
      $aff = "";
    }
    if ($typeliste == 'select') 
    {
      $aff .= "<select name='liste_rubriques' id='liste_rubriques'>";
      if ($description) $aff .= "<option value=''>".$description."</option>";
        else  $aff .= "<option value=''>Choisissez une rubrique</option>";
    }
    elseif ($typeliste == 'ul') $aff .= "<ul id='liste_rubriques'>";

    foreach ($les_rubriques as $r)
    {
      if ($typeliste == 'select')
      {
          if(!isset($ancien_id_centreinteret)){
        $ancien_id_centreinteret = "";
      }
        if ($r["id_centreinteret"] != $ancien_id_centreinteret)
        {
          if ($ancien_id_centreinteret) $aff .= "</optgroup>"; // Pas le premier
          $aff .= "<optgroup label='".nom_centreinteret($r["id_centreinteret"])."'>";
        }
        // rubrique sélectionnée ?
        if ($selected == $r["titre"])
          $aff .= "<option selected value='".$r["id"]."'>".$r["titre"]."</option>";
        else
          $aff .= "<option value='".$r["id"]."'>".$r["titre"]."</option>";          
      }
      elseif ($typeliste == 'ul') 
        $aff .= "<li>".$r["titre"]."</li>";

      $ancien_id_centreinteret = $r["id_centreinteret"];
    }
    if ($typeliste == 'select') $aff .= "</optgroup></select>";
    elseif ($typeliste == 'ul') $aff .= "</ul>";
  }

  return $aff;
}

/** Affiche l'arborescence sur la carte
------------------------------------------------------------------------ 
 *  Entrée : 
 *  Sortie : string $aff : chaine prête à afficher
------------------------------------------------------------------------ 
 */
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

/** Affiche le nom d'un centre d'intérêt
------------------------------------------------------------------------ 
 *  Entrée : string $id : id à ramener
 *  Sortie : string $aff : nom du centre d'intéret prêt à être afficher
------------------------------------------------------------------------ 
 */
function nom_centreinteret($id="")
{ 
  global $pdo;
  $id = intval($id);
  $les_ci = $pdo->getNomCentreInteret($id);
  if (is_array($les_ci)) {
    foreach ($les_ci as $c)
    {
      $aff = $c["titre"];
    }
  } 
  return $aff;
}

?>