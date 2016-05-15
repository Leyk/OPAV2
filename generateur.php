<?php
include_once ("vues/entete.php");
include_once ("vues/menu.php");
?>

<body>
 <section class="row contenu">
      <div class="large-12 medium-12 columns">

        <h5>A votre tour de créer votre Constellation !</h5><br/>
        <form id="formgene" >
          <div id="formgene-intro" class="row">
            <div class="large-12 columns">
              <select name="type_bd" id="type_bd">
                <option value="">Choisissez votre base de données</option>
                <option value="mysql">MySQL</option>
              </select>
            </div>
          </div>

          <div id="formgene-etape1" class="row hide">
            <div class="large-12 columns">
          		<fieldset>
            		<legend>Etape 1/3 : Accès à la base</legend> 
            		<span id="erreur"></span>
			        <span id="resultat"></span>
            		<input type="text" id="bd_hote" name="bd_hote" placeholder="Hôte *" class="champ">
		            <input type="text" id="bd_nom" name="bd_nom" placeholder="Nom de la base *" class="champ">
		            <input type="text" id="bd_user" name="bd_user" placeholder="Nom d'utilisateur *" class="champ">
		            <input type="text" id="bd_pswd" name="bd_pswd" placeholder="Mot de passe " class="champ">
          		</fieldset>
          		<div class="row">
            		<div class="large-12 text-center">
              			<button type="submit" class="btn" id="test_connexion">Test connexion</button>          
            		</div>
          		</div>
          	</div>
      	  </div> 

			<div id="formgene-etape2" class="row hide">
            <div class="large-12 columns">
          		<fieldset>
            		<legend>Etape 2/3 : Accès aux données</legend> 
            		<span id="erreur_donnees"></span>
			        <span id="resultat_donnees"></span>
            		<input type="text" id="niv0" name="niv0" placeholder="Nom sphère root *" class="champ">

            		<!-- DEBUT SPHERE DE NIVEAU 1 -->
            		<div class="row collapse">
		              <div class="small-3 large-1 columns">
		              	<center>
		                <input type="button" id="btn_plus1" value="+" class="add">
		                </center>
		              </div>
		              <div class="small-9 large-11 columns">
		                <input type="text" id="niv1" name="niv1" placeholder="Nom sphère de niveau 1" class="champ">
		              </div>
		            </div>
		            <div class="row">
		            	<div class="large-7 large-offset-2 columns end">
			            	<input type="text" id="idniv1" name="idniv1" placeholder="Champ id" class="champ">
			            </div>
			        </div>
			        <div class="row">
	            		<div class="large-7 large-offset-2 columns end">
		            		<input type="text" id="titreniv1" name="titreniv1" placeholder="Champ titre" class="champ">
		            	</div>
		            </div>
		            <!-- FIN SPHERE DE NIVEAU 1 -->
		            <!-- DEBUT SPHERE DE NIVEAU 2-->
		            <div id="formniv2" class ="row hide">
			            <div class="row collapse">
			              <div class="small-3 large-1 columns">
			              	<center>
			                <input type="button" id="btn_plus2" value="+" class="add">
			                <input type="button" id="btn_moins2" value="-" class="del">
			                </center>
			              </div>
			              <div class="small-9 large-11 columns">
			                <input type="text" id="niv2" name="niv2" placeholder="Nom sphère de niveau 2" class="champ">
			              </div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
				            	<input type="text" id="idniv2" name="idniv2" placeholder="Champ id" class="champ">
				            </div>
				        </div>
				        <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="titreniv2" name="titreniv2" placeholder="Champ titre" class="champ">
			            	</div>
			            </div>
		            </div>
 					<!-- FIN SPHERE DE NIVEAU 2 -->
 					<!-- DEBUT SPHERE DE NIVEAU 3-->
		            <div id="formniv3" class ="row hide">
			            <div class="row collapse">
			              <div class="small-3 large-1 columns">
			              	<center>
			                <input type="button" id="btn_plus3" value="+" class="add">
			                <input type="button" id="btn_moins3" value="-" class="del">
			                </center>
			              </div>
			              <div class="small-9 large-11 columns">
			                <input type="text" id="niv3" name="niv3" placeholder="Nom sphère de niveau 3" class="champ">
			              </div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
				            	<input type="text" id="idniv3" name="idniv3" placeholder="Champ id" class="champ">
				            </div>
				        </div>
				        <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="titreniv3" name="titreniv3" placeholder="Champ titre" class="champ">
			            	</div>
			            </div>
		            </div>
 					<!-- FIN SPHERE DE NIVEAU 3 -->
 					<!-- DEBUT SPHERE DE NIVEAU 4-->
		            <div id="formniv4" class ="row hide">
			            <div class="row collapse">
			              <div class="small-3 large-1 columns">
			              	<center>
			                <input type="button" id="btn_moins4" value="-" class="del">
			                </center>
			              </div>
			              <div class="small-9 large-11 columns">
			                <input type="text" id="niv4" name="niv4" placeholder="Nom sphère de niveau 4" class="champ">
			              </div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
				            	<input type="text" id="idniv4" name="idniv4" placeholder="Champ id" class="champ">
				            </div>
				        </div>
				        <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="titreniv4" name="titreniv4" placeholder="Champ titre" class="champ">
			            	</div>
			            </div>
		            </div>
 					<!-- FIN SPHERE DE NIVEAU 4 -->
		            </div>
          		</fieldset>
          		<div class="row">
            		<div class="large-12 text-center">
              			<button type="submit" class="btn" id="valider_donnees">Valider mes données</button>          
            		</div>
          		</div>
          	</div>
      	  </div>              	
  	</form>
      </div>     
    </section>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/foundation/foundation.reveal.js"></script>
    <script src="js/jquery.autosize.min.js"></script>

    <script>
      $(document).foundation();

      $(document).ready(function() {
      	var $erreur = $('#erreur'),
          	$resultat = $('#resultat'),
          	$erreur_donnees = $('#erreur_donnees'),
          	$resultat_donnees = $('#resultat_donnees'),
      		$test_co = $('#test_connexion'),
      		$valider = $('#valider_donnees'),
      		$bt_plus = $('.add'),
      		$bt_moins = $('.del'),
      		$bd_hote = $('#bd_hote'),
      		$bd_nom = $('#bd_nom'),
      		$bd_user = $('#bd_user'),
      		$champ = $('.champ'),
      		$bd_pswd = $('#bd_pswd');

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
            $('#formgene-etape1').slideUp();
          else
            $('#formgene-etape1').slideDown();
        });

        // Lors de la saisie
        $champ.keyup(function(){
	        $(this).css({
	          borderColor:'#cccccc'
	        })
      	});

      	// Lorsque je clique sur "+" (ajout d'un niveau)
      	$bt_plus.click(function(e) {
      		var el = e.target||event.srcElement;
      		var id = el.id;
      		if(id =="btn_plus1"){
      			$('html, body').animate({
              		scrollTop: $("#formgene-etape2").offset().top
         		}, 1000);
            	$('#formniv2').slideDown();
            	$('#btn_plus1').hide();
      		}
      		else if(id =="btn_plus2"){
      			$('html, body').animate({
              		scrollTop: $("#formniv2").offset().top
         		}, 1000);
            	$('#formniv3').slideDown();
            	$('#btn_plus2').hide();
            	$('#btn_moins2').hide();
      		}
      		else if(id =="btn_plus3"){
      			$('html, body').animate({
              		scrollTop: $("#formniv3").offset().top
         		}, 1000);
            	$('#formniv4').slideDown();
            	$('#btn_plus3').hide();
            	$('#btn_moins3').hide();
      		}
      		
      	})

      	// Lorsque je clique sur "-" (suppression d'un niveau)
      	$bt_moins.click(function(e) {
      		var el = e.target||event.srcElement;
      		var id = el.id;
      		if(id =="btn_moins2"){
      			$('html, body').animate({
              		scrollTop: $("#formgene-etape2").offset().top
          		}, 1000);
            	$('#formniv2').slideUp();
            	$('#niv2').val("");
            	$('#idniv2').val("");
            	$('#titreniv2').val("");
            	$('#btn_plus1').show();
            	$('#btn_moins1').show();
      		}
      		else if(id =="btn_moins3"){
      			$('html, body').animate({
              		scrollTop: $("#formniv3").offset().top
          		}, 1000);
            	$('#formniv3').slideUp();
            	$('#niv3').val("");
            	$('#idniv3').val("");
            	$('#titreniv3').val("");
            	$('#btn_plus2').show();
            	$('#btn_moins2').show();
      		}
      		else if(id =="btn_moins4"){
      			$('html, body').animate({
              		scrollTop: $("#formniv4").offset().top
          		}, 1000);
            	$('#formniv4').slideUp();
            	$('#niv4').val("");
            	$('#idniv4').val("");
            	$('#titreniv4').val("");
            	$('#btn_plus3').show();
            	$('#btn_moins3').show();
      		}	 
      	})


        // Lorsque je soumets le test de connexion
        $test_co.click(function(e) {
          e.preventDefault();
          $erreur.css('display','none');
          $resultat.css('display','none');         
          var champ = $('.champ');
          champ.css({
            borderColor:'#cccccc'
          });
          var src = $('#type_bd option:selected').val();
          var b_hote = verifier($bd_hote, "test_co");
          var b_bdnom = verifier($bd_nom, "test_co");
          var b_user = verifier($bd_user, "test_co");

          if(b_hote && b_bdnom && b_user){
            $.post(
              'traitement_generateur.php',
              {
                source : src,
                hote : $bd_hote.val(),
                bdname : $bd_nom.val(),
                bduser : $bd_user.val(),
                bdpswd : $bd_pswd.val(),
                bouton : "btn_connexion"
              },
              function(data){
                if(data == "Success"){
                  $resultat.html("<p>La connexion avec votre base de données a été établie avec succès !</p>");
                  $resultat.css('display','block');
                  $("#bd_hote").attr('disabled','disabled');
                  $("#bd_nom").attr('disabled','disabled');
                  $("#bd_user").attr('disabled','disabled');
                  $("#bd_pswd").attr('disabled','disabled');
                  $(test_connexion).attr("disabled", true);
                  $("#type_bd").attr('disabled','disabled');
                  $('html, body').animate({
              		scrollTop: $("#formgene").offset().top}, 1000);
		           $('#formgene-etape2').slideUp();
		           $('#formgene-etape2').slideDown();
                }
                else {
                  $erreur.html("<p>Un problème est survenu lors de la connexion. Veuillez vérifier vos informations de connexion. <br> "+data+"</p>");
                  $erreur.css('display','block');
                }
              },
              'text' // Format des données reçues
            );
          }
      	});

		// Lorsque je soumets les données
		$valider.click(function(e){
			e.preventDefault();
	      	$erreur_donnees.css('display','none');
	      	$resultat_donnees.css('display','none');
         	var b_niv2 = false,
          	    b_niv3 = false,
          	    b_niv4 = false,
          	    dataOk = false;
            var champ = $('.champ');
            champ.css({
            	borderColor:'#cccccc'
          	});  
          	var b_sphere0 = verifier($('#niv0'), "valider_donnees");
          	var b_sphere1 = verifier($('#niv1'), "valider_donnees");
          	var b_id1 = verifier($('#idniv1'), "valider_donnees");
          	var b_titre1 = verifier($('#titreniv1'), "valider_donnees"); 
          	if($('#formniv2').css('display') != 'none'){
          		b_niv2 = true;
              	var b_sphere2 = verifier($('#niv2'), "valider_donnees");
	          	var b_id2 = verifier($('#idniv2'), "valider_donnees");
	          	var b_titre2 = verifier($('#titreniv2'), "valider_donnees"); 
	          	if($('#formniv3').css('display') != 'none'){
	          		b_niv3 = true;
	          		var b_sphere3 = verifier($('#niv3'), "valider_donnees");
	          		var b_id3 = verifier($('#idniv3'), "valider_donnees");
	          		var b_titre3 = verifier($('#titreniv3'), "valider_donnees"); 
	          		if($('#formniv4').css('display') != 'none'){
	          			b_niv4 = true;
						var b_sphere4 = verifier($('#niv4'), "valider_donnees");
		          		var b_id4 = verifier($('#idniv4'), "valider_donnees");
		          		var b_titre4 = verifier($('#titreniv4'), "valider_donnees"); 
					}
	          	}
           	}
           	// ===== Vérification du remplissage des champs obligatoires, selon le nombre de sphère à générer ====
           	var liste_donnees = "";
            if(b_sphere0 && b_sphere1 && b_id1 && b_titre1){
           		if(!b_niv2){
           		dataOk = true;
           		}
           		else {
           			if(b_sphere2 && b_id2 && b_titre2){
           				if(!b_niv3){
           					dataOk = true;
           				}
           				else{
           					if(b_sphere3 && b_id3 && b_titre3){
           						if(!b_niv4){
           							dataOk = true;
           						}
           						else{
           							if(b_sphere4 && b_id4 && b_titre4){
           								dataOk = true;
           							}
           						}
           					}
           				}
           			}
           		}
           	}

           	// ===================================================================================================
           	if(dataOk){
           		$.post(
           			'traitement_generateur.php',
           			{
           				bouton : "btn_validation",
           				nom_sphere_1 : $('#niv1').val(),
           				id_sphere_1 : $('#idniv1').val(),
           				titre_sphere_1 : $('#titreniv1').val()		
           			},
           			function(data){
           				$resultat_donnees.html("<p> Succès ! "+data+"</p>");
           				$resultat_donnees.css('display','block');
           			},
           			'text' // A CHECK html?
           		);
           	}

		})

		// Fonction qui vérifie si tous les champs obligatoires ont été remplis. Affiche un message d'erreur si ce n'est pas le cas
		function verifier(champ, form){  
        	var bool = true;
	        if(champ.val() == ""){
	        	if(form =="test_co"){
		          $erreur.html("<p>Les champs avec * sont obligatoires.</p>");
		          $erreur.css('display','block');
		          champ.css({
		            borderColor:'red'
		          });
		         }
		         else if(form == "valider_donnees"){
		         	$erreur_donnees.html("<p>Les champs avec * sont obligatoires.</p>");
		          	$erreur_donnees.css('display','block');
		          	champ.css({
		            	borderColor:'red'
		          	});
		         }
	          bool = false;
	        } 
	        return bool;
      	}
   	  });     
    </script>
  </body>
  <?php include_once("vues/foot.php"); ?>
