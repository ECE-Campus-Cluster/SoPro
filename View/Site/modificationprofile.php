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
require '../../Controller/membresActions/authentification.php';
require_once '../../Model/Classes/user.php';

if(Auth::islogged()){
		
}else{
	header("Location:../../index.php");	
	
}
?>

<!DOCTYPE html>
<html lang="en">
  <style>
#holder { border: 3px dashed #ccc; width: 200px; min-height: 200px; margin: 20px auto;}
#holder.hover { border: 3px dashed #0c0; }
#holder img { display: block; margin: 10px auto; }
#holder p { margin: 10px; font-size: 14px; }
progress { width: 100%; }
progress:after { content: '%'; }
.fail { background: #c00; padding: 2px; color: #fff; }
.hidden { display: none !important;}
  #linkedin-img{
	  background-image:url(/View/assets/img/linkedIn-min.png);
	  background-repeat: no-repeat;
	  background-position: center center; 
  }
  #viadeo-img{
	 background-image:url(/View/assets/img/viadeo-min.png); 
	  background-repeat: no-repeat;
	  background-position: center center;
  }
  #twitter-img{
	  background-image:url(/View/assets/img/twitter-min.png);
	   background-repeat: no-repeat;
	  background-position: center center;
  }
  #facebook-img{
	  background-image:url(/View/assets/img/fcb-min.png);
	  background-repeat: no-repeat;
	  background-position: center center;
  }
  #googleplus-img{
	  background-image:url(/View/assets/img/googleplus-min.png);
	   background-repeat: no-repeat;
	  background-position: center center;
  }
  </style>
  <?php include '../../View/common/header.php' ?>
  <?php include '../../View/common/navigation.php' ?>

  <body>
   
    <div class="container" >
    
    <div class="page-header">
    	<h3>Modifier mon profil</h3>
    	</div>
    <?php
		$member = new User($_SESSION['Auth']['email']);	
		$member->getSocialNetworks();
		$member->getImage();
	?>
		<!--Messages d'erreur lié à la modification des données dans la base-->
		<!-- Id du brainstorm dans un input caché -->
		<input id="brainstormhidden" type="hidden" value="<?php print($_GET['id']); ?>">
		<div id='error-block'></div>
	    <div class="article">
	    <div id="profile_picture" class="span3">
	    	<div id="holder">
	    		<img src="<?php if($member->image===""){echo "https://prezi-a.akamaihd.net/assets/common/img/blank-avatar.jpg";}else{echo $member->image;}?>" alt="<?php echo $member->nom.' '.$member->prenom; ?>">
	    	</div> 
	    	<div id="img-error-block"></div>
		  <p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
		  <p id="filereader">File API & FileReader API not supported</p>
		  <p id="formdata">XHR2's FormData is not supported</p>
		  <p id="progress">XHR2's upload progress isn't supported</p>
	    </div>
	    <form id='formModif' >
	    	<fieldset class="span5">
				<label class="span2" for="prenom">Prénom</label>
				<input class="span3" type="text" value="<?php print($member->prenom) ?>" name="prenom" maxlength="20" required>		    
				<label class="span2" for="nom">Nom</label>
				<input class="span3" type="text" value="<?php print($member->nom) ?>" name="nom" maxlength="20" required>
				<label class="span2" for="email">Email</label>
				<input class="span3" type="text" value="<?php print($member->email) ?>" name="email" maxlength="20" required>
				<label class="span2" for="Entreprise">Entreprise</label>
				<input class="span3" type="text" value="<?php print($member->entreprise) ?>" name="entreprise" maxlength="20" >
				<label class="span2" for="name">Poste Actuel</label>
				<input class="span3" type="text" value="<?php print($member->poste) ?>" name="poste" maxlength="20">
			</fieldset>
			<!---Social Network Contact--->
			<fieldset class="span3">
			<div class="input-prepend">
			  <span class="add-on" id="linkedin-img"></span>
			  <input class="span3" name="linkedin" type="text" value="<?php print($member->linkedin) ?>" placeholder="LinkedIn Account">
			</div>
			<div class="input-prepend">
			  <span class="add-on socialmodpro"id="viadeo-img"></span>
			  <input class="span3 socialmodpro" name="viadeo" type="text" value="<?php print($member->viadeo) ?>" placeholder="Viadeo Account">
			</div>
			<div class="input-prepend">
			  <span class="add-on socialmodpro"id="twitter-img"></span>
			  <input class="span3 socialmodpro" name="twitter" type="text" value="<?php print($member->twitter) ?>" placeholder="Twitter Account">
			</div>
			<div class="input-prepend">
			  <span class="add-on socialmodpro"id="facebook-img"></span>
			  <input class="span3 socialmodpro" name="facebook" type="text" value="<?php print($member->facebook) ?>" placeholder="Facebook Account">
			</div>
			<div class="input-prepend">
			  <span class="add-on socialmodpro"id="googleplus-img"></span>
			  <input class="span3 socialmodpro" name="googleplus" type="text" value="<?php print($member->googleplus) ?>" placeholder="Google+ Account">
			</div>
			</fieldset>	
			<fieldset class="span5">
				<label class="span2" for="oldpassword">Ancien mot de passe</label>
				<input  id="Oldpassword" class="span3" type="password" value="" name="oldpassword" maxlength="20">
				<label class="span2" id="p1" for="newpassword">Nouveau mot de passe</label>
				<input id="Newpassword" class="span3" type="password" value="" name="newpassword" maxlength="20">
				<label class="span2" for="confirmpassword">Confirmation</label>
				<input id="Confirmpassword" class="span3" type="password" value="" name="confirmpassword" maxlength="20">	
			</fieldset>
			
			<?php 
	      	$xml = simplexml_load_file('../../View/assets/xml/competences.xml');
	    	$competenceList = $xml->competence;
	    	?>
	    	<div class="span12">
	    	
	    	<span class="offset2 modifierprofil"> Ajouter des compétences </span>
	    	<span class="offset3 modifierprofil"> Mes compétences </span>
	    	</div>
	    	
	    	
	    		    	<div class="span12">
	    	<div id='drop1' class = "drop span5">
		    	<?php 	
				    	foreach($competenceList as $competence){
				    	    $bool=1;
				    		foreach($member->competences as $usercompetence){
					    		if($usercompetence==$competence){
					    			$bool=0;
					    		}
				    		}
				    		if($bool){
					    		print('<p class="btn btn-info btn-block" id="'.$competence.'" draggable="true" >'.$competence.'</p>');
					    	}
					    }
				?>
		    </div>
		    
		    <div id='drop2' class = "drop span5">
		    	<?php 	
				    	foreach($member->competences as $competence){
					    		print('<p class="btn btn-info btn-block" id="'.$competence.'" draggable="true" >'.$competence.'</p>');
					    }
				?>
		    </div>
		    	
	    	</div>
	    	<div class="span12 offset8">
			    	<input class="btn btn-primary btn-medium offset 9" onclick="return goModification();" value="Modifier">
			    </div>
		</form>
		</div>
    </div>
    <div class="page-header">
    	
    	</div>
    
    <?php include '../../View/common/footer.php'?>

    <!-- /container -->
    
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
    <script src="../../View/assets/js/bootstrap-popover.js"></script>
    <script src="../../Controller/fonctions.js"></script>
    <script src="../../View/assets/js/h5utils.js"></script>
    
     <script type="text/javascript">
	
		var dragItems = document.querySelectorAll('[draggable=true]');
		
		for (var i = 0; i < dragItems.length; i++) {
		  addEvent(dragItems[i], 'dragstart', function (event) {
		    // store the ID of the element, and collect it on the drop later on
		    event.dataTransfer.setData('Text', this.id);
		  });
		}
		
		var drop1 = document.querySelector('#drop1');
		var drop2 = document.querySelector('#drop2');
		
		// Tells the browser that we *can* drop on this target
		addEvent(drop1, 'dragover', cancel);
		addEvent(drop1, 'dragenter', cancel);
		addEvent(drop1, 'drop', function (e) {
		  if (e.preventDefault) e.preventDefault(); // stops the browser from redirecting off to the text.
		  var el = document.getElementById(e.dataTransfer.getData('Text')); 
		  el.parentNode.removeChild(el);
		  this.innerHTML +=  '<button  class="btn btn-info btn-block" id="'+ e.dataTransfer.getData('Text') +'" draggable="true">' + e.dataTransfer.getData('Text') + '</button>';  
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
		  this.innerHTML += '<button  class="btn btn-info btn-block" id="'+ e.dataTransfer.getData('Text') +'" draggable="true">' + e.dataTransfer.getData('Text') + '</button>';
		  var dragItems = document.querySelectorAll('[draggable=true]');
			for (var i = 0; i < dragItems.length; i++) {
			  addEvent(dragItems[i], 'dragstart', function (event) {
			    // store the ID of the element, and collect it on the drop later on
			    event.dataTransfer.setData('Text', this.id);
			  });
			}
		  return false;
		});

</script>
		<script>
		modificationprofile();
		</script>

	</body>
</html>
