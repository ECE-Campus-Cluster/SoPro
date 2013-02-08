//store the IDs connected to the PAD
var connectedID = [];
var links = [];
var nodes = [];
var http = require('http')
, url = require('url')
, fs = require('fs')
, server;


// socket.io, I choose you
var io = require('./node_modules/socket.io').listen(8080);

/*RECUPERATION JSON ET SAUVEGARDE */
function saveJson(id, data){
	fs.writeFileSync("./View/assets/json/"+id+".json", data);
}
function load(id) {
	var fileContent = fs.readFileSync("./View/assets/json/"+id+".json", 'UTF-8') ; 
	var json =  JSON.parse(fileContent); 
	nodes = json.nodes;
	links = json.links;		
	lastGroup = json.lastGroup;
}
function saveAjout(data){
	console.log('ajout');
	var data2 = JSON.parse(data);
	var parent; 
	load(data2.brainstorm);
	var noeudAjout = data2.node;
	/* Verification que le parent existe */
    for(i=0; i<nodes.length; i++){
   	    if(nodes[i].id==noeudAjout.parent)
	    	var parent=nodes[i];
    }
    /*pas de corruption de données*/
    if(parent!= null){
	    nodes.push(noeudAjout);
	    links.push({source: noeudAjout.parent , target: noeudAjout.id});
	    parent.hasChild = parent.hasChild+1;
		if(lastGroup < noeudAjout.group) lastGroup=noeudAjout.group;
		/*Stringify and send to be saved*/
		var noeudString = JSON.stringify(nodes);
		var linkString = JSON.stringify(links);
    	var string = '{"nodes":'+noeudString+',"links":'+linkString+', "lastGroup":"'+lastGroup+'"}';
    	saveJson(data2.brainstorm, string);
    	console.log('ajout '); 
    	return true;
    }else{
    	console.log('pas ajout possible');
	    return false;
    }
}

function saveDelete(data){
	var data2 = JSON.parse(data); 
	load(data2.brainstorm);
	var noeudDelete = data2.node;
	var noeud = nodes.filter(function(d){return d.id==noeudDelete.id;});
	if(typeof noeud[0] !== 'undefined'){
		if(noeud.hasChild!=0){
			toSplice = links.filter(function(l) { return (l.target == noeudDelete.id); });
			var parent = nodes.filter(function(d){return d.id==noeudDelete.parent});
			if(typeof parent[0] !== 'undefined'){
				parent[0].hasChild = parent[0].hasChild-1;
			}
			links.splice(links.indexOf(toSplice[0]), 1);
			nodes.splice(nodes.indexOf(noeud[0]),1);
			/*Stringify and send to be saved*/
			var noeudString = JSON.stringify(nodes);
			var linkString = JSON.stringify(links);
		    var string = '{"nodes":'+noeudString+',"links":'+linkString+', "lastGroup":"'+lastGroup+'"}';
			saveJson(data2.brainstorm, string);
			console.log('delete possible');
			return true;
		}
		else{
			console.log('reajout');
			return -1;
		}
	}else{
		console.log('delete pas possible '); 
		return false;
	}
}

function saveUpdate(data){
	var data2 = JSON.parse(data); 
	load(data2.brainstorm);
	var noeudUpdate = data2.node;
	correspondant = nodes.filter(function(d){return d.id == noeudUpdate.id;});
	if(typeof correspondant[0] !== 'undefined'){
		correspondant[0].name = noeudUpdate.name;
		correspondant[0].comment = noeudUpdate.comment;
		var noeudString = JSON.stringify(nodes);
		var linkString = JSON.stringify(links);
	    var string = '{"nodes":'+noeudString+',"links":'+linkString+', "lastGroup":"'+lastGroup+'"}';
		saveJson(data2.brainstorm, string);
		return true;
	}else{
		return false;
	}
}

// on a 'connection' event
io.sockets.on('connection', function(socket){

  console.log("Connection " + socket.id + " accepted.");
  connectedID.push({'id':socket.id,'socket':socket, 'brainstorm':null});
  // now that we have our connected 'socket' object, we can 
  // define its event handlers
  socket.on('message', function(message){
        console.log("Received message: " + message + " - from client " + socket.id);
  });
    
  socket.on('disconnect', function(){
    console.log("Connection " + socket.id + " terminated.");
    for (var i = 0; i < connectedID.length; i++)
  	{
	  	  (function(i)
		  	{
				if (connectedID[i].id == socket.id)
				{
						connectedID.splice(i,1);
				}
			})(i);
	}
	for (var i = 0; i < connectedID.length; i++)
  	{
	  	  (function(i)
		  	{
				if (connectedID[i].id == socket.id)
				{
						connectedID.splice(i,1);
				}
			})(i);
	}
	console.log('connectionID', connectedID);

  });
  
  socket.on('brainstorm', function(data){
  	console.log('brainstorm recu');
  	  var data2 = JSON.parse(data);

  	  for (var i = 0; i < connectedID.length; i++)
  	  {
	  	  (function(i)
		  	{
				if (connectedID[i].id == data2.idSender)
				{
						connectedID[i].brainstorm = data2.brainstorm;
				}
			})(i);
	  }
  });
  socket.on('testEvent', function(data){
	  console.log(data);
  });
  
  socket.on('addNode', function(data)
  {
  	var data2 = JSON.parse(data);
  	var rep = saveAjout(data);
  	if(rep){
	  	for (var i = 0; i < connectedID.length; i++)
	  	{
		  	console.log("i",i);
		  	(function(i)
		  	{
				if (connectedID[i].id != data2.idSender && connectedID[i].brainstorm== data2.brainstorm){
					var sockets = connectedID[i].socket;
					sockets.emit('resultAddNode',data);	
				}
			})(i);
		 }
	}else{
		socket.emit('resultDeleteNode', data);
	}
  });
  
   socket.on('deleteNode', function(data)
  {
  	var data2 = JSON.parse(data);
    var rep = saveDelete(data);
  	if(rep==true){
	  	for (var i = 0; i < connectedID.length; i++)
	  	{
		  	
		  	(function(i)
		  	{
				if (connectedID[i].id != data2.idSender && connectedID[i].brainstorm== data2.brainstorm){
					var sockets = connectedID[i].socket;
					sockets.emit('resultDeleteNode',data);	
				}
			})(i);
		 }
	}else if(rep==-1){
		socket.emit("resultAjoutNode",data);
	}	 
  });

socket.on('updateNode', function(data)
  {
  	var data2 = JSON.parse(data);
    var rep = saveUpdate(data);
    if(rep){
	  	for (var i = 0; i < connectedID.length; i++)
	  	{
		  	(function(i)
		  	{
				if (connectedID[i].brainstorm== data2.brainstorm){
					var sockets = connectedID[i].socket;
					sockets.emit('resultUpdateNode',data);	
				}
			})(i);
		 }
	}
  });

socket.on('nextPhase', function(data)
  {
  	for (var i = 0; i < connectedID.length; i++)
  	{
	  	(function(i)
		  	{
				if (connectedID[i].id != socket.id && connectedID[i].brainstorm== data)
				{
					var sockets = connectedID[i].socket;
					sockets.emit('nextPhase',data);	
				}
			})(i);
	}
  });

    
});