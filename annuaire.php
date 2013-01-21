<?php 
session_start();
require './membresActions/authentification.php';
require './membresActions/users.php';
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
    
    <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->		
    <?php
    	$users = Users::getAll();
    	print_r($users);
    ?>
    	
    	<div class="page-header">
    	<h2>Carnet de contacts</h2>
    	</div>
     <div class="createbrainstorming">	
     		
      <div class="bs-docs-grid">
		<div class="row-fluid show-grid">
		<div class="span5">
	
	
		<form>
  				<input class="champs1" type="text" name="bddsearch" placeholder="Rechercher">
  				<button class="btn btn-primary btn-mini" type="submit">Rechercher</button>
								
		</form>	

     
		     <div class="pagination">
				<ul id="A">A</ul>
				<ul class="reachable">B</ul>
				<ul class="reachable">C</ul>
				<ul class="reachable">D</ul>
				<ul class="reachable">E</ul>
				<ul class="reachable">F</ul>
				<ul class="reachable">G</ul>
				<ul class="reachable">H</ul>
				<ul class="reachable">I</ul>
				<ul class="reachable">J</ul>
				<ul class="reachable">K</ul>
				<ul class="reachable">L</ul>
				<ul class="reachable">M</ul>
				<ul class="reachable">N</ul>
				<ul class="reachable">O</ul>
				<ul class="reachable">P</ul>
				<ul class="reachable">Q</ul>
				<ul class="reachable">R</ul>
				<ul class="reachable">S</ul>
				<ul class="reachable">T</ul>
				<ul class="reachable">U</ul>
				<ul class="reachable">V</ul>
				<ul class="reachable">W</ul>
				<ul class="reachable">X</ul>
				<ul class="reachable">Y</ul>
				<ul class="reachable">Z</ul>
			</div>

			<div class="span12">

	<div class="listbdd2">
		<ul class ="bddcontent">
			<li>Anthony OSMAR</li>

		</ul>
		</div>	
		
			</div>
		
		

		</div>
		<div class="span1">
			<div class="trait">
			</div>
		</div>
		
		<div class="span5">
			<div class="span12">
			<div class="listbdd3">
				<div class="contentannuaire" >
					<div class="span6" style="margin-top:25px">
						<span> Nom :</span><br>
						<span> Prénom :</span><br>
						<span> Poste actuel :</span><br>
					</div>
					
					<div class="span3 offset2">
					<img src="assets/img/elodie.jpg">
					</div>
				</div>
				<span id="competences" class="span12">Liste des compétences</span><br><br>
				<div class="contentannuaire2">
					<div class="span12">
					<table class="table table-striped">
					<tr>
						<th>Compétences</th>
						<th>Domaines</th>
						<th>Ajoutées le</th>
						<th>URL</th>
					</tr>
					<tr>
						<td>CSS</td>
						<td>WEB</td>
						<td>11/01/13</td>
						<td href="http://www.google.fr">www.google.fr</td>
					</tr>
					<tr>
						<td>HTML</td>
						<td>web</td>
						<td>11/01/13</td>
						<td>www.facebook.fr</td>
					</tr>
	 
					</table>
				</div>	
			</div>
			<div class="imagecontactdbb">
			<a href="http://www.apple.com/fr/"><img src="assets/img/fcb.jpeg" class="img-polaroid" width="10%" height="10%" /></a> 
			<a href="http://www.apple.com/fr/"><img src="assets/img/mail.jpeg" class="img-polaroid" width="10%" height="10%" /></a> 
			<a href="http://www.apple.com/fr/"><img src="assets/img/twitter.jpeg" class="img-polaroid" width="10%" height="10%" /></a> 
			</div>
			
		</div>

			</div>
		</div>
		</div>


      <hr>	
      
      </div>
     </div>	     
    
     <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
      <?php include './common/footer.php'?>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
