
//*********************** Multi-parties ***************//
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
//********************* Fin Multi-parties ********************//



//**********************Phases*******************************//
/*Sauvegarde du compte rendu et de l'arbre d'idées dans la phase 4*/
function goCr()
{
		var xhr = getXhr();
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
			 //document.getElementById('errorblock').innerHTML = xhr.responseText ;	    
			}
		}	   
	   gojson(3);
	   xhr.open("POST","../../Controller/Phases/jump.php",false);
	   xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
       xhr.send("id="+document.getElementById("brainstormhidden").value+"&cr="+document.getElementById("cr").value);
}

//Passer à la phase suivante	
function passerSuivant(){
       var xhr = getXhr()
       // On défini ce qu'on va faire quand on aura la réponse
       xhr.onreadystatechange = function(){
               // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
               if(xhr.readyState == 4 && xhr.status == 200){
                  //document.getElementById("form").innerHTML = xhr.responseText ;            
               }
       }

		xhr.open("POST","../../Controller/Phases/jump.php",false);
		xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xhr.send("id="+document.getElementById("brainstormhidden").value);
		window.location.reload();
}
//Function validation du vote dans la phase 2
function voteValidation(){
		console.log('vote');
		var ideaList = nodes.filter(function(d) { return (d.selected == true); });
		var idea = "";
		for (var i = 0; i < ideaList.length; i++) {
			idea += ideaList[i].id+';';
		}
		var xhr = getXhr()
	   // On défini ce qu'on va faire quand on aura la réponse
	   xhr.onreadystatechange = function(){
	           // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
	           if(xhr.readyState == 4 && xhr.status == 200){
	             //document.getElementById("error-block").innerHTML = xhr.responseText ;            
	           }
	   }
	   xhr.open("POST","../../Controller/Phases/vote.php",false);
	   xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	   xhr.send("id="+ document.getElementById("brainstormhidden").value +"&ideas="+idea);

}
//Envoie des informations à sauvegarder dans le json		
function validation(){
       var xhr = getXhr()
       // On défini ce qu'on va faire quand on aura la réponse
       xhr.onreadystatechange = function(){
               // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
               if(xhr.readyState == 4 && xhr.status == 200){
                  //document.getElementById("form").innerHTML = xhr.responseText ;            
               }
       }
		var tabN = JSON.stringify(nodes);
		var tabL = JSON.stringify(links);
		xhr.open("POST","../../Controller/Phases/save.php",false);
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xhr.send("id="+document.getElementById("brainstormhidden").value+"&tabN="+tabN+"&tabL="+tabL+"&lastGroup="+lastGroup);
		window.location.reload();
}

//***************** Fin phase ***************************//


//***************** Site *******************************//

