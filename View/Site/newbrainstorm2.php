<?php
session_start();
require_once '../../Controller/membresActions/cnx.php'; 
require_once '../../Controller/membresActions/authentification.php';
require_once '../../Model/Classes/users.php';
require_once '../../Model/Classes/Brainstorm.php';
if(Auth::islogged()){
	//n'est pas propriétaire de ce pad 
	$currentB = new Brainstorm($_GET['id']);
	if($currentB->isAdminBstrm($_SESSION['Auth']['email'])){	
		
	}else{
		header("Location:../../View/Site/mesbrainstorms.php");
	}
	//le pad est deja creer ou n'existe pas
	if(!($currentB->isActive())){
	}else{
		header("location:../../index.php");
	}
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
		    	 <h3>Création d'un nouveau Brainstorm - Etape 2 : Choix des participants</h3>
		    </div>
		    <?php
    			$users=Users::getAll();
    		?>
    		<div id='error-block'>
    		</div>
	    
    		<div class="createbrainstorming">	
     		
	    		<div class="bs-docs-grid">
		    		<div class="row-fluid show-grid">
			    		<div class="span4">
			    			<h5>Annuaire de contacts</h5>
							<form id='recherche' onKeyPress="if (event.keyCode == 13||46) rechercher()">
			  				<input type="text" id="formInput" class="champs1"  name="bddsearch" placeholder="Rechercher" onkeydown="rechercher()">
			  				
			  				<input class="btn btn-primary btn-mini" onclick="rechercher()" value="Rechercher">
			  				<!-- <input class="btn btn-success btn-mini" value="Tous les contacts" onclick="history.go(0)"> -->
			  			
							</form>
		
							<div class="span12">
								<div class="listbdd7" id="drop1">	
									<input id="idhidden" type="hidden" name="id" value="<?php print($_GET['id']); ?>">
								    
									    <?php
										    foreach($users as $user){
											    if($user['email']!=$_SESSION['Auth']['email']){
												    print('<p class="btn btn-info btn-block " id="'.$user['email'].';drop1" draggable="true" >'.$user['prenom'].' '.$user['nom'].'</p>');
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
											foreach($currentB->competences as $cp){
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
										if($mail !=$_SESSION['Auth']['email']){
											$usercp = new User($mail);
											
											print('<p class="btn btn-info btn-block"  id="'.$usercp->email.';drop3" draggable="true" >'.$usercp->prenom.' '.$usercp->nom.'</p>');
										}
										
									}		?> 
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
								
																
								
					
								
								<div>
								</div>  
							</div>  
						</div>
					</div>  
						</div>
						<p><a class='btn span3 offset9' href='../../View/Site/mesbrainstorms.php' onclick="go()">Finir la création</a></p>
				</div>
					
			</div>	
		
	    	
	    		
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
    <script src="../../View/assets/js/h5utils.js"></script>
    <script src="../../Controller/fonctions.js"></script>

	<script type="text/javascript">
	newbrainstorm2();
		</script>
  </body>
</html>
