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
                <option value="csv">CSV</option>
              </select>
            </div>
          </div>

          <!-- PARTIE POUR CSV -->
          <div id="formgene-csv" class="row hide">
          <div class="large-12 columns">
          		<fieldset>
            		<legend>Votre fichier CSV</legend> 
            		<span id="erreur_csv"></span>
			        <span id="resultat_csv"></span>
	                <input type="file" id="parcourir" name="fichier">
          		</fieldset>
          		<div class="row">
            		<div class="large-12 text-center">
              			<button type="submit" class="btn" id="valide_csv">Valider mes données</button>          
            		</div>
          		</div>
          	</div>
      	  </div> 
      	  <!-- FIN PARTIE CSV -->

          <div id="formgene-etape1" class="row hide">
            <div class="large-12 columns">
          		<fieldset>
            		<legend>Etape 1/3 : Accès à la base</legend> 
            		<span id="erreur"></span>
			        <span id="resultat"></span>
            		<input type="text" id="bd_hote" name="bd_hote" placeholder="Hôte *" class="champ" value="127.0.0.1">
		            <input type="text" id="bd_nom" name="bd_nom" placeholder="Nom de la base *" class="champ" value="bdtestopa">
		            <input type="text" id="bd_user" name="bd_user" placeholder="Nom d'utilisateur *" class="champ" value="root">
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
            		<input type="text" id="niv0" name="niv0" placeholder="Nom sphère root *" class="champ" value="forcesvives">

            		<!-- DEBUT SPHERE DE NIVEAU 1 -->
            		<div class="row collapse">
		              <div class="small-3 large-1 columns">
		              	<center>
		                <input type="button" id="btn_plus1" value="+" class="add">
		                </center>
		              </div>
		              <div class="small-9 large-11 columns">
		                <input type="text" id="niv1" name="niv1" placeholder="Nom sphère de niveau 1" class="champ" value="sphere_niveau1">
		              </div>
		            </div>
		            <div class="row">
		            	<div class="large-7 large-offset-2 columns end">
			            	<input type="text" id="idniv1" name="idniv1" placeholder="Champ id" class="champ" value="id">
			            </div>
			        </div>
			        <div class="row">
	            		<div class="large-7 large-offset-2 columns end">
		            		<input type="text" id="titreniv1" name="titreniv1" placeholder="Champ titre" class="champ" value="titre">
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
			                <input type="text" id="niv2" name="niv2" placeholder="Nom sphère de niveau 2" class="champ" value="actions_rubriques">
			              </div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
				            	<input type="text" id="idniv2" name="idniv2" placeholder="Champ id" class="champ" value="id">
				            </div>
				        </div>
				        <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="titreniv2" name="titreniv2" placeholder="Champ titre" class="champ" value="titre">
			            	</div>
			            </div>
			            <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
		            		<label>Type de relation entre sphère niveau 2 et sphère de niveau 1 (cardinalités maximales) :</label>
			            	</div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
			            		<input type="radio" name="radioniv2" value="un" id="radioniv2_un" class="type_rel"><label for="Un">(1..n)</label>
			            		<input type="radio" name="radioniv2" value="plusieurs" id="radioniv2_plusieurs" class="type_rel"><label for="Plusieurs">(n..n)</label>
			            	</div>
			            </div>
			            <div id="formniv2_un" class="row hide">
			            	<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="idrelniv2" name="idrelniv2" placeholder="Champ id clé étrangère" class="champ" value="id_centreinteret">
			            	</div>
			            </div>
			            <div id="formniv2_plusieurs" class="row hide">
			            	<div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tablerelniv2" name="tablerelniv2" placeholder="Table de relation" class="champ">
				            	</div>
				            </div>
				            <div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tableid1relniv2" name="tableid1relniv2" placeholder="Champ id niveau 1" class="champ">
				            	</div>
				            </div>
				            <div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tableid2relniv2" name="tableid2relniv2" placeholder="Champ id niveau 2" class="champ">
				            	</div>
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
			                <input type="text" id="niv3" name="niv3" placeholder="Nom sphère de niveau 3" class="champ" value="feuille">
			              </div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
				            	<input type="text" id="idniv3" name="idniv3" placeholder="Champ id" class="champ" value="id">
				            </div>
				        </div>
				        <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="titreniv3" name="titreniv3" placeholder="Champ titre" class="champ" value="initiative_titre">
			            	</div>
			            </div>
			            <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
		            		<label>Type de relation entre sphère niveau 3 et sphère de niveau 2 (cardinalités maximales) :</label>
			            	</div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
			            		<input type="radio" name="radioniv3" value="un" id="radioniv3_un" class="type_rel"><label for="Un">(1..n)</label>
			            		<input type="radio" name="radioniv3" value="plusieurs" id="radioniv3_plusieurs" class="type_rel"><label for="Plusieurs">(n..n)</label>
			            	</div>
			            </div>
			            <div id="formniv3_un" class="row hide">
			            	<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="idrelniv3" name="idrelniv3" placeholder="Champ id clé étrangère" class="champ">
			            	</div>
			            </div>
			            <div id="formniv3_plusieurs" class="row hide">
			            	<div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tablerelniv3" name="tablerelniv3" placeholder="Table de relation" class="champ" value="feuille_rubriques">
				            	</div>
				            </div>
				            <div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tableid1relniv3" name="tableid1relniv3" placeholder="Champ id niveau 2" class="champ" value="id_rubrique">
				            	</div>
				            </div>
				            <div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tableid2relniv3" name="tableid2relniv3" placeholder="Champ id niveau 3" class="champ" value="id_initiative">
				            	</div>
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
			            <div class="row">
		            		<div class="large-7 large-offset-2 columns end">
		            		<label>Type de relation entre sphère niveau 4 et sphère de niveau 3 (cardinalités maximales) :</label>
			            	</div>
			            </div>
			            <div class="row">
			            	<div class="large-7 large-offset-2 columns end">
			            		<input type="radio" name="radioniv4" value="un" id="radioniv4_un" class="type_rel"><label for="Un">(1..n)</label>
			            		<input type="radio" name="radioniv4" value="plusieurs" id="radioniv4_plusieurs" class="type_rel"><label for="Plusieurs">(n..n)</label>
			            	</div>
			            </div>
			            <div id="formniv4_un" class="row hide">
			            	<div class="large-7 large-offset-2 columns end">
			            		<input type="text" id="idrelniv4" name="idrelniv4" placeholder="Champ id clé étrangère" class="champ">
			            	</div>
			            </div>
			            <div id="formniv4_plusieurs" class="row hide">
			            	<div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tablerelniv4" name="tablerelniv4" placeholder="Table de relation" class="champ">
				            	</div>
				            </div>
				            <div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tableid1relniv4" name="tableid1relniv4" placeholder="Champ id niveau 3" class="champ">
				            	</div>
				            </div>
				            <div class="row">
				            	<div class="large-7 large-offset-2 columns end">
				            		<input type="text" id="tableid2relniv4" name="tableid2relniv4" placeholder="Champ id niveau 4" class="champ">
				            	</div>
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
      	 <div id="divsvg" class="row hide">
            <div class="large-12 columns">
          		<fieldset>
            		<legend>Votre Constellation</legend> 
            	</fieldset>
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
          	$erreur_csv = $('#erreur_csv'),
          	$resultat_csv = $('#resultat_csv'),
      		$test_co = $('#test_connexion'),
      		$valider = $('#valider_donnees'),
      		$bt_plus = $('.add'),
      		$bt_moins = $('.del'),
      		$bd_hote = $('#bd_hote'),
      		$bd_nom = $('#bd_nom'),
      		$bd_user = $('#bd_user'),
      		$champ = $('.champ'),
      		$btn_radio = $('.type_rel'),
      		$btn_csv = $('#valide_csv'),
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

          if ($(this).val()===""){
            $('#formgene-etape1').slideUp();
            $('#formgene-csv').slideUp();
          }
          else if ($(this).val()==="mysql"){
          	$('#formgene-csv').slideUp();
            $('#formgene-etape1').slideDown();
          }
          else if($(this).val()==="csv"){
          	$('#formgene-etape1').slideUp();
          	$('#formgene-csv').slideDown();
          }
        });

        $btn_radio.change(function(e){
        	var el = e.target||event.srcElement;
      		var id = el.id;
      		if(id=="radioniv2_un"){
      			$('#formniv2_plusieurs').slideUp();
      			$('#formniv2_un').slideDown();
      		}
      		else if(id=="radioniv2_plusieurs"){
      			$('#formniv2_un').slideUp();
      			$('#formniv2_plusieurs').slideDown();
      		}
      		else if(id=="radioniv3_un"){
      			$('#formniv3_plusieurs').slideUp();
      			$('#formniv3_un').slideDown();
      		}
      		else if(id=="radioniv3_plusieurs"){
      			$('#formniv3_un').slideUp();
      			$('#formniv3_plusieurs').slideDown();
      		}
      		else if(id=="radioniv4_un"){
      			$('#formniv4_plusieurs').slideUp();
      			$('#formniv4_un').slideDown();
      		}
      		else if(id=="radioniv4_plusieurs"){
      			$('#formniv4_un').slideUp();
      			$('#formniv4_plusieurs').slideDown();
      		}
        })
               
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
            	$('#tablerelniv2').val("");
            	$('#tableid1relniv2').val("");
            	$('#tableid2relniv2').val("");
            	$('#idrelniv2').val("");
            	$('#radioniv2_un').attr("checked",false);
            	$('#radioniv2_plusieurs').attr("checked",false);
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
            	$('#tablerelniv3').val("");
            	$('#tableid1relniv3').val("");
            	$('#tableid2relniv3').val("");
            	$('#idrelniv3').val("");
            	$('#radioniv3_un').attr("checked",false);
            	$('#radioniv3_plusieurs').attr("checked",false);
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
            	$('#tablerelniv4').val("");
            	$('#tableid1relniv4').val("");
            	$('#tableid2relniv4').val("");
            	$('#idrelniv4').val("");
            	$('#radioniv4_un').attr("checked",false);
            	$('#radioniv4_plusieurs').attr("checked",false);
            	$('#btn_plus3').show();
            	$('#btn_moins3').show();
      		}	 
      	})

		// Lorsque je soumets le fichier CSV
		$btn_csv.click(function(e){	
		  e.preventDefault();
          $erreur_csv.css('display','none');
          $resultat_csv.css('display','none'); 
         // var file = $('input[type="file"]').files[0];


		})

		/*$('input[type="file"]').change(function(){
        var file = this.files[0];
       	alert('Filename : ' + file.name + '<br />Filesize : ' + file.size);
		});*/

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
           				// ========================= envoi des données récupérées dans tous les champs ===========
           				bouton : "btn_validation",
           				nom_root : $("#niv0").val(),
           				nom_sphere_1 : $('#niv1').val(),
           				id_sphere_1 : $('#idniv1').val(),
           				titre_sphere_1 : $('#titreniv1').val(),
           				nom_sphere_2 : $('#niv2').val(),
           				id_sphere_2 : $('#idniv2').val(),
           				titre_sphere_2 : $('#titreniv2').val(),
           				nom_sphere_3 : $('#niv3').val(),
           				id_sphere_3 : $('#idniv3').val(),
           				titre_sphere_3 : $('#titreniv3').val(),
           				nom_sphere_4 : $('#niv4').val(),
           				id_sphere_4 : $('#idniv4').val(),
           				titre_sphere_4 : $('#titreniv4').val(),
           				nom_relation_2 : $('#tablerelniv2').val(),   // relation n..n
		            	id1_relation_2 : $('#tableid1relniv2').val(), // relation n..n
		            	id2_relation_2 : $('#tableid2relniv2').val(), // relation n..n
		            	id_relation_2 : $('#idrelniv2').val(),   // relation 1..n
		            	nom_relation_3 : $('#tablerelniv3').val(), // relation n..n
		            	id1_relation_3 : $('#tableid1relniv3').val(), // relation n..n
		            	id2_relation_3 : $('#tableid2relniv3').val(), // relation n..n
		            	id_relation_3 : $('#idrelniv3').val(), // relation 1..n
		            	nom_relation_4 : $('#tablerelniv4').val(), // relation n..n
		            	id1_relation_4 : $('#tableid1relniv4').val(), // relation n..n
		            	id2_relation_4 : $('#tableid2relniv4').val(), // relation n..n
		            	id_relation_4 : $('#idrelniv4').val() // relation 1..n*/
		            	// =============================================================================================
           			},
           			function(data){
           				$resultat_donnees.html("<p> Succès ! </p>");
           				$resultat_donnees.css('display','block');
           				$(valider_donnees).attr("disabled", true);
           				$('#divsvg').slideDown();
           				var margin = 1,
				            diameter = 900;   // diamètre minimum du cercle "root"
				        if(window.innerWidth >= 1700){  // si grand écran, root plus grand
				            diameter = window.innerWidth/1.7;
				        }
				        var color = d3.scale.linear()
				            .domain([-1, 5])  // plages de couleur (du plus clair au plus foncé)
				            .range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])  // Pour le dégradé
				            .interpolate(d3.interpolateHcl);

				        var pack = d3.layout.pack()
				            .padding(7)   // espacement entre les cercles 
				            .size([diameter - margin, diameter - margin]) // taille cercle root dans son conteneur
				            .value(function (d) {
				            return d.size; // taille des feuilles 
				        });


				        var svg = d3.select("#svgdiv").append("svg")
				            .attr("width", diameter) // largeur du "rectangle" contenant le cercle root
				            .attr("height", diameter) // hauteur du "rectangle" contenant le cercle root
				            .attr("id","carto")
				            .append("g")  // pour grouper 
				            .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");


				        // === Définition des tooltips ===
				        var myTooltip = d3.select("#svgdiv")
						    .append("div")
						    .attr("class", "myTooltip")
							  .style("opacity", 0);  // elles sont invisibles de base
				        // =================================

				        var focus = root,   // focus initial sur le root (variable contenant tout l'arbre de données) récupérée dans le JSON
				            nodes = pack.nodes(root),
				            view;

				        var circle = svg.selectAll("circle")
				            .data(nodes)
				            .enter()
				            .append("circle")
				            .attr("class", function (d) {
				            return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root";
				           // si le cercle a un parent mais pas d'enfant = feuille ; si enfant mais pas parent = root si enfant et parent = noeud 

				            })

				            .style("fill", function (d) {
				            return d.children ? color(d.depth) : null;
				            // colorie les cercles par rapport à leur profondeur dans l'arbre de données (depth =0=>root). La couleur des feuilles est définie dans le css
				            }) 

				            .on("click", clickFct) 
				            .on("mouseover",mouseover)
				            .on("mouseout",mouseout)

				        // Fonction définissant l'apparition des tooltips lors du passage de la souris sur une feuille
				        function mouseover(d) {
				        	if(d3.select(this).classed("node--leaf")){
					           myTooltip.html(d.name)
					        /*.style("left", (d3.event.pageX + 10) + "px")
						        .style("top", (d3.event.pageY - 10) + "px")*/    // NB : petit problème d'affichage des tooltips lors du zoom ...
						        .style("left", (d.x)+"px")
						        .style("top", (d.y) +"px")
						        .style("opacity", 1);
				          }
				        };

				        // Fonction définissant la disparition des tooltips lorsque la souris sort d'une feuille
								function mouseout(d) {      
								  myTooltip.style("opacity", 0);
								}


				        // Fonction définissant le click sur un cercle. S'il s'agit d'une feuille, le volet d'information affiche la fiche du projet
				        function clickFct(d,i) {  // i = place dans l'arbre Json (0 = forcesvives = root)
				          if(d3.select(this).classed("node--leaf")){
				            if (focus !== d){  // si on n'est pas centré sur le focus, on zoom dessus 
				              zoom(d.parent);
				              d3.event.stopPropagation();  // fonction qui permet le zoom 
				            }  
				          }
				          else {
				           if (focus !== d){  // si on n'est pas centré sur le focus, on zoom dessus 
				              zoom(d);
				              d3.event.stopPropagation();  
				            }  
				          }
				        }

				        var text = svg.selectAll("text")
				            .data(nodes)
				            .enter().append("text")
				            .attr("class", "label")
				            .style("fill-opacity", function (d) {
				            return d.parent === root ? 1 : 0; // opacité transparent si non feuille 
				            })

				            .style("display", function (d) {
				            return d.parent === root ? "inline" : "none";   										
				            })

				            .text(function (d) {  
				              var thisNode = d3.select(this);
				              return d.name;
				            });


							  // ================================ Mise en forme du texte ============================================
				        // Fonction qui se charge de gérer l'affichage du texte dans les cercles de façon à ce que celui-ci ne dépasse pas en largeur
				        // NB : à améliorer pour prendre en compte la hauteur
				        // + problème à résoudre : récupérer le 'nouveau' rayon (changement de celui-ci lors du zoom)
						    function wrap(name, rayon, el){
							    var words = name.split(/\s+/).reverse(); // découpage en mots + reverse : premier mot devient le dernier et le dernier devient le premier
							    el.text('');
							    var	word,
							    	saveSpan = [],
							    	line = [],
							    	lineNumber = 0,
							    	lineHeight = 30,
							    	y = el.attr("y"),
							    	valY = 0,
							    	dy = parseFloat(el.attr("dy"))
							    var tspan = el.append("tspan").attr("x",0).attr("y",valY).attr("dy", 0);
							    saveSpan.push(tspan);  // pour garder en mémoire les différents tspan pour un même titre (sert à pouvoir les modifier si nb ligne > 3) (à voir pour meilleure façon de faire)
						    	while (word = words.pop()){  // tant qu'il y a des mots (parcours de tous les mots)
						    		line.push(word);  // ajoute le mot à la ligne
						    		tspan.text(line.join(" "));  // ajoute la ligne en texte
						    		//alert(d.name+" "+tspan.node().getBBox().height); // à creuser pour prendre en compte également la hauteur...
						    		if (tspan.node().getComputedTextLength() >= rayon*2){  // si la taille du texte après ajout d'un mot dépasse le diamètre (r*2) du cercle, on retire le mot et on va à la ligne
						    			line.pop(); 
						    			tspan.text(line.join(" ")); 
						    			line = [word];
						    			tspan = el.append("tspan").attr("x",0).attr("y",valY).attr("dy",++lineNumber*lineHeight).text(word);
						    			saveSpan.push(tspan);
						    		}
						    	}
				          // La partie ci-dessous se charge de recentrer le texte si celui-ci est affiché sur plus de 3 lignes (à améliorer/optimiser?)
						    	lineNumber = lineNumber+1;
						    	if (lineNumber >= 3){ // s'il y a au moins 3 lignes, on réajuste y pour centrer verticalement les titres
						    		if((lineNumber % 2) == 0){  // nombre de ligne pair
						    			while (maSpan = saveSpan.pop()){
						    				var mult = (lineNumber/2)-1
						    	    		maSpan.attr('y',-lineHeight*mult);
						    	    	}
						    		}
						    		else {
						    			while (maSpan = saveSpan.pop()){ // nombre de ligne impair
						    				var mult = ~~(lineNumber/2);
						    	    		maSpan.attr('y',-lineHeight*mult);
						    	    	}
						    		}
						    	}
						    };

				        // application de la fonction wrap dés le chargement de la page
						    svg.selectAll('text').each(function(d){
						     	return wrap(d.name, d.r, d3.select(this))
						    });

				        var node = svg.selectAll("circle,text");

				        d3.select("body")
				            .style("background", color(-2))  // change la couleur du fond avec une couleur proche du cercle root (voir plages plus haut)
				            .on("click", function () {   
				             // zoom(root);         // zoom sur le cercle root si on clique à l'exterieur de tout noeud  
				            });

				        zoomTo([root.x, root.y, root.r * 2 + margin]);

				        function zoom(d) {
				          var focus0 = focus;
				          focus = d;

				          var transition = d3.transition()
				              .duration(d3.event.altKey ? 7500 : 750)
				              .tween("zoom", function (d) {
				                var i = d3.interpolateZoom(view, [focus.x, focus.y, focus.r * 2 + margin]); // i contient les coordonnées du point à zoomer
				                return function (t) {
				                  zoomTo(i(t));
				                };
				              });

				          // affichage des textes selon si le zoom est centré sur les cercles correspondant ou non
				          var t = transition.selectAll("text")
				              .filter(function (d) {
				                return d.parent === focus || this.style.display === "inline";
				              })
				              .style("fill-opacity", function (d) {
				                return d.parent === focus ? 1 : 0;
				              })
				              .each("start", function (d) {
				                if (d.parent === focus) this.style.display = "inline"; 
				              })															
				              .each("end", function (d) {
				                if (d.parent !== focus) this.style.display = "none"; 
				              })

				          // Le wrap du text est réappliqué lors du zoom afin de prendre en compte le nouveau rayon des cercles
				          // La 'pause' de 100 milisec sert à s'assurer que les text ont bien été affichés (transition) pour être sur que getComputedLength (fonction wrap) ne renvoie pas 0   
				      		setTimeout(function(){
				      			var txt = transition.selectAll('text').each(function(d){
				         			return wrap(d.name, d.r, d3.select(this))
				        		});
				      		},100)
				        }

				        function zoomTo(v) {
				          //alert(v[2]);
				          var k = diameter / v[2];
				          view = v;
				          node.attr("transform", function (d) {
				              return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")";
				          });
				          circle.attr("r", function (d) {  // modification du rayon
				              return d.r * k;
				          });
				        }
				        d3.select(self.frameElement).style("height", diameter + "px");
           			},
           			'json' // A CHECK?
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
