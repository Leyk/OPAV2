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