//**  Sopro in an interactive web-based collaborative brainstorming tool.
//**  SoPro Copyright (C) 2013  Alvynn CONHYE, Marion DISTLER, Elodie DUFILH, Anthony OSMAR & Maxence VERNEUIL
//**
//**    This program is free software: you can redistribute it and/or modify
//**    it under the terms of the GNU General Public License as published by
//**    the Free Software Foundation, either version 3 of the License, or
//**    (at your option) any later version.
//**
//**    This program is distributed in the hope that it will be useful,
//**    but WITHOUT ANY WARRANTY; without even the implied warranty of
//**    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//**    GNU General Public License for more details.
//**
//**    You should have received a copy of the GNU General Public License
//**    along with this program.  If not, see <http://www.gnu.org/licenses/>. **/

var width = 960,
    height = 500,
    factor = 3;
    color = d3.scale.category20();

// mouse event vars
var selected_node = null,
    selected_link = null,
    mousedown_link = null,
    mousedown_node = null,
    mouseup_node = null;

// init svg
var outer = d3.select("#chart")
    .append("svg:svg")
    .attr("width", width)
    .attr("height", height)
    .attr("pointer-events", "all");

var vis = outer
  .append('svg:g')
    .call(d3.behavior.zoom().on("zoom", rescale))
    .on("dblclick.zoom", null)
  .append('svg:g')
    .on("mousedown", mousedown)

vis.append('svg:rect')
    .attr('width', factor*width)
    .attr('height', factor*height)
    .attr('fill', 'white');
    
vis.attr("transform",
      "translate(" + (-(width*factor/2-width/2))+","+(-(height*factor/2-height/2))+ ")"
      + " scale(1)");
    
// init force layout
var force = d3.layout.force()
    .size([factor*width, factor*height])
    .nodes([]) // initialize with a single node
    .linkDistance(75)
    .charge(function(d) { if(d.degree==0) return -9000; else return (-2000 + 100*d.degree) })
    .on("tick", tick);


// line displayed when dragging new nodes
var drag_line = vis.append("line")
    .attr("class", "drag_line")
    .attr("x1", 0)
    .attr("y1", 0)
    .attr("x2", 0)
    .attr("y2", 0);

// get layout properties
var nodes = force.nodes(),
    links = force.links(),
    node = vis.selectAll(".node"),
    link = vis.selectAll(".link");
    
//Variable utilisé pour initialisé l'ID unique des noeuds et des groups
var lastId = 0;
var lastGroup = 0;


(function foo(){
       	load();
       	setTimeout(function(){redraw();},500);
    })()



function mousedown() {
  if (!mousedown_node && !mousedown_link) {
    // allow panning if nothing is selected
    vis.call(d3.behavior.zoom().on("zoom"), rescale);
    return;
  }
}



function resetMouseVars() {
  mousedown_node = null;
  mouseup_node = null;
  mousedown_link = null;
}

function tick() {
  link.attr("x1", function(d) { return d.source.x; })
      .attr("y1", function(d) { return d.source.y; })
      .attr("x2", function(d) { return d.target.x; })
      .attr("y2", function(d) { return d.target.y; });

  node.attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; })
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
}

// rescale g
function rescale() {
  trans=d3.event.translate;
  scale=d3.event.scale;
  
  vis.attr("transform",
      "translate(" + (-(width*factor/2-width/2)+trans[0])+","+(-(height*factor/2-height/2)+trans[1])+ ")"
      + " scale("+ scale +")");
}

/*******************************************************************LOAD***********************************************************************************************/
function load() {
d3.json("/View/assets/json/"+document.getElementById("brainstormhidden").value+".json", function (json) {
		lastGroup = json.lastGroup;
		nodes = json.nodes;
		force.nodes(nodes);
		links = json.links;
		for (var i = 0; i < links.length; i++)
		{
			var match = function(){
			var count = 0;
				for (var j = 0; j<nodes.length; j++)
				{
					if (nodes[j].id == links[i].target){
						links[i].target = nodes[j];
						count++;
					}
					if (nodes[j].id == links[i].source){
						links[i].source = nodes[j];
						count++;
					}
					if(count==2){
						break;
					}
				}
			}
			match();
		}
		force.links(links);
	});
}

