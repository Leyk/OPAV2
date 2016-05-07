<?php
// Affiche la liste des actions

$limit = 1000;

require_once "inc/_var_fv.php";

// Page rechargée ?
if(isset($_GET['reload'])){
  $reload             = intval($_GET['reload']);
}
if(isset($_GET['statut'])){
  $statut_selectionne = preg_replace("/[^a-z\s]/i",'', strtolower($_GET["statut"]));
} else {
  $statut_selectionne = "developper";
}


echo '<dl class="tabs" data-tab>
  <dd'.($statut_selectionne=="partager"?" class='active'":"").'><a href="#partager">Eco-passeurs</a></dd>
  <dd'.($statut_selectionne=="importOPA"?" class='active'":"").'><a href="#importOPA">Initiatives OPA</a></dd>
  <dd'.($statut_selectionne=="developper"||$statut_selectionne=="idee"?" class='active'":"").'><a href="#developper">Labo</a></dd>
</dl>';

echo '<div class="tabs-content">';
  
  echo '<div class="'.($statut_selectionne=="partager"?"active ":"").'content" id="partager">';
  echo afficheActions("partager", $limit);
  echo "</div>";

  echo '<div class="'.($statut_selectionne=="partager"?"active ":"").'content" id="importOPA">';
  echo afficheActions("importOPA", $limit);
  echo "</div>";

  echo '<div class="'.($statut_selectionne=="developper"||$statut_selectionne=="idee"?"active ":"").'content" id="developper">';
  echo afficheActions("developper+idee", $limit);
  echo "</div>";

echo "</div>";

if (isset($reload))
  echo "<script>$('#les-actions').foundation('reflow'); </script>";
?>

<div id="lghtbox" class="hide reveal-modal medium" data-reveal></div>