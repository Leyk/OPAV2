<?php
  require_once "inc/_var_fv.php";
  $vitesse = intval($_GET['vitesse']);
  $mode_dernier = intval($_GET['dernier']);
  $mode_toutes = intval($_GET['toutes']);
  if ($mode_dernier && !$vitesse) $vitesse = 60; // 60 secondes par slide pour le mode dernier

  if ($mode_toutes)
    $statut = "developper+idee+partager+importOPA";
  else
    $statut = "developper+idee+partager";
?>
<!doctype html>
<html class="no-js" lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta HTTP-EQUIV="Refresh" CONTENT="<?php echo ($mode_dernier||$mode_toutes?180:300); ?>">
    <title>Forces Vives : Journée des initiatives citoyennes</title>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/fv.css" />
    <script src="js/vendor/modernizr.js"></script>
    <style type="text/css">
      html {font-size: 80%;}
      header, footer {
        padding: 0; }
      header h2 {
        color: #FF9900;
        font-size: 2em;
        margin-bottom: 0; }
      .panel.callout a:not(.button), a {
        color: #FF9900; }
      .row {
        max-width: 100% }
        .contenufi {
          margin-bottom: 2em; }

        p {
          font-size: 1.15em;
          line-height: 1.2em;
          margin-bottom: .7rem;}
        ul, ol, dl {
        font-size: 1.15em; }
        
        header h1.logo {
          margin: 0;
          font-size: 3.8em;
        }
        .panel.callout {
          font-size: 1.15em;
        }
        #toutes {
          font-size: 2em;
          margin-top: 150px;
          margin-left: 1.5em;
        }
        #toutes .rubliste {
          font-size: .7em;
          color: #FF9900  }
        .headerliste {
          position: fixed;
          top: 0;
          width: 100%;
        }

      /* Orbit Graceful Loading */
      .slideshow-wrapper {
        position: relative; }
        .slideshow-wrapper ul {
          list-style-type: none;
          margin: 0; }
          .slideshow-wrapper ul li,
          .slideshow-wrapper ul li .orbit-caption {
            display: none; }
          .slideshow-wrapper ul li:first-child {
            display: block; }
        .slideshow-wrapper .orbit-container {
          background-color: transparent; }
          .slideshow-wrapper .orbit-container li {
            display: block; }
            .slideshow-wrapper .orbit-container li .orbit-caption {
              display: block; }
          .slideshow-wrapper .orbit-container .orbit-bullets li {
            display: inline-block; }
        .slideshow-wrapper .preloader {
          display: block;
          width: 40px;
          height: 40px;
          position: absolute;
          top: 50%;
          left: 50%;
          margin-top: -20px;
          margin-left: -20px;
          border: solid 3px;
          border-color: #555555 white;
          border-radius: 1000px;
          animation-name: rotate;
          animation-duration: 1.5s;
          animation-iteration-count: infinite;
          animation-timing-function: linear; }

      .orbit-container {
        overflow: hidden;
        width: 100%;
        position: relative;
        background: none; }
        .orbit-container .orbit-slides-container {
          list-style: none;
          margin: 0;
          padding: 0;
          position: relative;
          -webkit-transform: translateZ(0); }
          .orbit-container .orbit-slides-container img {
            display: block;
            max-width: 100%; }
          .orbit-container .orbit-slides-container > * {
            position: absolute;
            top: 0;
            width: 100%;
            margin-left: 100%; }
            .orbit-container .orbit-slides-container > *:first-child {
              margin-left: 0%; }
            .orbit-container .orbit-slides-container > * .orbit-caption {
              position: absolute;
              bottom: 0;
              background-color: rgba(51, 51, 51, 0.8);
              color: white;
              width: 100%;
              padding: 0.55556rem 0.77778rem;
              font-size: 0.77778rem; }
        .orbit-container .orbit-slide-number {
          position: absolute;
          top: 10px;
          left: 10px;
          font-size: 12px;
          color: white;
          background: transparent;
          z-index: 10; }
          .orbit-container .orbit-slide-number span {
            font-weight: 700;
            padding: 0.27778rem; }
        .orbit-container .orbit-timer {
          position: absolute;
          top: 12px;
          right: 10px;
          height: 6px;
          width: 100px;
          z-index: 10; }
          .orbit-container .orbit-timer .orbit-progress {
            height: 5px;
            background-color: rgba(255, 255, 255, 0.3);
            display: block;
            width: 0%;
            position: relative;
            right: 20px;
            top: 5px; }
          .orbit-container .orbit-timer > span {
            display: none;
            position: absolute;
            top: 0px;
            right: 0;
            width: 11px;
            height: 14px;
            border: solid 4px black;
            border-top: none;
            border-bottom: none; }
          .orbit-container .orbit-timer.paused > span {
            right: -4px;
            top: 0px;
            width: 11px;
            height: 14px;
            border: inset 8px;
            border-left-style: solid;
            border-color: transparent;
            border-left-color: black; }
            .orbit-container .orbit-timer.paused > span.dark {
              border-left-color: #333333; }
        .orbit-container:hover .orbit-timer > span {
          display: block; }
        .orbit-container .orbit-prev,
        .orbit-container .orbit-next {
          position: absolute;
          top: 45%;
          margin-top: -25px;
          width: 36px;
          height: 60px;
          line-height: 50px;
          color: white;
          background-color: transparent;
          text-indent: -9999px !important;
          z-index: 10; }
          .orbit-container .orbit-prev:hover,
          .orbit-container .orbit-next:hover {
            background-color: rgba(0, 0, 0, 0.3); }
          .orbit-container .orbit-prev > span,
          .orbit-container .orbit-next > span {
            position: absolute;
            top: 50%;
            margin-top: -10px;
            display: block;
            width: 0;
            height: 0;
            border: inset 10px; }
        .orbit-container .orbit-prev {
          left: 0; }
          .orbit-container .orbit-prev > span {
            border-right-style: solid;
            border-color: transparent;
            border-right-color: black; }
          .orbit-container .orbit-prev:hover > span {
            border-right-color: white; }
        .orbit-container .orbit-next {
          right: 0; }
          .orbit-container .orbit-next > span {
            border-color: transparent;
            border-left-style: solid;
            border-left-color: black;
            left: 50%;
            margin-left: -4px; }
          .orbit-container .orbit-next:hover > span {
            border-left-color: black; }

      .orbit-bullets-container {
        text-align: center; }

      .orbit-bullets {
        margin: 0 auto 30px auto;
        overflow: hidden;
        position: relative;
        top: 10px;
        float: none;
        text-align: center;
        display: block; }
        .orbit-bullets li {
          cursor: pointer;
          display: inline-block;
          width: 0.5rem;
          height: 0.5rem;
          background: #FF9900;
          float: none;
          margin-right: 6px;
          border-radius: 1000px; }
          .orbit-bullets li.active {
            background: #FFCC00; }
          .orbit-bullets li:last-child {
            margin-right: 0; }

      .touch .orbit-container .orbit-prev,
      .touch .orbit-container .orbit-next {
        display: none; }
      .touch .orbit-bullets {
        display: none; }

      @media only screen and (min-width: 40.063em) {
        .touch .orbit-container .orbit-prev,
        .touch .orbit-container .orbit-next {
          display: inherit; }
        .touch .orbit-bullets {
          display: block; } }
      @media only screen and (max-width: 40em) {
        .orbit-stack-on-small .orbit-slides-container {
          height: auto !important; }
        .orbit-stack-on-small .orbit-slides-container > * {
          position: relative;
          margin: 0% !important;
          opacity: 1 !important; }
        .orbit-stack-on-small .orbit-slide-number {
          display: none; }

        .orbit-timer {
          display: none; }

        .orbit-next, .orbit-prev {
          display: none; }

        .orbit-bullets {
          display: none; } }

    </style>

  </head>
  <body>
      

<?php

    // Affichage du contenu

    if ($mode_dernier)
    {
        $oblimit = "ORDER BY dateheure_ajout DESC LIMIT 0,3";
    } elseif($mode_toutes) {
        $oblimit = "ORDER BY dateheure_ajout DESC";       
    } else {
        $mode_aleatoire = true;
        $oblimit = "ORDER BY RAND() LIMIT 0,20";
    }


    $statut = explode("+", $statut);
    $where_statut = "( initiative_statut = '".$statut[0]."'";
    for($i=1;$i<=count($statut);$i++)
    {
      $where_statut .= " OR initiative_statut = '".$statut[$i]."'";
    }
    $where_statut .= ")";

    $sql = "SELECT * 
              FROM actions_initiatives 
              WHERE afficher > 0 
                AND initiative_titre != '' 
                AND ".$where_statut." ".$oblimit;
    // echo $sql;
    $rs = $connexion->prepare($sql);

    $rs->execute() or die ("Erreur : ".__LINE__." : ".$sql);
    $nb_actions = $rs->rowCount();
    if ($nb_actions) {
      $ret .= "<header".($mode_toutes?" class='headerliste'":"").">
        <div class='row'>
          <div class='large-12 columns'>
            <h2>Labo des initiatives citoyennes : 11 octobre 2014</h2>";
      if ($mode_aleatoire) 
        $ret .= "<h1 class='logo'>Initiatives inscrites aujourd'hui</h1>";
      elseif ($mode_toutes)
        $ret .= "<h1 class='logo'>Toutes les initiatives</h1>";
      elseif ($mode_dernier)
        $ret .= "<h1 class='logo'>Derniers projets</h1>";
      
      $ret .= "</div>
        </div>
      </header>";
      if ($mode_aleatoire || $mode_dernier) 
        $ret .= "<ul data-orbit>\n";
      elseif ($mode_toutes)
        $ret .= "<ul id='toutes'>\n";

      while ($r = $rs->fetch(PDO::FETCH_ASSOC))
      {
        if ($mode_toutes)
        {
          $rubriques = "";
          $i=0;
          // liste de toutes les initiatives
          $ret .= "<li>".$r["initiative_titre"]."\n";

          // récupération des rubriques associées
          $sqlrub = "SELECT titre, id_centreinteret
                    FROM actions_initiatives_rubriques I, actions_rubriques R
                    WHERE I.id_rubrique = R.id
                      AND id_initiative = :id
                    LIMIT 0,10";
          $rsrub = $connexion->prepare($sqlrub);
          $rsrub->execute(array(':id' => $r["id"])) or die ("Erreur : ".__LINE__." : ".$sqlrub);
          $nbrub = $rsrub->rowCount();
          if ($nbrub) {
            while ($u = $rsrub->fetch(PDO::FETCH_ASSOC))
            {
              if (!$i)
                $rubriques .= "[ ";
              else
                $rubriques .= ", ";
              $i++;
              $rubriques .= $u["titre"];
            }
            if (!empty($rubriques)) $rubriques .= " ]";

          } // nbrub

          $ret .= "<span class='rubliste'>".$rubriques."</span>";

          $ret .= "</li>\n";

        }
        else
        {

          if ($mode_aleatoire || $mode_dernier) $ret .= "<li><div class='slide'>\n";


          $ret .= "<div class='row contenufi'><section class='presentation'>
            <div class='large-12 medium-12 text-center'>
                <h1>".$r["initiative_titre"]."</h1>
            </div>     
          </section>
          </div>";

          $ret .= "<div class='row'>";
            $ret .= "<div class='small-8 columns'>";

              $dateajout = datefr($r["dateheure_ajout"],$avecheure=true);

              // statut
              switch ($r["initiative_statut"]) {
                case 'idee':
                    $ret .= "<div class='panel callout'>Idée d'action";
                  break;
                case 'importOPA':
                    $ret .= "<div class='panel callout'>Initiative importée du site <a href='http://www.onpassealacte.fr' target='_blank'>www.onpassealacte.fr</a>";
                  break;
                case 'partager':
                    $ret .= "<div class='panel callout'>Partage d'expérience";
                  break;
                case 'developper':
                    $ret .= "<div class='panel callout'>Action en cours, à développer";
                  break;
              }
              if ($r["dateheure_ajout"] != "0000-00-00 00:00:00")
                $ret .= " posté(e) le ".$dateajout;

                // récupération des rubriques associées
                $sqlrub = "SELECT titre, id_centreinteret
                          FROM actions_initiatives_rubriques I, actions_rubriques R
                          WHERE I.id_rubrique = R.id
                            AND id_initiative = :id
                          LIMIT 0,10";
                $rsrub = $connexion->prepare($sqlrub);
                $rsrub->execute(array(':id' => $r["id"])) or die ("Erreur : ".__LINE__." : ".$sqlrub);
                $nbrub = $rsrub->rowCount();
                if ($nbrub) {
                  $i = 0;
                  $rubriques = 0;
                  while ($u = $rsrub->fetch(PDO::FETCH_ASSOC))
                  {
                    if (!$i)
                      $rubriques .= "<br/>Rubrique".($nbrub>1?"s":"")." : ";
                    else
                      $rubriques .= ", ";
                    $i++;
                    $rubriques .= $u["titre"];

                    // récupération des centre d'intérêt associés
                    $ce_centresinteret = nom_centreinteret($u["id_centreinteret"]);
                    if (!strstr($centresinteret,$ce_centresinteret))
                    {
                      if (!strlen($centresinteret))
                        $centresinteret .= "<br/>Centre".($nbci>1?"s":"")." d'intérêt : ";
                      else
                        $centresinteret .= ", ";                
        
                      $centresinteret .= $ce_centresinteret;
                    }
                    
                  }
                } // nbrub

                $ret .= $rubriques;
                $ret .= $centresinteret;
        
              $ret .= "</div>";


              if (!empty($r["initiative_description"]))
                $ret .= "<p>".$r["initiative_description"]."</p>";

              if (!empty($r["journee_demande"]))
                $ret .= "<p><strong>Quels sont vos besoins, votre demande pour aujourd'hui ?</strong><br/>".$r["journee_demande"]."</p>";
              if (!empty($r["initiative_besoins"]))
                $ret .= "<p><strong>Quelles sont vos besoins actuels ?</strong><br/>".$r["initiative_besoins"]."</p>";
              if (!empty($r["initiative_motivation"]))
                $ret .= "<p><strong>Quelles sont vos motivations ?</strong><br/>".$r["initiative_motivation"]."</p>";

            $ret .= "</div>";
            $ret .= "<div id='coordonnees' class='small-4 columns'>";
            $ret .= "<div class='callout panel'>";

              if (!empty($r["posteur_nom"]))
                $ret .= "<strong>Coordonnées de l'initiateur :</strong><br/>".$r["posteur_nom"]."<br/>";
              if (!empty($r["posteur_email"]))
                $ret .= "<a href='mailto:".$r["posteur_email"]."'>".$r["posteur_email"]."</a><br/>";
              if (!empty($r["posteur_siteweb"]))
                $ret .= "<strong>Site : </strong><a href='mailto:".$r["posteur_siteweb"]."' target='_blank'>".$r["posteur_siteweb"]."</a><br/>";
              if (!empty($r["posteur_coordonnees"]))
                $ret .= "<p>".$r["posteur_coordonnees"]."</p>";

            $ret .= "</div></div>";
          $ret .= "</div>";


          $ret .= "</div>";
          if ($mode_aleatoire || $mode_dernier) $ret .= "\n</li>\n";
        }

      }
      if ($mode_toutes) $ret .= "<div id='finliste'></div>\n";
      if ($mode_aleatoire || $mode_dernier) $ret .= "</ul>\n";
    }
    else $ret = "Aucune action dans cette rubrique.";


    echo $ret;
?>


    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>

    <script>
      $(document).foundation({
        orbit: {
          animation: 'slide',
          timer_speed: <?php echo $vitesse*1000; ?>,
          pause_on_hover: false,
          animation_speed: 500,
          navigation_arrows: false,
          slide_number: false,
          slide_number_text: 'sur',
          bullets: false
        }
      });

      $(function() {
        <?php
          // défillement
          if ($mode_toutes)
            echo "$('html, body').animate({scrollTop: $('#finliste').offset().top }, 180000, 'linear');";
        ?>

      });      

    </script>
  </body>
</html>
