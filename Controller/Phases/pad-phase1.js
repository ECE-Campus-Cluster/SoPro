var idB = 	document.getElementById("brainstormhidden").value;

var width = 960,
    height = 500,
    factor = 3;
    color = d3.scale.category20();

// mouse event vars
var selected_node = null,
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
    .on("mousemove", mousemove)
    .on("mousedown", mousedown)
    .on("mouseup", mouseup);

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
	currentNodes = force.nodes(),
    links = force.links(),
    node = vis.selectAll(".node"),
    link = vis.selectAll(".link");
    
//Variable utilisé pour initialisé l'ID unique des noeuds et des groups
var lastId = 0;
var lastGroup = 0;


// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// 

var socket;
var firstconnect = true;

/*******************************************************************LOAD***********************************************************************************************/
function load() {
d3.json("/View/assets/json/"+document.getElementById("brainstormhidden").value+".json", function (json) {
		//récupération du tableau ouffissime qui est sur le serveur !!!!!!! ^^
		console.log("djson",json);
		nodes = json.nodes;
		lastGroup = json.lastGroup;
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

function connect() {
  if(firstconnect) {
    socket = io.connect('10.0.1.18',{port:8080});
    socket.on('connect', function(){ 
    	console.log("Connected to Server"); 
    	socket.emit('brainstorm', '{"brainstorm":"'+ idB +'","idSender":"'+ socket.socket.sessionid +'"}' );
    });
    socket.on('disconnect', function(){ console.log("Disconnected from Server");});
    socket.on('reconnect', function(){ console.log("Reconnected to Server"); 
    									$('#ModalReconnexion').modal('hide');
    									load(); 
    									redraw(); 
    									sforce.start(); 
    									});
    socket.on('reconnecting', function( nextRetry ){  
				    			$('#ModalReconnexion').modal({
									show: true,
						    		backdrop: 'static',
						    		keyboard: false
						    		});
						    		console.log("Reconnecting in "  + nextRetry + " seconds"); 
						    		document.getElementById('tentative').innerHTML = nextRetry/1000 +" s"; });
    socket.on('reconnect_failed', function(){console.log("Reconnect Failed"); });
    socket.on('error' ,function(){ $('#ModalConnexion').modal({
									show: true,
						    		backdrop: 'static',
						    		keyboard: false
						    		})});
    //ADD
    socket.on('resultAddNode', function(data){ addNodeServer(data); });
    //DELETE
    socket.on('resultDeleteNode', function(data){ deleteNodeServer(data); });
    //Update
    socket.on('resultUpdateNode', function(data){ updateNodeServer(data); });
    //nextPhase
    socket.on('nextPhase', function(){ console.log("next phase");  $('#ModalJumpStart').modal({
		    		show: true,
		    		backdrop: 'static',
		    		keyboard: false
		    		})});

        firstconnect = false;
  }
  else {
    socket.socket.reconnect();
  }
  
    
}
    
function disconnect() {
  socket.disconnect();
}
    

  
function esc(msg){
  return msg.replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

connect();

// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //// SOCKET //

// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT 


function addNodeServer(data){
	var data2 = JSON.parse(data); //decode du noeud recu
	var noeudAjout = data2.node;
	var parent = nodes.filter(function(d){return d.id == noeudAjout.parent;});
	if(parent!=null){
		parent[0].hasChild = parent[0].hasChild+1;
		nodes.push(noeudAjout);
		links.push({source: parent[0] , target: nodes[nodes.length-1]});
		if(lastGroup < noeudAjout.group) lastGroup=noeudAjout.group;
		force.start();
		redraw();
	}
}

function deleteNodeServer(data){
	var data2 = JSON.parse(data); //decode du noeud recu
	var noeudDelete = data2.node;
	noeud = nodes.filter(function(d){return d.id==noeudDelete.id;});
	toSplice = links.filter(function(l) { return (l.target === noeud[0]); });
	toSplice[0].source.hasChild = toSplice[0].source.hasChild-1;
	links.splice(links.indexOf(toSplice[0]), 1);
	nodes.splice(nodes.indexOf(noeud[0]),1);
	redraw();
}

function updateNodeServer(data){
	var data2 = JSON.parse(data); //decode du noeud recu
	var noeudUpdate = data2.node;
	correspondant = nodes.filter(function(d){return d.id == noeudUpdate.id;});
	correspondant[0].name = noeudUpdate.name;
	correspondant[0].comment = noeudUpdate.comment;
	redraw();
}

// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT OUTSIDE //// FCT 


// add keyboard callback
d3.select(window)
    .on("keydown", keydown);
	
load();
setTimeout(function(){redraw();},500);
setTimeout(function(){force.start();},500);



function mousedown() {
  if (!mousedown_node) {
    // allow panning if nothing is selected
    vis.call(d3.behavior.zoom().on("zoom"), rescale);
    return;
  }else{force.stop();}
}

function mousemove() {
  if (!mousedown_node) return;
  // update drag line
  drag_line
      .attr("x1", mousedown_node.x)
      .attr("y1", mousedown_node.y)
      .attr("x2", d3.mouse(this)[0])
      .attr("y2", d3.mouse(this)[1]);
}

function mouseup() {
	force.resume();
	var groupColor=0;
  //si le mouse down avait été fait sur un node
  if (mousedown_node) {
    // hide drag line
    drag_line
      .attr("class", "drag_line_hidden")
    //Relache de la souris à un endroit sans node => Creation d'un nouveau node et d'un nouveau lien
    if (!mouseup_node) {
      //Recuperation de la position de la souris
      if(mousedown_node.id==0)
	  {
			lastGroup++;
			groupColor=lastGroup;
	  }
	  else groupColor = mousedown_node.group;
      var point = d3.mouse(this),
      //creation d'un point
      node = {x: point[0], y: point[1], name:"Nouveau noeud", id:randomKey(), parent:mousedown_node.id, degree:mousedown_node.degree+1, hasChild:0, comment:"", group:groupColor};
      ToHtml(node);
      mousedown_node.hasChild=mousedown_node.hasChild+1;
      //Ajout du point à la liste des points
      n = nodes.push(node);
      //Selection du nouveau node
      selected_node = node;
      // Ajout d'un lien entre le nouveau node crée et celui duquel la souris était partie
      links.push({source: mousedown_node, target: node});
       //Remise en place de la force
      force.start();      
      /*ENVOIE DU MESSAGE D'AJOUT DU NOEUD AU SERVEUR*/
      var noeudString = JSON.stringify(node);
      var noeudSerial = '{"brainstorm":"'+ idB +'","node":'+noeudString+',"idSender":"'+socket.socket.sessionid+'"}';
      console.log("noeudString :",noeudString);
	  console.log("socket.id:",socket.socket.sessionid);
	  socket.emit('addNode', noeudSerial);
	  
	  //Redraw des datas
    redraw();
    }
  }
  // clear mouse event vars
  resetMouseVars();
}

function resetMouseVars() {
  mousedown_node = null;
  mouseup_node = null;
}

function tick() {
  link.attr("x1", function(d) { return d.source.x; })
      .attr("y1", function(d) { return d.source.y; })
      .attr("x2", function(d) { return d.target.x; })
      .attr("y2", function(d) { return d.target.y; });

  node.attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; });
  node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
}

// rescale g
function rescale() {
  trans=d3.event.translate;
  scale=d3.event.scale;
  
  vis.attr("transform",
      "translate(" + (-(width*factor/2-width/2)+trans[0])+","+(-(height*factor/2-height/2)+trans[1])+ ")"
      + " scale("+ scale +")");
}


/*********************************************************************REDRAW*******************************************************************************************/
function redraw() {

	console.log("redraw");
  link = link.data(links);
  link.enter().insert("line", ".node")
      .attr("class", "link");

  //Retirer les liens en trop
  link.exit().remove();
  
      	node = vis.selectAll(".node");
    	node = node.data(nodes);
    	node.enter().append("g")
    	.attr("class","node")
    	.attr("weight", function(d){return 1000 * (10*d.degree);})
        .on("mousedown", 
        function(d) { 
          // disable zoom
          vis.call(d3.behavior.zoom().on("zoom"), null);
          mousedown_node = d;
          if (mousedown_node == selected_node) selected_node = null;
          else selected_node = mousedown_node; 
          force.stop();
          // reposition drag line
          drag_line
              .attr("class", "link")
              .attr("x1", mousedown_node.x)
              .attr("y1", mousedown_node.y)
              .attr("x2", mousedown_node.x)
              .attr("y2", mousedown_node.y);

          redraw(); 
        })
      .on("mousedrag",
        function(d) {
          // redraw();
        })
      .on("mouseup", 
        function(d) { 
          if (mousedown_node) {
            mouseup_node = d; 
            ToHtml(d);
            if (mouseup_node == mousedown_node) { 
            	drag_line
            		.attr("class", "drag_line_hidden");
            	resetMouseVars(); 
            	return; 
            }            

            // enable zoom
            vis.call(d3.behavior.zoom().on("zoom"), rescale);
            force.resume();
            redraw();
          } 
        })
    
  
      	
  		text = node.selectAll("text").data(function(d){return [d]})
  				.style("fill", function(d) { return color(d.group); })
        		.attr("dx", 12)
        		.attr("dy", ".35em")
        		.text(function(d) {return d.name; });
        		
        text = node.selectAll("text").data(function(d){return [d];}).enter().append("text")
        		.style("fill", function(d) { return color(d.group); })
        		.attr("dx", 12)
        		.attr("dy", ".35em")
        		.text(function(d) { return d.name; });
				
		  circle = node.selectAll("circle").data(function(d){return [d];})
		  			.style("fill", function(d) { return color(d.group); })
        			.transition()
        			.duration(750)
        			.ease("elastic")
        			.attr("r", 10);
  		circle = node.selectAll("circle").data(function(d){return [d];}).enter().append("circle")
  					.style("fill", function(d) { return color(d.group); })
        			.transition()
        			.duration(750)
        			.ease("elastic")
        			.attr("r", 10);	  	
	    

  node.exit().transition()
      .attr("r", 0)
      .remove();

  node
    .classed("node_selected", function(d) { return d === selected_node; });
   
  if (d3.event) {
    // prevent browser's default behavior
    d3.event.preventDefault();
  }
  force.resume();
}

//Destruction des links reliés à un node
function spliceLinksForNode(node) {
  toSplice = links.filter(
    function(l) { 
      return (l.source === node) || (l.target === node); });
  toSplice.map(
    function(l) {
      links.splice(links.indexOf(l), 1); });
}

//Event si une touche est appuyée
function keydown() {
  //si aucun link ou node est selectionné sortir de la fonction
  if (!selected_node) return;
  //si backspace ou delete est appuyée
  switch (d3.event.keyCode) {
    case 46: { // delete
      //Si un noeud est selectionné
      if (selected_node && selected_node.hasChild == 0 && selected_node.degree!= 0) {
        //Destruction du node selectionné
        var parent_node = nodes.filter(function(d,i) { return (d.id == selected_node.parent); });
        if(typeof parent_node[0] !== 'undefined'){
	        parent_node[0].hasChild = parent_node[0].hasChild - 1;
	    }
        nodes.splice(nodes.indexOf(selected_node), 1);
        //Destruction les liens reliés au node selectionné
        spliceLinksForNode(selected_node);
        //Envoie de l'event au serveur
	      var noeudString = JSON.stringify(selected_node);
	      var noeudSerial = '{"brainstorm":"'+ idB +'","node":'+noeudString+',"idSender":"'+socket.socket.sessionid+'"}';
		  console.log("socket.id:",socket.socket.sessionid);
		  socket.emit('deleteNode', noeudSerial);
		  //Reset des valeurs de selection
		  selected_node = null;
		  ToHtml(null);
		  //Redraw
		  redraw();
      }
      break;
    }
  }
}

//Affiche les informations relatives au noeud( nom + commentaires)
function ToHtml(node)
{
	if(node){
		document.getElementById("nodeId").innerHTML = "<input type='hidden' id='nodeIdValue' value='"+node.id+"'>";
		document.getElementById("nodeInfo").innerHTML = "<input style='width:150px; margin-left:3px' type='text' maxlength='30' id='namepoint' placeholder='"+node.name+"'  onKeyPress='checkKey(event,"+'"'+"name"+'"'+");'><input type='button' style='margin-left:3px' class='btn' name='modifier' value='modifier' onclick='UpdateName();'> ";
		document.getElementById("nodeInfo2").innerHTML = "<textarea style='width:150px; margin-left:3px' id='comment' maxlength='30' rows='4' cols='10' >"+node.comment+"</textarea> <input type='button' class='btn' name='comment' style='margin-left:3px' value='modifier' name='comment' onclick='UpdateComment();'>";  
	}else{
		document.getElementById("nodeId").innerHTML = "<input type='hidden' id='nodeIdValue' value=''>";
		document.getElementById("nodeInfo").innerHTML = "<input style='width:150px; margin-left:3px' type='text' id='namepoint' placeholder=''  onKeyPress='checkKey(event,"+'"'+"name"+'"'+");'><input type='button' style='margin-left:3px' class='btn' name='modifier' value='modifier' onclick='UpdateName();'> ";
		document.getElementById("nodeInfo2").innerHTML = "<textarea style='width:150px; margin-left:3px' id='comment' rows='4' cols='10' ></textarea> <input type='button' class='btn' name='comment' style='margin-left:3px' value='modifier' name='comment' onclick='UpdateComment();'>";  
	}
}



function UpdateComment(){
	newComment=document.getElementById("comment").value;
	var nodeModif = nodes.filter(function(d,i) { return (d.id == document.getElementById("nodeIdValue").value); });
	nodeModif[0].comment=document.getElementById("comment").value;
	redraw();
	/*ENVOIE DU MESSAGE d'UPDATE DU NOEUD AU SERVER*/ 
      var noeudString = JSON.stringify(nodeModif[0]);
      var noeudSerial = '{"brainstorm":"'+ idB +'","node":'+noeudString+',"idSender":"'+socket.socket.sessionid+'"}';	  console.log("socket.id:",socket.socket.sessionid);
	  socket.emit('updateNode', noeudSerial);
}

function UpdateName(){
	newName=document.getElementById("namepoint").value;
	var nodeModif = nodes.filter(function(d,i) { return (d.id == document.getElementById("nodeIdValue").value); });
	nodeModif[0].name=document.getElementById("namepoint").value;
	redraw();
	/*ENVOIE DU MESSAGE D'UPDATE DU NOEUD AU SERVER*/     
      var noeudString = JSON.stringify(nodeModif[0]);
      var noeudSerial = '{"brainstorm":"'+ idB +'","node":'+noeudString+',"idSender":"'+socket.socket.sessionid+'"}';
	  console.log("socket.id:",socket.socket.sessionid);
	  socket.emit('updateNode', noeudSerial);
}

function checkKey(e,champ)
{
	var keynum;    
	 if(window.event) 
	{ keynum = e.keyCode;}
	else if(e.which)
	{ keynum = e.which;}

	if(keynum == 13){  
		if (champ=='name')
		{
			UpdateName();
		}
		else if (champ=='comment')
		{
			UpdateComment();
		}
	}
	
}

function randomKey(){
  chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
  pass = "";
  for(x=0;x<10;x++)
  {
    i = Math.floor(Math.random() * 62);
    pass += chars.charAt(i);
  }
  return pass;
}

function foo(){
	socket.emit('nextPhase',idB); 
	passerSuivant();
	window.location.reload();
}