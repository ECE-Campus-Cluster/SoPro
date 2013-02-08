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
require '../../Controller/membresActions/authentification.php';
require '../../Model/Classes/users.php';
if(Auth::islogged()){
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
     	<div class="page-header">
		     <h3>Création d'un nouveau Brainstorm - Etape 1 : Informations générales</h3>
    	</div>
    	<div id="error-block"></div>

	    <div id="createbrainstorming" class="createbrainstorming">
	     <form id="brainstrmForm">
	     	<input id="idhidden" type="hidden" name="id" value="<?php $id=sha1(uniqid(rand())); print($id); ?>">
		     <div class="row">
			 	<div class="span12">
			  		<input class="span11" type="text" name="NomProjet" placeholder="Nom du Projet" min="2" required>
					<textarea rows="4"  cols="40" class="span11"  name="description" placeholder="Cadrage, Définition de la question de départ" 							required></textarea>
					<input class="span11" type="text" name="source" placeholder="Nom du premier point" min="2" required>
			 	</div>
		     </div>
				
			<div class="row" style="margin-top:20px;">	
				<div id="phases" class="span6">	
					<label for="datedebut">Date de début : </label>
					<input class="span5" type="date" name="datedebut" value="<?php $t=time(); print(date('Y',$t).'-'.date('m',$t).'-'.date('d',$t)); ?>" 							required>
					<label for="datedebut">Heure de début : </label>
					<input class="span5" type="text" value="<?php $t=time(); print(date('G',$t).":".date('i',$t));?>"name="heuredebut" required>
				</div>
			
				<div class="span5">
					<label for="dureePhase1">Durée de la phase 1:</label>
					<input class="span5" type="range" id="dureePhase1" name="dureePhase1" min="10" max="60" value="35" onchange="changeBorder1(this.value);" required><p 									id="valdureePhase1" style="display: inline-block; margin-left: 3px;"  >35 min</p>
					<label for="dureePhase2">Durée de la phase 2:</label>
					<input class="span5" type="range" id="dureePhase2" name="dureePhase2" min="1" max="24" value="12" onchange="changeBorder2(this.value);"												required><p id="valdureePhase2" style="display: inline-block; margin-left: 3px;">12 h</p>
			 	</div>	
			</div>		
			 	<div class="row">
			 		<div class="span5" style="margin-left:0px">
				 		<span class="span5" >Compétences Disponibles dans vos Contacts:</span><br>
											<span class="span12"> </span></br>
				 		<?php 
					      	$xml = simplexml_load_file('../../View/assets/xml/competences.xml');
					    	$competenceList = $xml->competence;
					    ?>
				 		<div id='drop1C' class="span5" >
						<?php
							foreach($competenceList as $competence){
						    		print('<p class="btn btn-block" id="'.$competence.'" draggable="true" >'.$competence.'</p>');
						    }
						?>
						</div>	
					</div>
					<span class="span1"></span>
					<div class="span5">
						<span class="span5">Compétences Requises pour Brainstorm: </span><br>
						<span class="span12"> </span></br>
							<div id='drop2C' class = "span5">
						</div>
						
					</div>
					
			 	</div>
			 	<br>
			 	</div>
			 	 </form>
				<div class="span1 offset11">
					  <button class="btn btn-primary" onclick="return go1();" >Suivant</button>
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
    <script src="../../Controller/fonctions.js"></script>
    
   
	<script type="text/javascript">
	newbrainstorm();
	</script>

  </body>
</html>