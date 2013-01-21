<?php 
session_start();
require_once './membresActions/cnx.php'; 
require './membresActions/authentification.php';

if(Auth::islogged()){
}else{
	header("Location:index.php");	
	
}
?>
<!DOCTYPE html>
<html lang="en">
  
  <?php include './common/header.php' ?>
  
  <body>
    <?php include './common/navigation.php' ?>

    
     <div class="container"> 
     <div class="page-header">
		     <h3>Création d'un nouveau Brainstorm</h3>
    	</div>
	     <div class="createbrainstorming">
	     
	     
	     <div class="row">
		 	<div class="span12">
		  		<input class="champs1" type="text" name="NomProjet" placeholder="Nom du Projet">
				<input class="champs1" type="email" name="user_email" placeholder="Cadrage, Définition de la question de départ">
		 	</div>
			<div class="span12">	
				Méthode de sélection :
				<div class="btn-group" data-toggle="buttons-radio">
		 			<button type="button" class="btn btn-primary">Left</button>
					<button type="button" class="btn btn-primary">Middle</button>
					<button type="button" class="btn btn-primary">Right</button>
				</div>
			</div>
			<div class="span12">
				Méthode de production des idées :
				<div class="btn-group" data-toggle="buttons-radio">
		 			<button type="button" class="btn btn-primary">Circulation des idées</button>
					<button type="button" class="btn btn-primary">Spontanéité</button>
				</div>
			</div>
			<div class="span12">	
				From: <input type="date" name="datedebut">
				To: <input type="date" name="datefin">
		 	</div>			
			<div class="span4">
				Rechercher par :
				<label class="radio inline ">
			 		<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Nom
				</label>
				<label class="radio inline">
					<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Compétences
				</label>
			</div>
							
			<span class="span3 offset1">Participants</span>
			<span class="span3">Pas encore membres SoPro ?</span>
			
			<span class="span12"></span>
							
			<div class="span3">
				<div class="listbdd">
					<h6  id="listbdd" style="color:black" onclick="copyText('Anthony')" value="Anthony">Anthony </h6>
				</div>
			</div>
								
			<div class="span1">
				<i class="icon-forward" style="float:left"></i>
				<i class="icon-backward" style="float:left"></i>
			</div>
							
			<div class="span3">
				<div class="listparticipants">
					<h6 id="demo" style="color:black"></h6>
				</div>
			</div>	
			<div class="span3 offset1">					
				<form>
					<input  type="email" name="user_email" placeholder="E-mail1"><br>
					<input  type="email" name="user_email2" placeholder="E-mail2"><br>
					<input  type="email" name="user_email3" placeholder="E-mail3"><br>
				</form>
			</div>
								
			<div class="span12 offset9">
				<button type="button" class="btn">Annuler</button>
				<button type="submit" class="btn btn-primary">Créer brainstorming</button>
			</div>
			
	     </div>
							
	</div>

     

    
    
    
     <?php include './common/footer.php'?>

    <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script>
		function copyText(y) 
		{
			x=document.getElementById("demo");  // Find the element
			x.innerHTML=y;    // Change the content
		}
	</script>

  </body>
</html>
