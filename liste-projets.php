<?php
  require_once "inc/_var_fv.php";
  include_once ("vues/entete.php");
  include_once ("vues/menu.php");
?>   
  <body>
    <section class="row contenu">

      <div class="large-12 medium-12 columns">         
        <h5>Les idées</h5>

				<div id="les-actions">
        	<?php include "labo_affiche_actions.php"; ?>
        </div>
      </div>

    </section>
  </body>
  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>
  <script src="js/foundation/foundation.reveal.js"></script>
  <script src="js/jquery.autosize.min.js"></script>

<?php include_once("vues/foot.php"); ?>
