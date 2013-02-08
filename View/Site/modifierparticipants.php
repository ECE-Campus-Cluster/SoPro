<!--  Sopro in an interactive web-based collaborative brainstorming tool.
      SoPro Copyright (C) 2013  Alvynn CONHYE, Marion DISTLER, Elodie DUFILH, Anthony OSMAR & Maxence VERNEUIL

        This program is free software: you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation, either version 3 of the License, or
        (at your option) any later version.
    
        This program is distributed in the hope that it will be useful,
       but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
    
        You should have received a copy of the GNU General Public License
        along with this program.  If not, see <http://www.gnu.org/licenses/>. -->
<?php 
session_start();
require_once '../../Controller/membresActions/cnx.php'; 
require_once '../../Controller/membresActions/authentification.php';
require_once '../../Model/Classes/Brainstorm.php';
require_once '../../Model/Classes/users.php';
if(Auth::islogged()){
	$brainstorm = new Brainstorm($_GET['id']);
	$users=Users::getAll();	
	$participants = $brainstorm->getParticipants();
 	//Verification des droits de l'utilisateur sur le brainstorm
 	if(!$brainstorm->isAdminBstrm($_SESSION['Auth']['email']))
 		header("Location:../../View/Site/mesbrainstorms.php");
}else{
	header("Location:../../index.php");	
}

