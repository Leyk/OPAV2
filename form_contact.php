<?php 
require_once ("inc/_var_fv.php");
include_once ("vues/entete.php"); ?>
  <body>
    <div id="erreur">
    </div>
    <div id="resultat">
    </div>
    <form id="formcontact">
      <div id="formcontact-intro" class="row">
        <div class="large-10 columns">
          <fieldset>
            <legend>Qui contacter</legend>
            <select name="dest_msg" id="dest_msg">
              <option value="">Choisissez qui contacter</option>
              <option value="initiateur">Seulement l'initiateur du projet</option>
              <option value="diffusion">Toutes les personnes en lien avec ce projet</option>
            </select>
          </fieldset>
          <div id ="info">
          </div>
        </div>
      </div>
      <div id="formcontact-contenu" class="row hide">
        <div class="large-10 columns">
          <fieldset>
            <legend>Vos informations</legend>
            <input type="text" id="posteur_nom" name="posteur_nom" placeholder="Votre nom *" class="champ">
            <input type="text" id="posteur_prenom" name="posteur_prenom" placeholder="Votre prénom" class="champ">
            <input type="text" id="posteur_email" name="posteur_email" placeholder="Votre courriel *" class="champ">
            <textarea name="posteur_message" id="posteur_message" placeholder="Votre message *" class="champ"></textarea>
          </fieldset>
          <div class="row">
            <div class="large-10 text-center">
              <button type="submit" id="envoyer">Envoyer</button>          
            </div>
          </div>
        </div>
      </div> <!-- formaction-contenu -->
    </form>

    <?php 
    if(isset($mail_initiateur)){ // Vérification si une adresse mail est dispo pour contacter l'initiateur d'un projet
      $existMailInitiateur = true;
    } 
    else {
       $existMailInitiateur = false;
    }
    if ($pdo->getListeDiffusion($id)){
      $existeMailDiff = true;
    }
    else {
      $existeMailDiff = false;
    }

    ?>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>


    <script>
    $(document).foundation();

    $(document).ready(function(){
      var $nom_personne = $('#posteur_nom'),
          $prenom_personne = $('#posteur_prenom'),
          $mail_personne = $('#posteur_email'),
          $msg_personne = $('#posteur_message'),
          $champ = $('.champ'),
          $erreur = $('#erreur'),
          $resultat = $('#resultat'),
          $info = $('#info'),
          $envoi = $('#envoyer'),
          $id = '<?php echo $id; ?>';
          $existe_mail_initiateur = '<?php echo $existMailInitiateur; ?>';
          $existe_mail_diff = '<?php echo $existeMailDiff; ?>';
          $dest = $('#dest_msg option:selected').val();

      // ================== affichage du formulaire =========================
      $('#dest_msg').change(function(){
        $dest = $('#dest_msg option:selected').val();
        $erreur.css('display','none');
        $resultat.css('display','none');
        $info.css('display','none');
        $('#posteur_message').css("display","inline"); // réaffiche le champ message (cas où il a été masqué si aucun mail dans liste de diffusion de l'action)
        // On veut contacter l'initiateur de l'action
        if($(this).val() === "initiateur"){
          if(!$existe_mail_initiateur){
            $erreur.css('display','block');
            $erreur.html("<p>Il n'y a malheureusement aucune adresse mail valide pour cet initiateur ! </p>");
            $('#formcontact-contenu').slideUp(); // ferme le corps du formulaire 
          } 
          else {
            $('html, body').animate({ // ajuste l'écran principal sur l'ouverture du formulaire 
              scrollTop: $("#formcontact").offset().top
            }, 1000);
            $('#volet').animate({ // ajuste l'écran de navigation (volet) sur l'ouverture du formulaire 
             scrollTop: $("#formcontact").offset().top
            }, 1000);
            $('#formcontact-contenu').slideDown(); // ouvre le corps du formulaire 
          }
        }
        // On veut contacter les personnes présentes dans la liste de diffusion de l'action
        else if($(this).val() === "diffusion") {
          // test si mails dans liste
          if(!$existe_mail_diff){ // s'il n'y a pas de mails dans la liste de diffusion
            $erreur.css('display','block');
            $erreur.html("<p>Il n'y a malheureusement aucune adresse mail valide dans la liste de diffusion de ce projet ! </br> Vous pouvez cependant entrer votre adresse mail afin de pouvoir être contacté par d'autres personnes intéressées par cette action à l'avenir.</p> ");
			      $('#posteur_message').css("display","none"); // ouvre le corps du "sous formulaire"           
            $('#formcontact-contenu').slideDown(); // ouvre le corps du formulaire principal
            $('html, body').animate({ // ajuste l'écran principal sur l'ouverture du formulaire 
              scrollTop: $("#formcontact").offset().top
            }, 700);
            $('#volet').animate({ // ajuste l'écran de navigation (volet) sur l'ouverture du formulaire 
             scrollTop: $("#formcontact").offset().top
            }, 700);
          } 
          else { // s'il y a des mails de contact dans la liste de diffusion
            $info.css('display','block');
            $info.html("En remplissant ce formulaire, votre adresse mail sera conservée et ajoutée à la liste de diffusion de cette action afin que vous puissiez être contacté par d'autres personnes intéressées par cette action à l'avenir.");
            $('#formcontact-contenu').slideDown(); // ouvre le corps du formulaire 
            $('html, body').animate({ // ajuste l'écran principal sur l'ouverture du formulaire 
              scrollTop: $("#formcontact").offset().top
            }, 1000);
            $('#volet').animate({ // ajuste l'écran de navigation (volet) sur l'ouverture du formulaire 
             scrollTop: $("#formcontact").offset().top
            }, 1000);
          }
        }
        else{
          if ($(this).val()==="")
              $('#formcontact-contenu').slideUp(); // ferme le corps du formulaire 
          else
              $('#formcontact-contenu').slideDown(); // ouvre le corps du formulaire 
        }
      });

      $champ.keyup(function(){
        $(this).css({
          borderColor:'#CCCCCC'
        })
      });

      // soumission du formulaire
      $envoi.click(function(e) {
        e.preventDefault(); // on annule la fonction par défaut du bouton d'envoi
        $erreur.css('display','none');
        $resultat.css('display','none');
        $info.css('display','none');
        var champ = $('.champ');
        champ.css({
            borderColor:'grey'
        });
        var nom = verifier($nom_personne);
        var mail = verifier($mail_personne);
        var mailok = validateEmail($mail_personne);
        var msg = "";
        var dest = $('#dest_msg option:selected').val();
        var dataOk = false; 
        // ===== Vérification du remplissage des champs obligatoires, selon la sélection du destinataire ====
        if (dest === "initiateur"){
          msg = verifier($msg_personne);
        	if(nom && mail && msg && mailok){
        		dataOk = true;
        	}
        }
        else if (dest === "diffusion"){
        	if(!$existe_mail_diff){ 
        		if(nom && mail && mailok){
        			dataOk = true;
        		}
        	}
        	else {
            msg = verifier($msg_personne);
        		if(nom && mail && msg && mailok){
        			dataOk = true;
        		}
        	}
        }
        // ===================================================================================================
        if(dataOk){
         	$.post(
	          'traitement_formulaire.php',
	          {
	          	nom : $nom_personne.val(), // données envoyées au fichier ci-dessus
	          	prenom : $prenom_personne.val(),
	          	mail : $mail_personne.val(),
	          	message : $msg_personne.val(),
	          	id : $id, // id du projet
	          	destinataire : $dest
	          },
	          function(data){ // fonction qui va gérer le retour
              if (data.Success){
                $resultat.html("<p>"+data.Success+"</p>");
                $resultat.css('display','block');
              }
	          	if (data.Erreur){
	          		$erreur.html("<p>"+data.Erreur+"</p>");
	          		$erreur.css('display','block');
	          	}
	          },
	          'json' // Format des données reçues 
	         );
        }
      });
  
      // Fonction qui vérifie si tous les champs obligatoires ont été remplis. Affiche un message d'erreur si ce n'est pas le cas
      function verifier(champ){  
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
      }

      // Fonction qui vérifie si une adresse email est valide. Si elle ne l'est pas, affiche un message d'erreur si elle ne l'est pas
      function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var bool = re.test(email.val());
        if(!bool){
          $erreur.html("<p>L'adresse mail saisie n'est pas valide.</p>");
          $erreur.css('display','block');
          email.css({
            borderColor:'red'
          });
        }
        return bool;
      }
    });
    </script>
  </body>
</html> <!-- on n'inclut pas le footer car cette page est affichée dans une autre (volet) -->