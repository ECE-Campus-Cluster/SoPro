var width = 1167,
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


// get layout properties
var nodes = force.nodes(),
    links = force.links(),
    node = vis.selectAll(".node"),
    link = vis.selectAll(".link");
    


(function foo(){
       	load();
       	setTimeout(function(){redraw();},500);
    })()

function tick() {
  link.attr("x1", function(d) { return d.source.x; })
      .attr("y1", function(d) { return d.source.y; })
      .attr("x2", function(d) { return d.target.x; })
      .attr("y2", function(d) { return d.target.y; });

  node.attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; })
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
}

function mousedown() {
  if (!mousedown_node && !mousedown_link) {
    // allow panning if nothing is selected
    vis.call(d3.behavior.zoom().on("zoom"), rescale);
    return;
  }
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
      .attr("class", "link");
    	
    	node = vis.selectAll(".node");
    	node = node.data(nodes);
    	node.enter().append("g")
    	.attr("class","node")
    	.style("fill", function(d) { return color(d.group); })
    	.call(force.drag);
  		circle = node.selectAll("circle").data(function(d){return [d.index];}).enter().append("circle")
        			.transition()
        			.duration(750)
        			.ease("elastic")
        			.attr("r", 10);	  		
        text = node.selectAll("text").data(function(d){return [d.name];}).enter().append("text")
        			.attr("dx", 12)
        			.attr("dy", ".35em")
        			.text(function(d) { return d; });
	       
  if (d3.event) {
    // prevent browser's default behavior
    d3.event.preventDefault();
  }
  force.start();  

}

/********************GO**************/
function gojson(Operation){
       var xhr = getXhr()
       // On défini ce qu'on va faire quand on aura la réponse
       xhr.onreadystatechange = function(){
               // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
               if(xhr.readyState == 4 && xhr.status == 200){
               //document.getElementById("form").innerHTML = xhr.responseText ;            
               }
       }
       switch(Operation){
               case 1 : var tabN = JSON.stringify(nodes);
               xhr.open("POST","./phases/save.php",true);
               xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
           xhr.send("tabN="+tabN+"&id="+document.getElementById("brainstormhidden").value);
           break;
           
           case 2 :var tabL = JSON.stringify(links);
               xhr.open("POST","./phases/save.php",true);
               xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
           xhr.send("tabL="+tabL+"&id="+document.getElementById("brainstormhidden").value);
           break;
           
           case 3 : var tabN = JSON.stringify(nodes);
           var tabL = JSON.stringify(links);
           xhr.open("POST","./phases/save.php",true);
               xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
           xhr.send("tabN="+tabN+"&tabL="+tabL+"&lastGroup="+lastGroup+"&id="+document.getElementById("brainstormhidden").value);
           break;
       }
}