?>
<!DOCTYPE html>
<html lang="en">

  
  <?php include '../../View/common/header.php' ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>

    
     <div id="container" class="container"> 
		<h3>Modification du brainstorm - Statuts : <?php if($brainstorm->phase==0){print("En attente de démarrer");}elseif($brainstorm->phase==5){print("Terminé");}else{print("En cours de phase ".$brainstorm->phase);} ?></h3>
		<ul class="nav nav-tabs">
		  <li >
		    <a href="./modifierbrainstorm.php?id=<?php echo $_GET['id'];?>">Informations générales</a>
		  </li>
		  <li class="active"><a href="#">Liste des Participants</a></li>
		</ul>
		<div id="errorblock"></div>
	   <div class="createbrainstorming">	
  
	    		<div class="bs-docs-grid">
		    		<div class="row-fluid show-grid">
			    		<div class="span4">
			    			<h5>Annuaire de contacts</h5>
							<form id='recherche' onKeyPress="if (event.keyCode == 13||46) rechercher()">
			  				<input type="text" id="formInput" class="champs1"  name="bddsearch" placeholder="Rechercher" onKeyPress="rechercher()">
			  				
			  				<input class="btn btn-primary btn-mini" onclick="rechercher()" value="Rechercher">	
							</form>
		
							<div class="span12">
								<div class="listbdd7" id="drop1">	
									<input id="idhidden" type="hidden" name="id" value="<?php print($_GET['id']); ?>">
								    
									    <?php
										    foreach($users as $user){
										    	$bool=1;
										    	foreach($participants as $participant){
												    if($participant->email==$user['email']){
													    	$bool=0;
													}
									    		}
									    		if($bool){
									    			if($user['email']!=$_SESSION['Auth']['email']){
												   		print('<p class="btn btn-info btn-block " id="'.$user['email'].';drop1" draggable="true" >'.$user['prenom'].' '.$user['nom'].'</p>');
											    	}
											    }
										    }											    
											?>
										
									</div>	
								</div>
							<div class="span12">
								<h5>Recommandation de participants</h5>
								<div class="listbdd2" id="drop3">	
									<input id="idhidden" type="hidden" name="id" value="<?php print($_GET['id']); ?>">   
									<?php
									$mailuser=array();
									$userscp=array();
									$i=0;
									$usersearch = new Users();
											foreach($brainstorm->competences as $cp){
												$mailuser = $usersearch->getCompetencesByUsers($cp);
												foreach($mailuser as $mu)
												{
													foreach($userscp as $mail)
													{
														if ($mu==$mail) $i=1;
													}
													if($i==0) array_push($userscp, $mu);
												}
												
											}
									foreach($userscp as $mail)
									{
										if($mail != $_SESSION['Auth']['email']){
											$bool=1;
									    	foreach($participants as $participant){
											    if($participant->email==$mail){
												    	$bool=0;
												}
								    		}
								    		$usercp = new User($mail);
								    		if($bool){
												print('<p class="btn btn-info btn-block"  id="'.$usercp->email.';drop3" draggable="true" >'.$usercp->prenom.' '.$usercp->nom.'</p>');
											}else{
												print('<p class="btn btn-info btn-block disabled"  id="'.$usercp->email.';drop3" draggable="false" >'.$usercp->prenom.' '.$usercp->nom.'</p>');
											}
										}							
									}	
								?> 
								</div>	
							</div>
								
						</div>
						<div class="span1">
							<div class="trait2">
							</div>
						</div>
		
						<div class="span5">
							<div class="span12">
								<div class="listbdd4" id="listParticipants">
								
								<div class="span6" style="margin-top:5px; margin-bottom:-5px;">
											<h5>Liste des participants</h5>
								</div>

								<div  class="contentParticipant span11 draganddrop" id='drop2' rel='popover' data-content='Le nombre de participants est limité à 10.'>
									<?php
												foreach($participants as $participant){												
													print('<p class="btn btn-info btn-block " id="'.$participant->email.';drop2" draggable="true" >'.$participant->prenom.' '.$participant->nom.'</p>');
												}
									?>
								<div>
								</div>  
							</div>  
						</div>
					</div>  
				</div>
				<div class="span3 offset10">
									    <button class="btn btn-success" onclick="return go1();" >Enregistrer</button>
				</div>						
			</div>			
		</div>	
	</div>
    
     <?php include '../../View/common/footer.php'?>

    <!-- /container -->

     </div>
 <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../View/assets/js/jquery.js"></script>
    <script src="../../View/assets/js/bootstrap-transition.js"></script>
    <script src="../../View/assets/js/bootstrap-alert.js"></script>
    <script src="../../View/assets/js/bootstrap-modal.js"></script>
    <script src="../../View/assets/js/bootstrap-dropdown.js"></script>
    <script src="../../View/assets/js/bootstrap-scrollspy.js"></script>
    <script src="../../View/assets/js/bootstrap-tab.js"></script>
    <script src="../../View/assets/js/bootstrap-tooltip.js"></script>
    <script src="../../View/assets/js/bootstrap-popover.js"></script>
    <script src="../../View/assets/js/bootstrap-button.js"></script>
    <script src="../../View/assets/js/bootstrap-collapse.js"></script>
    <script src="../../View/assets/js/bootstrap-carousel.js"></script>
    <script src="../../View/assets/js/bootstrap-typeahead.js"></script>
    <script src="../../View/assets/js/h5utils.js"></script>

    
   <script type="text/javascript">
		function getXhr(){
	        var xhr = null; 
			if(window.XMLHttpRequest) // Firefox et autres
			   xhr = new XMLHttpRequest(); 
			else if(window.ActiveXObject){ // Internet Explorer 
			   try {
		                xhr = new ActiveXObject("Msxml2.XMLHTTP");
		            } catch (e) {
		                xhr = new ActiveXObject("Microsoft.XMLHTTP");
		            }
			}
			else { // XMLHttpRequest non supporté par le navigateur 
			   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			   xhr = false; 
			} 
	        return xhr;
		}
		function supprimer(){
			var xhr = getXhr();
			xhr.open("POST","../../Controller/membresActions/modifierBrainstorm.php",true);
			xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			xhr.send("action=supprimer&id=<?php print($_GET['id']); ?>");
		}
		
		function go1(){
				var xhr = getXhr();
				
				/*Recuperer le nom des participants*/
				xhr.onreadystatechange = function(){
					// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
					if(xhr.readyState == 4 && xhr.status == 200){
					 document.getElementById('errorblock').innerHTML = xhr.responseText ;	    
					}
				}
				var dragItems = document.getElementById('drop2').querySelectorAll('[draggable=true]');
				var users = '';
				if(dragItems!=null){
					for (var i = 0; i < dragItems.length; i++) {
						data = dragItems[i].id.split(";");
						users += data[0]+';';
					}
				}
				xhr.open("POST","../../Controller/membresActions/modifierBrainstorm.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send('users='+users+'&etape=2&id=<?php print($_GET['id']); ?>&action=modifier');
		}
		
	</script>
	<script type="text/javascript">
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
		
		
		</script>
		<script>
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
		</script>
  </body>
</html>