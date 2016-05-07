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

        <h5>A vous !</h5>
        
        <div data-alert id="messager" class="hide">
          <a href="#" class="close">&times;</a>
        </div>

        <form action="labo_ajout_action.php" method="post" id="formaction" >

          <div id="formaction-intro" class="row">
            <div class="large-12 columns">
              <select name="initiative_statut" id="initiative_statut">
                <option value="">Qui êtes vous ?</option>
                <option value="idee">Je suis un citoyen et j'ai une petite idée d'action...</option>
                <option value="developper">J'ai initié une action et je veux développer mon projet</option>
                <option value="partager">J'ai agi et je partage mon expérience</option>
              </select>
            </div>
          </div>

          <div id="formaction-contenu" class="row hide">
            <div class="large-12 columns">
          <fieldset>
            <legend>Vous contacter</legend> 
            <input type="text" id="posteur_nom" name="posteur_nom" placeholder="Votre nom">
            <input type="text" id="posteur_email" name="posteur_email" placeholder="Votre courriel *">
            <div class="row collapse">
              <div class="small-3 large-2 columns">
                <span class="prefix">http://</span>
              </div>
              <div class="small-9 large-10 columns">
                <input type="text" id="posteur_siteweb" name="posteur_siteweb" placeholder="Votre site internet">
              </div>
            </div>
            <textarea name="posteur_coordonnees" placeholder="Vos cordonnées"></textarea>
          </fieldset>

          <fieldset>
            <legend>Votre initiative</legend>
              <input type="text" name="initiative_titre" id="initiative_titre" placeholder="Titre de votre initiative *">
              <?php
                echo affiche_rubriques($selected="",$typeliste="select",$description="Quel est votre centre d'intérêt principal ?");
              ?>
              <label>Décrivez votre initiative :</label>
              <textarea name="initiative_description"></textarea>
              <label>Quelles sont vos motivations :</label>
              <textarea name="initiative_motivation"></textarea>
              <label>Quelles sont vos besoins actuels :</label>
              <textarea name="initiative_besoins"></textarea>
          </fieldset>

          <fieldset>
            <legend>Pour aujourd'hui ?</legend>
              <label>Quels sont vos besoins, votre demande pour aujourd'hui :</label>
              <textarea name="journee_demande"></textarea>
                <label>Souhaitez-vous que cette demande soit :</label>
                <input name="journee_a_crier" type="checkbox" value="1"><label for="journee_a_crier">Criée (crieur public)</label>
                <input name="journee_a_tourner" type="checkbox" value="1"><label for="journee_a_tourner">Tournée (vidéo)</label>
          </fieldset>

          <div class="row">
            <div class="large-12 text-center">
              <button type="submit">Publier</button>          
            </div>
          </div>

          </div></div> <!-- formaction-contenu -->

  			</form>
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

        $('header .logo').animate({ letterSpacing: '10px' }, 500);
        setTimeout(function() { $('header .logo').removeAttr("style"); }, 1000);

        // Ajuster la taille des textarea
        $('textarea').autosize(); 

        // affichage du formulaire
        $('#initiative_statut').change(function() {

          $('html, body').animate({
              scrollTop: $("#formaction").offset().top
          }, 1000);

          if ($(this).val()==="")
            $('#formaction-contenu').slideUp();
          else
            $('#formaction-contenu').slideDown();
        });

        // Lorsque je soumets le formulaire
        $('#formaction').on('submit', function(e) {

          e.preventDefault();
          var $this = $(this);
          var initiative_titre = $('#initiative_titre').val();
          var mail = $('#mail').val();

          // scroll sur les actions
          $('html, body').animate({
              scrollTop: $("#les-actions").offset().top
          }, 1000);

          if(initiative_titre === '' || mail === '') {
              $('#messager').removeClass().addClass("alert-box radius").addClass("alert").html("Les champs marqués * doivent êtres remplis.").slideDown().delay(3000).slideUp();
          } else {
              $.ajax({
                  url: $this.attr('action'),
                  type: $this.attr('method'),
                  data: $this.serialize(),
                  success: function(retour) {
                      // prépare la div pour message retour
                      $('#messager').removeClass().addClass("alert-box radius");
                      
                      if (retour=="1")
                      {
                        // affiche le message
                        $('#messager').addClass("success").html("Votre initiative a été insérée avec succès.").slideDown().delay(3000).slideUp();

                        // enregistre le statut
                        var initiative_statut = $('#initiative_statut').val();

                        // vide le form
                        $(':input','#formaction')
                         .not(':button, :submit, :reset, :hidden')
                         .val('')
                         .removeAttr('checked')
                         .removeAttr('selected');
                        $('#les-actions').slideUp().load("labo_affiche_actions.php?reload=1&statut="+initiative_statut).slideDown();
                        $('#formaction-contenu').slideUp();
                      }
                      else 
                      {
                        $('#messager').addClass("alert").html(retour).slideDown().delay(3000).slideUp();
                      }
                  }
              });
          }
        });
      });      
    </script>
  </body>
</html>