/*********************************************************************REDRAW*******************************************************************************************/
function redraw() {

  link = link.data(links);

  link.enter().insert("line", ".node")
      .attr("class", "link")
      .attr("selected",function(d){return d.selected});


  //Retirer les liens en trop
  link.exit().remove();

 /* link
    .classed("link_selected", function(d) { return d === selected_link; });*/

    	
    	node = vis.selectAll(".node");
    	node = node.data(nodes);
    	node.enter().append("g")
    	.attr("class","node")
    	.attr("selected",function(d){return d.selected})
    	.style("fill", function(d) { return color(d.group); })
        .on("mousedown", 
        function(d) { 
          // disable zoom
          vis.call(d3.behavior.zoom().on("zoom"), null);
          mousedown_node = d;
          if (mousedown_node == selected_node) selected_node = null;
          else selected_node = mousedown_node; 
          redraw(); 
        })
       .on("mouseup", 
        function(d) { 
          if (mousedown_node) {
            mouseup_node = d; 
            ToHtml(mouseup_node); 
            if (mouseup_node == mousedown_node) {
            	//Si le point n'a pas déjà été voté
            	if(mouseup_node.selected != true){
	            	//Vote pour l'idée
	            	vote(mouseup_node);
            	}
            	else{
	            	//Enlevée le vote positif sur l'idée
	            	unvote(mouseup_node);
            	}
            	resetMouseVars(); 
            	redraw();
            	return; 
            }            

            // enable zoom
            vis.call(d3.behavior.zoom().on("zoom"), rescale);
            force.resume();
            redraw();
          } 
        })
    
  
        circle = node.selectAll("circle").data(function(d){return [d.index];})
        			.transition()
        			.duration(750)
        			.ease("elastic")
        			.attr("r", 10);
  		circle = node.selectAll("circle").data(function(d){return [d.index];}).enter().append("circle")
        			.transition()
        			.duration(750)
        			.ease("elastic")
        			.attr("r", 10);	  		
  		text = node.selectAll("text").data(function(d){return [d.name];})
        			.attr("dx", 12)
        			.attr("dy", ".35em")
        			.text(function(d) { return d; });
        		
        text = node.selectAll("text").data(function(d){return [d.name];}).enter().append("text")
        			.attr("dx", 12)
        			.attr("dy", ".35em")
        			.text(function(d) { return d; });
	    

  node.exit().transition()
      .attr("r", 0)
    .remove();
   
  node
    .classed("node_selected", function(d) { return d.selected === true; }); 
  link
    .classed("link_selected", function(l) { return l.selected === true; }); 
    
  if (d3.event) {
    // prevent browser's default behavior
    d3.event.preventDefault();
  }
  force.start();  

}

//Vote pour un noeud et recursivement pour ses parents
function vote(selectednode){
	var chosenlink;
	var cont=0;
	selectednode.selected= true;
	var nodeParent = nodes.filter(function(d) { return (d.id == selectednode.parent); });
	if(typeof nodeParent[0] != 'undefined'){
        if(nodeParent[0].className != "node node_selected" && selectednode.degree!=0){
	        cont = 1;
        }else{
	        chosenlink = links.filter(function(l) { return (l.source === nodeParent[0]) && (l.target === selectednode); })
	        chosenlink[0].selected=true;
        }
    }
    //Select all parent node that are not selected plus the links between them
	while(cont){
		cont=0;
		nodeParent[0].selected=true;
		chosenlink = links.filter(function(l) { return (l.source === nodeParent[0]) && (l.target === selectednode); })
		chosenlink[0].selected=true;
        selectednode = nodeParent[0];
        nodeParent = nodes.filter(function(d) { return (d.id == selectednode.parent); });
        if(typeof nodeParent[0] != 'undefined'){
	        if(nodeParent[0].selected !=true && selectednode.degree!=0){
		        cont = 1;
	        }else{
		        chosenlink = links.filter(function(l) { return (l.source === nodeParent[0]) && (l.target === selectednode); })
		        chosenlink[0].selected=true;
	        }
        }
    }
}

//Unvote pour un noeud et recursivement pour ses parents
function unvote(selectednode){
    //declarations
    var nodeToDo = new Array();
    var compteur = 0;
    var tempdebut;
    var tempfin;
    var ajout;
    //deselection du noeud
    selectednode.selected=false;
    //deselection du lien avec le parent du noeud
    if(selectednode.degree !=0){
	    chosenlink = links.filter(function(l) { return l.target === selectednode; })
		chosenlink[0].selected=false;
	}
    //Rechercher les noeuds ayant pour parent le noeud seletionné
    if(selectednode.hasChild !=0){
    	var nodeEnfants = nodes.filter(function(d) { return (d.parent == selectednode.id); });
	    for(i=0; i<nodeEnfants.length; i++){
		    if(nodeEnfants[i].selected==true){
		    	nodeToDo[compteur]=nodeEnfants[i];
		    	compteur = compteur+1;
		    	ajout = true;
		    }
	    }
    }
    //Recherche de tous les noeuds enfants des précédents

	for(i=0; i<nodeToDo.length; i++){
		console.log(nodeToDo[i].name);
		nodeEnfants = nodes.filter(function(d) { return (d.parent == nodeToDo[i].id); });
		for(j=0; j<nodeEnfants.length; j++){
		    if(nodeEnfants[j].selected==true){
		    	nodeToDo[compteur]=nodeEnfants[j];
		    	compteur = compteur+1;	
		    }
	    }
	}
	
		
		//déselection des noeuds et des liens
	    for(i=0; i<nodeToDo.length; i++){
		    nodeToDo[i].selected=false;
		    chosenlink = links.filter(function(l) { return l.target === nodeToDo[i]; })
			chosenlink[0].selected=false;
	    }  
}

//Recupération du XML Http Request handler
function getXhr(){
	var xhr = null; 
	if(window.XMLHttpRequest) // Firefox et autres
	   xhr = new XMLHttpRequest(); 
	else if(window.ActiveXObject){ // Internet Explorer 
	   try{
	       xhr = new ActiveXObject("Msxml2.XMLHTTP");
	   } catch(e){
	       xhr = new ActiveXObject("Microsoft.XMLHTTP");
	   }
	}
	else{ // XMLHttpRequest non supporté par le navigateur 
	   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
	   xhr = false; 
	} 
	return xhr;
}
//Affiche les informations relatives au noeud( nom + commentaires) - Sans possibilité d'update
function ToHtml(node)
{
	document.getElementById("nodeId").innerHTML = "<input type='hidden' id='nodeIdValue' value='"+node.id+"'>";
	document.getElementById("nodeInfo").innerHTML = ""+node.name+"";
	if(node.comment!="" && node.comment!=null)
	 document.getElementById("nodeInfo2").innerHTML = ""+node.comment+"";   

}
