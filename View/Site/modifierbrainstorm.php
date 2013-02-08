<?php 
session_start();
require_once '../../Controller/membresActions/cnx.php'; 
require '../../Controller/membresActions/authentification.php';
require '../../Model/Classes/Brainstorm.php';
if(Auth::islogged()){
	$brainstorm = new Brainstorm($_GET['id']);
 	//Verification des droits de l'utilisateur sur le brainstorm
 	if(!$brainstorm->isAdminBstrm($_SESSION['Auth']['email']))
 		header("Location:mesbrainstorms.php");
}else{
	header("Location:../../index.php");	
}

?>
<!DOCTYPE html>
<html lang="en">

  
  <?php include '../../View/common/header.php' ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>

     <input id="brainstormhidden" type="hidden" value="<?php print($_GET['id']); ?>">
     <input id="phasehidden" type="hidden" value="<?php print($brainstorm->phase); ?>">
     <div id="container" class="container"> 
		<h3>Modification du brainstorm - Statuts : <?php if($brainstorm->phase==0){print("En attente de démarrer");}elseif($brainstorm->phase==5){print("Terminé");}else{print("En cours de phase ".$brainstorm->phase);} ?></h3>
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#">Informations générales</a></li>
		  <li><a href="./modifierparticipants.php?id=<?php echo $_GET['id'];?>">Liste des Participants</a></li>
		</ul>
		<div id="error-block"></div>
	    <div id="createbrainstorming" class="createbrainstorming">
	     <form id="brainstrmForm">
		     <div class="row">
			 	<div class="span12">
			  		<input class="span11" type="text" name="NomProjet" placeholder="Nom du Projet" min="2" value="<?php echo $brainstorm->nom; ?>" required>
					<textarea rows="4"  cols="40" class="span11"  name="description" placeholder="Cadrage, Définition de la question de départ" 		required><?php echo $brainstorm->description; ?></textarea>
					<input class="span11 " type="text" name="source" placeholder="Nom du premier point" min="2" value="<?php echo $brainstorm->source; ?>" required <?php if($brainstorm->phase>0){echo 'disabled';}?>>
			 	</div>
		     </div>
				
			<div class="row" style="margin-top:10px;">	
				<div id="phases" class="span6">	
					<label for="datedebut">Date de début : </label>
					<input class="span5 " type="date" name="datedebut" value="<?php echo $brainstorm->dateDebut; ?>" required <?php if($brainstorm->phase>0){echo 'disabled';}?>>
					<label for="datedebut">Heure de début : </label>
					<input class="span5 " type="text" value="<?php echo $brainstorm->heureDebut; ?>"name="heuredebut" required <?php if($brainstorm->phase>0){echo 'disabled';}?>>
				</div>
			
				<div class="span5">
					<label for="dureePhase1">Durée de la phase 1:</label>
					<input class="span5 " type="range" id="dureePhase1" name="dureePhase1" min="10" max="60" value="<?php $duree = preg_split('/:/',$brainstorm->dureePhase1,NULL,PREG_SPLIT_NO_EMPTY); echo $duree[1]; ?>" onchange="changeBorder1(this.value);" required <?php if($brainstorm->phase>1){echo 'disabled';}?>><p 									id="valdureePhase1" style="display: inline-block; margin-left: 3px;"><?php echo $duree[1] ?> min</p>
					<label for="dureePhase2">Durée de la phase 2:</label>
					<input class="span5 " type="range" id="dureePhase2" name="dureePhase2" min="1" max="24" value="<?php $duree = preg_split('/:/',$brainstorm->dureePhase2,NULL,PREG_SPLIT_NO_EMPTY); echo $duree[0]; ?>" onchange="changeBorder2(this.value);"												required <?php if($brainstorm->phase>2){echo 'disabled';}?>><p id="valdureePhase2" style="display: inline-block; margin-left: 3px;"><?php echo $duree[0] ?>h</p>
			 	</div>			
			</div>
			 	<div class="row">
			 		<div class="span5" style="margin-left:0px">
			 	
			 		<?php 
				      	$xml = simplexml_load_file('../../View/assets/xml/competences.xml');
				    	$competenceList = $xml->competence;
				    ?>
				   <span class="span5">Compétences Disponibles dans vos Contacts:</span><br>
											<span class="span12"> </span></br>	 		
											<div id='drop1C' class = "span5">
					    	<?php 	
							    	foreach($competenceList as $competence){
							    	    $bool=1;
							    		foreach($brainstorm->competences as $taggedcompetence){
								    		if($taggedcompetence==$competence){
								    			$bool=0;
								    		}
							    		}
							    		if($bool){
								    		print('<p class="btn btn-block" id="'.$competence.'" draggable="true" >'.$competence.'</p>');
								    	}
								    }
							?>
				</div>
				</div>
				<span class="span1"></span>
					<div class="span5">
						<span class="span5">Compétences Requises pour Brainstorm: </span><br>
						<span class="span12"> </span></br>
							<div id='drop2C' class = "span5">
				
						    	<?php 	
								    	foreach($brainstorm->competences as $competence){
									    		print('<p class="btn btn-block" id="'.$competence.'" draggable="true" >'.$competence.'</p>');
									    }
								?>
							</div>
					</div>
				  				
		     </div>
	     </form>	
	     <div class="span3 offset8">
						<a class="btn btn-danger" onclick="$('#confirmModal').modal('show');">Supprimer</a>
					    <button class="btn btn-success" onclick="return go_modifbrn();" >Enregistrer</button>
		</div>		
	</div>
    </div>
     <?php include '../../View/common/footer.php'?>

    <!-- /container -->

     
     <!-- modal-->
     <div id="confirmModal" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
	    Êtes-vous sur de vouloir supprimer ce brainstorm?
	</div>
	<div class="modal-footer">
		<button class="btn "  aria-hidden="true" data-dismiss="modal" >Annulez</button>
	    <a href="../../View/Site/mesbrainstorms.php" class="btn btn-primary " aria-hidden="true" onclick="supprimer();" >Validez</a>
	</div>
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
		

	</script>
	<script type="text/javascript">
	modifierbrainstorm();
	</script>	    
  </body>
</html>
