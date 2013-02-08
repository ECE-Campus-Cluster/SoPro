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
