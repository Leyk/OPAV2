<?php
  require_once "_var_fv.php";

  $id_initiative = intval($_GET['id_initiative']);

  $sql = "SELECT initiative_titre
            FROM  actions_initiatives I
            WHERE I.afficher > 0 
              AND I.initiative_titre != ''
              AND I.id = :id_initiative";
  $rs = $connexion->prepare($sql);
  $rs->execute(array(':id_initiative' => $id_initiative)) or die ("Erreur : ".__LINE__." : ".$sql);
  $nb_actions = $rs->rowCount();
  if ($nb_actions) {
    while ($r = $rs->fetch(PDO::FETCH_ASSOC))
    {
      $aff = $r["initiative_titre"];
    }
  }


 echo $aff;

?>