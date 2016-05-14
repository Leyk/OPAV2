<?php
include_once ("vues/entete.php");
include_once ("vues/menu.php");
?>

<body>
 <section class="row contenu">
      <div class="large-12 medium-12 columns">

        <h5>A votre tour de créer votre Constellation !</h5><br/>
        <div id="erreur">
        </div>
        <div id="resultat">
        </div>
        <form id="formgene" >
          <div id="formgene-intro" class="row">
            <div class="large-12 columns">
              <select name="type_bd" id="type_bd">
                <option value="">Choisissez votre base de données</option>
                <option value="mysql">MySQL</option>
              </select>
            </div>
          </div>

          <div id="formaction-contenu" class="row hide">
            <div class="large-12 columns">
          <fieldset>
            <legend>Etape 1/3 : Accès à la base</legend> 
            <input type="text" id="bd_hote" name="bd_hote" placeholder="Hôte *" class="champ">
            <input type="text" id="bd_nom" name="bd_nom" placeholder="Nom de la base *" class="champ">
            <input type="text" id="bd_user" name="bd_user" placeholder="Nom d'utilisateur *" class="champ">
            <input type="text" id="bd_pswd" name="bd_pswd" placeholder="Mot de passe " class="champ">
          </fieldset>


<!--
          <fieldset>
            <legend>Votre initiative</legend>
              <input type="text" name="initiative_titre" id="initiative_titre" placeholder="Titre de votre initiative *">
              <?php
               // echo affiche_rubriques($selected="",$typeliste="select",$description="Quel est votre centre d'intérêt principal ?");
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
-->
          <div class="row">
            <div class="large-12 text-center">
              <button type="submit">Test connexion</button>          
            </div>
          </div>

          </div></div> <!-- formgene-contenu -->

  			</form>
      </div>     
    </section>
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
        $('#type_bd').change(function() {

          $('html, body').animate({
              scrollTop: $("#formgene").offset().top
          }, 1000);

          if ($(this).val()==="")
            $('#formaction-contenu').slideUp();
          else
            $('#formaction-contenu').slideDown();
        });

        // Lorsque je soumets le formulaire
        $('#formgene').on('submit', function(e) {
          e.preventDefault();
          $erreur.css('display','none');
          $resultat.css('display','none');
          $resultat.html("<p>La connexion avec votre base de données est établie !</p>");
          /*var champ = $('.champ');
          champ.css({
            borderColor:'grey'
          });
          var src = $('#type_bd option:selected').val();
          var l_hote = verifier($bd_hote);
          var l_bdnom = verifier($bd_nom);
          var l_user = verifier($bd_user);

          if(hote && bdnom && user && pswd){
            $.post(
              'traitement_generateur.php',
              {
                source : src,
                hote : $bd_hote.val(),
                bdname : $bd_nom.val(),
                bduser : $bd_user.val(),
                bdpswd : $bd_pswd.val()
              },
              function(data){
                if(data == "Success"){
                  $resultat.html("<p>La connexion avec votre base de données est établie !</p>");
                  $resultat.css('display','block');
                }
                else {
                  $erreur.html("<p>Un problème est survenu lors de la connexion. Veuillez vérifier vos informations de connexion.</p>");
                  $erreur.css('display','block');
                }
              },
              'text' // Format des données reçues
            );
          }*/
        });
          /*
          
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
                        var type_bd = $('#type_bd').val();

                        // vide le form
                        $(':input','#formgene')
                         .not(':button, :submit, :reset, :hidden')
                         .val('')
                         .removeAttr('checked')
                         .removeAttr('selected');
                        $('#les-actions').slideUp().load("labo_affiche_actions.php?reload=1&statut="+type_bd).slideDown();
                        $('#formaction-contenu').slideUp();
                      }
                      else 
                      {
                        $('#messager').addClass("alert").html(retour).slideDown().delay(3000).slideUp();
                      }
                  }
              });
          }*/
      // Fonction qui vérifie si tous les champs obligatoires ont été remplis. Affiche un message d'erreur si ce n'est pas le cas
     /* function verifier(champ){  
        var bool = true;
        if(champ.val() == ""){
          $erreur.html("<p>Les champs avec * sont obligatoires.</p>");
          $erreur.css('display','block');
          champ.css({
            borderColor:'red'
          });
          bool = false;
        } 
        return bool;
      }*/

      });      
    </script>
  </body>
  <?php include_once("vues/foot.php"); ?>
