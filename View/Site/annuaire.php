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
require '../../Model/Classes/users.php';

if(Auth::islogged()){

}else{
	header("Location:../../index.php");	
}

?>

<!DOCTYPE html>
<html lang="en">


  
  <?php include '../../View/common/header.php'   ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>
  


    <div class="container">
  
 
    
    <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->		
    <?php
    	$users = Users::getAll();
	
    ?>
    
    	
    	<div class="page-header">
    	<h2>Carnet de contacts</h2>
    	</div>
     <div class="createbrainstorming">	
     		
      <div class="bs-docs-grid">
		<div class="row-fluid show-grid">
		<div class="span5">
	
				
				<form id='recherche' onkeypress="if (event.keyCode == 13||46) loadXMLDoc()">
  				<input type="text" id="nameu" class="champs1"  name="bddsearch" placeholder="Rechercher" onKeydown="loadXMLDoc()">
  				<input class="btn btn-primary btn-mini" onclick="loadXMLDoc()" value="Rechercher" />
				</form>
				
		
			<div class="span12">

	<div class="listbdd2" id="myDiv">
		
			<table class="table table-striped table-hover">
				
			<?php 
			foreach($users as $value)
				{
					if($value["email"]!=$_SESSION['Auth']['email'])
					echo '<tr><td id="'.$value["email"].'" href="#" onclick="loadUser(this.id);">'. $value["nom"].' '.$value["prenom"] .'</td></tr>';
				}		
			?>		
		
			</table>
			
			
		
		</div>	
		
			</div>
		
		

		</div>
		<div class="span1">
			<div class="trait">
			</div>
		</div>
		
		<div class="span5">
			<div class="span12">
			<div id="annuairecontent" class="listbdd3">
				<div  class="contentannuaire" >
					<div class="span6" style="margin-top:25px">
						<span> Cliquer sur vos contacts pour afficher leurs informations </span>
						<i class="icon-info-sign"></i>
						
						<br>
					</div>
					
					<div class="span3 offset2">
					
					</div>
				</div>
			
			
			
		</div>  

			</div>  
		</div>
		</div>  


      <hr>	
      
      </div>
     </div>	     
   </div>
     <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
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
    <script src="../../Controller/fonctions.js"></script>
 
	     
  </body>
</html>
