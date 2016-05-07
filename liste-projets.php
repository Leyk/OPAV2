<?php
  require_once "inc/_var_fv.php";
?>
<!doctype html>
<html class="no-js" lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Outil de mise en synergie</title>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/fv.css" />
    <link rel="stylesheet" href="css/foundation-icons.css" />

  </head>
  <body>
    
    <header>
      <div class="row">
        <div class="large-12 columns">
          <h2>Un outil de</h2>
          <h1 class="logo">Mise en <span>Synergie</span></h1>
        </div>
      </div>
      <div id="menu" class="row">
        <div class="large-12 columns">
          <a href="index.php" title="Constellation">Constellation</a> | 
          <a href="inscrivez-vous.php" title="Inscrivez-vous">Inscrivez-vous</a> | 
          <a href="liste-projets.php" title="Liste des projets">Liste des projets</a>
        </div>
      </div>
    </header>
    
    <section class="row contenu">

      <div class="large-12 medium-12 columns">         
        <h5>Les idées</h5>

				<div id="les-actions">
        	<?php include "labo_affiche_actions.php"; ?>
        </div>
      </div>

    </section>

    
    <footer>
      <div class="row">
        <div class="large-12 columns">
          <h1 class="logo">Forces<span>Vives</span></h1>
        </div>
      </div>
    </footer>


    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/foundation/foundation.reveal.js"></script>
    <script src="js/jquery.autosize.min.js"></script>

    <script>
      $(document).foundation();

      $(function() {

        $("#boutonactions").click(function() {
          $("#interactions").slideToggle();
        });

        $('header .logo').animate({ letterSpacing: '10px' }, 500);
        setTimeout(function() { $('header .logo').removeAttr("style"); }, 1000);

      });      
    </script>
  </body>
</html>