function loadXMLDoc()
		{
			var xmlhttp = getXhr();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
			    }
			  }
			searchform = document.getElementById('recherche');
			var formData = new FormData(searchform);
	
			xmlhttp.open("POST","/Controller/membresActions/search.php",true);
			xmlhttp.send(formData);
		}
		
		
		function loadXMLDoc2(mail)
		{
			
			var xmlhttp = getXhr();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	document.getElementById("annuairecontent").innerHTML=xmlhttp.responseText;
			    }
			  }
			
			xmlhttp.open("POST","/Controller/membresActions/search2.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("mail="+mail);
			
		}
		
		function loadUser(mail)
		{
		var xmlhttp = getXhr();
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    	document.getElementById("annuairecontent").innerHTML=xmlhttp.responseText;
		    }
		  }
		  
		xmlhttp.open("POST","/Controller/membresActions/search2.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("mail="+mail);
		}
		
		function refreshe(){
		var xmlhttp = getXhr();
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    	document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
			    }
			  }
				
			xmlhttp.open("POST","/Controller/membresActions/search2.php",true);
			
		}
		
		
		function go(){
				var xhr = getXhr();
				/*Recuperer le nom des participants*/
				xhr.onreadystatechange = function(){
					// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
					if(xhr.readyState == 4 && xhr.status == 200){
					 document.getElementById('error-block').innerHTML = xhr.responseText ;	    
					}
				}
				var drop = document.getElementById('drop2');
				var dragItems = document.getElementById('drop2').querySelectorAll('[draggable=true]');
				var users = '';
				for (var i = 0; i < dragItems.length; i++) {
					data = dragItems[i].id.split(";");
					users += data[0]+';';
				}
				xhr.open("POST","../../Controller/membresActions/createBrainstrm.php",false);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send('users='+users+'&etape=2&id='+document.getElementById("idhidden").value);
		}
		
		function rechercher()
		{
			var tabContact = document.getElementById("drop1").getElementsByTagName("p");
			var formInput1 = document.getElementById("formInput").value;			
			
			
			for(var i= 0; i < tabContact.length; i++)
			{
			
					if(formInput1==""){tabContact[i].style.display='block';}
					else{
							var s2 = new RegExp(".*"+formInput1+".*$","gi");
							var s3 = tabContact[i].innerHTML;
							
							if(s3.match(s2)){
								tabContact[i].style.display='block';
								
		
							}
							else tabContact[i].style.display='none';
						}
			}
					
				
		}	
		
		function go1(){
				document.getElementById('error-block').innerHTML = '' ;
				var dragItems = document.getElementById('drop2C').querySelectorAll('[draggable=true]');
				var competences = '';
				if(dragItems!=null){
					for (var i = 0; i < dragItems.length; i++) {
						competences += dragItems[i].id+';';
					}
				}
				
				var form = document.getElementById('brainstrmForm');
					var xhr = getXhr();
					var formData = new FormData(form);
					/*Recuperer le nom des participants*/
					xhr.onreadystatechange = function(){
						// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
						if(xhr.readyState == 4 && xhr.status == 200){
						  document.getElementById('error-block').innerHTML = xhr.responseText ;	    
						}
					}
					var drop = document.getElementById('drop2C');
					var dragItems = document.getElementById('drop2C').querySelectorAll('[draggable=true]');
					var competences = '';
					for (var i = 0; i < dragItems.length; i++) {
						competences += ''+dragItems[i].id+';';
					}
					formData.append('competences',competences);
					formData.append('etape',"1");
					xhr.open("POST","../../Controller/membresActions/createBrainstrm.php",false);
					xhr.send(formData);
					if(	document.getElementById('error-block').innerHTML ===""){
						window.location.href='../../View/Site/newbrainstorm2.php?id='+document.getElementById('idhidden').value;
					}
		}
	
	//NewBrainstorm
	function changeBorder1(newValue) {
        var sl = document.getElementById('valdureePhase1');
        sl.innerHTML = newValue +" min";
    }
	
	function changeBorder2(newValue) {
	var sl = document.getElementById('valdureePhase2');
	sl.innerHTML = newValue +" h";
    }
	
	function cancel(e) {
	  if (e.preventDefault) {
		e.preventDefault();
	  }
	  return false;
	}
		
	//modifBrn
	function supprimer(){
		var xhr = getXhr();
		xhr.open("POST","../../Controller/membresActions/modifierBrainstorm.php",false);
		xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xhr.send("action=supprimer&id="+document.getElementById('brainstormhidden').value+"");
	}
	
	function go_modifbrn(){
	
		var form = document.getElementById('brainstrmForm');
		var xhr = getXhr();
		var formData = new FormData(form);
		
		/*Recuperer le nom des participants*/
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
			  document.getElementById('error-block').innerHTML = xhr.responseText ;	    
			}
		}
		var dragItems = document.getElementById('drop2C').querySelectorAll('[draggable=true]');
		var competences = '';
		for (var i = 0; i < dragItems.length; i++) {
			competences += dragItems[i].id+';';
		}
		formData.append('competences',competences);
		formData.append('phase', document.getElementById('phasehidden').value);
		formData.append('id', document.getElementById('brainstormhidden').value);
		formData.append('etape',"1");
		formData.append('action','modifier');
		xhr.open("POST","../../Controller/membresActions/modifierBrainstorm.php",true);
		xhr.send(formData);
	}
	
	//modifbrn
	function goModification(){
	
		var xhr = getXhr()
		var form = document.getElementById('formModif');
		var formData = new FormData(form);
		var drop = document.getElementById('drop2');
		var dragItems = document.getElementById('drop2').querySelectorAll('[draggable=true]');
		var competences = '';
		for (var i = 0; i < dragItems.length; i++) {
			competences += dragItems[i].id+';';
		}
		formData.append('competences',competences);
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
			document.getElementById('error-block').innerHTML = xhr.responseText ;	    
			}
		}
		xhr.open("POST","/Controller/membresActions/modifierCompte.php",true);
		xhr.send(formData);
		document.getElementById("Oldpassword").value="";
		document.getElementById("Newpassword").value="";
		document.getElementById("Confirmpassword").value="";
		}
		
		function modificationprofile(){
			var holder = document.getElementById('holder'),
				tests = {
				  filereader: typeof FileReader != 'undefined',
				  dnd: 'draggable' in document.createElement('span'),
				  formdata: !!window.FormData,
				  progress: "upload" in new XMLHttpRequest
				}, 
				support = {
				  filereader: document.getElementById('filereader'),
				  formdata: document.getElementById('formdata'),
				  progress: document.getElementById('progress')
				},
				acceptedTypes = {
				  'image/png': true,
				  'image/jpeg': true,
				  'image/gif': true
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');
			
			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				// FFS. I could have done el.hidden = true, but IE doesn't support
				// hidden, so I tried to create a polyfill that would extend the
				// Element.prototype, but then IE10 doesn't even give me access
				// to the Element object. Brilliant.
				support[api].className = 'hidden';
			  }
			});
			
			function previewfile(file) {
			  if (tests.filereader === true && acceptedTypes[file.type] === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  var image = new Image();
				  image.src = event.target.result;
				  image.width = 250; // a fake resize
				  holder.innerHTML="";
				  holder.appendChild(image);
				};
			
				reader.readAsDataURL(file);
			  }  else {
				holder.innerHTML += '<p>Uploaded ' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
				console.log(file);
			  }
			}
			
			function readfiles(files) {
				debugger;
				var formData = tests.formdata ? new FormData() : null;
				for (var i = 0; i < files.length; i++) {
				  if (tests.formdata) formData.append('file', files[i]);
				  previewfile(files[i]);
				}
			
				// now post a new XHR request
				if (tests.formdata) {
				  var xhr = new XMLHttpRequest();
				  xhr.open('POST', '/Controller/membresActions/uploadPhoto.php');
				  xhr.onload = function() {
					progress.value = progress.innerHTML = 100;
				  };
			
				  if (tests.progress) {
					xhr.upload.onprogress = function (event) {
					  if (event.lengthComputable) {
						var complete = (event.loaded / event.total * 100 | 0);
						progress.value = progress.innerHTML = complete;
					  }
					}
				  }
				  xhr.onreadystatechange = function(){
							// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
							if(xhr.readyState == 4 && xhr.status == 200){
							document.getElementById('img-error-block').innerHTML = xhr.responseText ;	    
							}
					}
				  xhr.send(formData);
				}
			}
			
			if (tests.dnd) { 
			  holder.ondragover = function () { this.className = 'hover'; return false; };
			  holder.ondragend = function () { this.className = ''; return false; };
			  holder.ondrop = function (e) {
				this.className = '';
				e.preventDefault();
				readfiles(e.dataTransfer.files);
			  }
			} else {
			  fileupload.className = 'hidden';
			  fileupload.querySelector('input').onchange = function () {
				readfiles(this.files);
			  };
			}
		}
		
		function modifierbrainstorm()
		{
			var dragItems = document.querySelectorAll('[draggable=true]');
			
			for (var i = 0; i < dragItems.length; i++) {
			  addEvent(dragItems[i], 'dragstart', function (event) {
				// store the ID of the element, and collect it on the drop later on
				event.dataTransfer.setData('Text', this.id);
			  });
			}
			
			var drop1 = document.querySelector('#drop1C');
			var drop2 = document.querySelector('#drop2C');
			
			// Tells the browser that we *can* drop on this target
			addEvent(drop1, 'dragover', cancel);
			addEvent(drop1, 'dragenter', cancel);
			addEvent(drop1, 'drop', function (e) {
			  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
			  var el = document.getElementById(e.dataTransfer.getData('Text')); 
			  el.parentNode.removeChild(el);
			  this.innerHTML +=  '<p  class="btn btn-block" id="'+ e.dataTransfer.getData('Text') +'" draggable="true">' + e.dataTransfer.getData('Text') + '</p>';  
			  var dragItems = document.querySelectorAll('[draggable=true]');
				for (var i = 0; i < dragItems.length; i++) {
				  addEvent(dragItems[i], 'dragstart', function (event) {
					// store the ID of the element, and collect it on the drop later on
					event.dataTransfer.setData('Text', this.id);
				  });
				}
			  return false;
			});
			
			addEvent(drop2, 'dragover', cancel);
			addEvent(drop2, 'dragenter', cancel);
			addEvent(drop2, 'drop', function (e) {
			  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
			  var el = document.getElementById(e.dataTransfer.getData('Text')); 
			  el.parentNode.removeChild(el);
			  this.innerHTML += '<p  class="btn btn-block" id="'+ e.dataTransfer.getData('Text') +'" draggable="true">' + e.dataTransfer.getData('Text') + '</p>';
			  var dragItems = document.querySelectorAll('[draggable=true]');
				for (var i = 0; i < dragItems.length; i++) {
				  addEvent(dragItems[i], 'dragstart', function (event) {
					// store the ID of the element, and collect it on the drop later on
					event.dataTransfer.setData('Text', this.id);
				  });
				}
			  return false;
			});
		}
		
		function newbrainstorm()
	{
		function cancel(e) {
		  if (e.preventDefault) {
		    e.preventDefault();
		  }
		  return false;
		}
		
		var dragItems = document.querySelectorAll('[draggable=true]');
		
		for (var i = 0; i < dragItems.length; i++) {
		  addEvent(dragItems[i], 'dragstart', function (event) {
		    // store the ID of the element, and collect it on the drop later on
		    event.dataTransfer.setData('Text', this.id);
		  });
		}
		
		var drop1 = document.querySelector('#drop1C');
		var drop2 = document.querySelector('#drop2C');
		
		// Tells the browser that we *can* drop on this target
		addEvent(drop1, 'dragover', cancel);
		addEvent(drop1, 'dragenter', cancel);
		addEvent(drop1, 'drop', function (e) {
		  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
		  var el = document.getElementById(e.dataTransfer.getData('Text')); 
		  el.parentNode.removeChild(el);
		  this.innerHTML +=  '<p  class="btn btn-block" id="'+ e.dataTransfer.getData('Text') +'" draggable="true">' + e.dataTransfer.getData('Text') + '</p>';  
		  var dragItems = document.querySelectorAll('[draggable=true]');
			for (var i = 0; i < dragItems.length; i++) {
			  addEvent(dragItems[i], 'dragstart', function (event) {
			    // store the ID of the element, and collect it on the drop later on
			    event.dataTransfer.setData('Text', this.id);
			  });
			}
		  return false;
		});
		
		addEvent(drop2, 'dragover', cancel);
		addEvent(drop2, 'dragenter', cancel);
		addEvent(drop2, 'drop', function (e) {
		  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
		  var el = document.getElementById(e.dataTransfer.getData('Text')); 
		  el.parentNode.removeChild(el);
		  this.innerHTML += '<p  class="btn btn-block" id="'+ e.dataTransfer.getData('Text') +'" draggable="true">' + e.dataTransfer.getData('Text') + '</p>';
		  var dragItems = document.querySelectorAll('[draggable=true]');
			for (var i = 0; i < dragItems.length; i++) {
			  addEvent(dragItems[i], 'dragstart', function (event) {
			    // store the ID of the element, and collect it on the drop later on
			    event.dataTransfer.setData('Text', this.id);
			  });
			}
		  return false;
		});
	}
	
	function newbrainstorm2()
		{
			function cancel(e) {
			  if (e.preventDefault) {
				e.preventDefault();
			  }
			  return false;
			}
			
			var dragItems = document.querySelectorAll('[draggable=true]');
			
			for (var i = 0; i < dragItems.length; i++) {
			  addEvent(dragItems[i], 'dragstart', function (event) {
				// store the ID of the element, and collect it on the drop later on
				$str= this.innerHTML + ';' + this.id ;
				event.dataTransfer.setData('Text', $str);
			  });
			}
			
			var drop1 = document.querySelector('#drop1');
			var drop2 = document.querySelector('#drop2');
			var drop3 = document.querySelector('#drop3');
			
			// Annuaire
			addEvent(drop1, 'dragover', cancel);
			addEvent(drop1, 'dragenter', cancel);
			addEvent(drop1, 'drop', function (e) {
			  //Drop d'un objet dans l'annuaire
			  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
			  var data = e.dataTransfer.getData('Text').split(";");
			  if(data[2]!="drop3"){
				  var el = document.getElementById(data[1]+';'+data[2]);
				  el.parentNode.removeChild(el);
				  this.innerHTML +=  '<p  class="btn btn-info btn-block" id="'+ data[1]+';drop1" draggable="true">' + data[0] + '</p>';
				  /*Si il est present dans la liste des recommandations en disabled alors le remettre normalement*/
				  var disabledItems = drop3.querySelectorAll('[draggable=false]');
				  for(var i = 0; i < disabledItems.length; i++){
					  if(disabledItems[i].id == data[1]+';drop3'){
						  el = document.getElementById(disabledItems[i].id);
						  el.setAttribute("draggable", "true");
						  el.setAttribute( "class", "btn btn-info btn-block");
					  }
				  }
				  var dragItems = document.querySelectorAll('[draggable=true]');
					for (var i = 0; i < dragItems.length; i++) {
					  addEvent(dragItems[i], 'dragstart', function (event) {
						// store the ID of the element, and collect it on the drop later on
						$str= this.innerHTML + ';' + this.id ;
						event.dataTransfer.setData('Text', $str);
					  });
					}
			  }
			  return false;
			});
			
			// Participants
			addEvent(drop2, 'dragover', cancel);
			addEvent(drop2, 'dragenter', cancel);
			addEvent(drop2, 'drop', function (e) {
			  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
			  //Si il y a déjà plus de 10 participants ne rien faire
			  if(drop2.querySelectorAll('[draggable=true]').length>9){
			      $('#drop2').popover('show');
				  return false;
			  }
			  var data = e.dataTransfer.getData('Text').split(";");
			  var el = document.getElementById(data[1]+';drop1');
			  el.parentNode.removeChild(el); 
			  if(data[2]=="drop3"){
				 el = document.getElementById(data[1]+";drop3");
				 el.setAttribute("draggable", "false");
				 el.setAttribute( "class", "btn btn-info btn-block disabled");
			  }else if(data[2]=="drop1"){
				  var abledItems = drop3.querySelectorAll('[draggable=true]');
				  for(var i = 0; i < abledItems.length; i++){
					  if(abledItems[i].id == data[1]+';drop3'){
						  el = document.getElementById(abledItems[i].id);
						  el.setAttribute("draggable", "false");
						  el.setAttribute( "class", "btn btn-info btn-block disabled");
					  }
				  }
			  }
			  this.innerHTML +=  '<p  class="btn btn-info btn-block" id="'+ data[1] +';drop2" draggable="true">' + data[0] + '</p>';  
			  var dragItems = document.querySelectorAll('[draggable=true]');
				for (var i = 0; i < dragItems.length; i++) {
				  addEvent(dragItems[i], 'dragstart', function (event) {
					// store the ID of the element, and collect it on the drop later on
					 $str= this.innerHTML + ';' + this.id ;
					event.dataTransfer.setData('Text', $str);
					
				  });
				}
				
			  return false;
			});
		}
		
	
	//*********************** fin fonctions View/Site ********************///