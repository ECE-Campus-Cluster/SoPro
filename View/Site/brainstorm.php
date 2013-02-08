<?php 
session_start();
require_once '../../Controller/membresActions/authentification.php';
require_once '../../Model/Classes/Brainstorm.php';

if(Auth::islogged()){
	$brainstorm = new Brainstorm($_GET['id']);
 	//Verification des droits de l'utilisateur sur le brainstorm
 	if($brainstorm->isAdminBstrm($_SESSION['Auth']['email'])){
	 	$access=2;
 	}else{
 		if($brainstorm->hasRights($_SESSION['Auth']['email'])){
	 		$access=1;
 		}else{
	 		$access=0;
 		}
 	} 
}else{
	header("Location:/index.php");	
}
?>

<?php $ok=0; ?>
<!DOCTYPE html>
<html lang="en">
	<script src="../../View/assets/js/jquery.js"></script>
<script src="../../View/assets/js/bootstrap.js"></script>
  <?php include '../../View/common/header.php' ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>
    
    <div class="container">
    <!-- Gestion des non droits d'access avec des fenêtres modales -->
    <?php
    	if($access == 0){
	    	//Pas droit d'accès à ce brainstorm
	    	//Contacter le propriétaire du brainstorm pour y avoir accèss
	    	print('
	    	 <div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    	 	<div class="modal-header">
				    <h3 id="myModalLabel">Impossible d\'accéder au brainstorm</h3>
				</div>
				<div class="modal-body">
				    <p>Vous ne possédez aucun droit de participation au brainstorm <b>'.$brainstorm->nom.'</b>.</p>
				</div>
				<div class="modal-footer">
				    <button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstroms &raquo;</button>
				</div>
			</div>
');
    	}else{
    		//Possède un droit d'accès au brainstorm
	    	if($brainstorm->phase == 0){	
	    		if($access==1){
	    		//Participant d'un brainstorm qui n'a pas encore commencé
	    		print('
			    	<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    	 	<div class="modal-header">
						    <h3 id="myModalLabel">Trop tôt !</h3>
						</div>
						<div class="modal-body">
						    <p>La phase 1 du brainstorm <b>'.$brainstorm->nom.'</b> démarrera le <b>'.$brainstorm->dateDebut.'</b> à <b>'.$brainstorm->heureDebut.'</b> .<br/>Veuillez revenir à ce moment.</p>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary"  onclick="document.location.reload()" aria-hidden="true">Rafraichir la page</button>
						    <button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstroms &raquo;</button>
						</div>
					</div>
				');
				}else{
		    		//le propriétaire d'un brainstorm qui n'a pas encore commencé
		    		//ajout bouton modifier 
		    		print('
				    	<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    	 	<div class="modal-header">
							    <h3 id="myModalLabel">Trop tôt !</h3>
							</div>
							<div class="modal-body">
							    <p>La phase 1 du brainstorm <b>'.$brainstorm->nom.'</b> démarrera le <b>'.$brainstorm->dateDebut.'</b> à <b>'.$brainstorm->heureDebut.'</b> .<br/>Veuillez revenir à ce moment.</p>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary"  onclick="document.location.reload()" aria-hidden="true">Rafraichir la page</button>
								<button class="btn btn-primary"  onclick="redirectModifier()" aria-hidden="true">Modifier brainstrom</button>
							    <button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstroms &raquo;</button>
							</div>
						</div>
					');
	    		}
	    	}else if(($brainstorm->phase==3||$brainstorm->phase==4)&&$access==1){
		    	//un participant essaye d'acceder à des phases reservées à l'admin
		    	print('
			    	<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    	 	<div class="modal-header">
						    <h3 id="myModalLabel">Désolé</h3>
						</div>
						<div class="modal-body">
						    <p>Le brainstorm <b>'.$brainstorm->nom.'</b> est entré dans des phases de travail seulement disponible à son administrateur.<br/> Lorsque les conclusions seront rendues vous pourrez y accéder à partir de la rubrique <b><i>Mes Brainstorms passés</i></b>.</p>
						</div>
						<div class="modal-footer">
						    <button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstroms &raquo;</button>
						</div>
					</div>'
				);
			}elseif($brainstorm->phase==2&&$brainstorm->hasVoted($_SESSION['Auth']['email'])&&$access==1){
	    	//un participant essaye d'acceder à des phases reservées à l'admin
		    	print('
			    	<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    	 	<div class="modal-header">
						    <h3 id="myModalLabel">Vous avez déjà voté pour les idées du brainstorm !</h3>
						</div>
						<div class="modal-body">
						    <p>Lorsque les votes et les phases ultérieurs du brainstorm <b>'.$brainstorm->nom.'</b> seront terminés, vous pourrez accéder aux conclusions dans la rubrique <b><i>Mes Brainstorms passés</i></b>.</p>
						</div>
						<div class="modal-footer">
						    <button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstorms &raquo;</button>
						</div>
					</div>'
				);
		    }
		    else{
			    $ok=1;
		    }
	}
    	
    ?>
    
    <!-- Affichage du countdown si durant la phase 1 et 2 -->
    <?php
    	if(($brainstorm->phase==1)||($brainstorm->phase==2)){
    		$nextDate = new DateTime($brainstorm->dateDebut.' '.$brainstorm->heureDebut);
			$duree = preg_split('/:/',$brainstorm->dureePhase1,NULL,PREG_SPLIT_NO_EMPTY);
			$nextDate->add(date_interval_create_from_date_string($duree[0]." hours "));
			$nextDate->add(date_interval_create_from_date_string($duree[1]." min "));
			$nextDate->add(date_interval_create_from_date_string($duree[2]." seconds "));
    		if($brainstorm->phase==2){
				$duree = preg_split('/:/',$brainstorm->dureePhase2,NULL,PREG_SPLIT_NO_EMPTY);
				$nextDate->add(date_interval_create_from_date_string($duree[0]." hours "));
				$nextDate->add(date_interval_create_from_date_string($duree[1]." min "));
				$nextDate->add(date_interval_create_from_date_string($duree[2]." seconds "));	  
    		}
    		$currentTime = new DateTime("now");
    		$startDate = date_diff($nextDate,$currentTime);
    	}   
    ?>
    <!-- Id du brainstorm dans un input caché -->
    <input id="brainstormhidden" type="hidden" value="<?php print($_GET['id']); ?>">
    <!--Appel des differentes pages en fonction de la phase en cour -->
    <?php
    	switch($brainstorm->phase){
	    	case 1 : 
	    			include '../../View/Phases/phase1.php';
	    			break;
	    	case 2 : 
	    		    include '../../View/Phases/phase2.php';
	    			break;
	    	case 3 :
	    		    include '../../View/Phases/phase3.php';
	    			break;
	    	case 4 : 
	    		    include '../../View/Phases/phase4.php';
	    			break;
	    	case 5 : 
	    		    include '../../View/Phases/phase5.php';
	    			break;
    	}
    ?>
    
     	
     	<?php include '../../View/common/footer.php'?>
    </div>
     <!-- /container -->
     <!-- Modal changement de phase -->
     <?php 
     if($brainstorm->phase==1){
	    echo ' <div id="ModalNextPhase" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		 	<div class="modal-header">
			    Phase terminée ! 
			</div>
			<div class="modal-body">
			    <p>La phase 1 du brainstorm vient de s\'achever. Vous pouvez maintenant passer directement à la phase de vote ou revenir à vos brainstorm et voter ulterieurement.</p>
			</div>
			<div class="modal-footer">
				<button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstorms &raquo;</button>
			    <button class="btn"  aria-hidden="true" onclick="window.location.reload()" >Passez à la phase 2 &raquo;</button>
			</div>
		</div>';
	 }else if($brainstorm->phase==2 && $access==2){
		 echo ' <div id="ModalNextPhase" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		 	<div class="modal-header">
			    Phase terminée ! 
			</div>
			<div class="modal-body">
			    <p>La phase 2 du brainstorm vient de s\'achever. Vous pouvez maintenant faire le compte-rendu du brainstorm ou revenir à vos brainstorm et voter ulterieurement.</p>
			</div>
			<div class="modal-footer">
				<button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstorms &raquo;</button>
			    <button class="btn"  aria-hidden="true" onclick="window.location.reload()" >Passez à la phase 3 &raquo;</button>
			</div>
		</div>';
	 }else if($brainstorm->phase==2 && $access==1){
		 echo ' <div id="ModalNextPhase" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		 	<div class="modal-header">
			    Phase terminée ! 
			</div>
			<div class="modal-body">
			    <p>La phase 2 du brainstorm vient de s\'achever. Vous pouvez maintenant revenir à vos brainstorm et y trouver le compte-rendu de ce brainstorm quand il sera terminé.</p>
			</div>
			<div class="modal-footer">
				<button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstorms &raquo;</button>
			</div>
		</div>';
	 } ?>
 <!-- Le javascript 
    ================================================== -->
    
    <!-- Placed at the end of the document so the pages load faster -->
    
	<script src="../../View/assets/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
    <?php 
    	if(!$ok){
    		echo "
		    <script>
			$(document).ready(
		    	$('#myModal').modal({
		    		show: true,
		    		backdrop: 'static',
		    		keyboard: false
		    		})
		   	);
		    </script> ";
	    }
	?>
    <script>
    	function redirectBrainstorms(){
	    	window.location.replace('../../View/Site/mesbrainstorms.php');
    	}
    </script>
    <script>
    	function redirectModifier(){
	    	window.location.replace(<?php print('\'../../View/Site/modifierbrainstorm.php?id='.$brainstorm->id.'\'');?>);
    	}
    </script>
        
        <?php
  if($brainstorm->phase==1||$brainstorm->phase==2){
		 echo ' 
		 <script>
		 	$(function(){
		        $("#counter").countdown({
		          image: "../../View/assets/img/digits.png",
		          startTime: "' ; 
		          print($startDate->format("%H:%I:%S")); 
		          echo '",
		          timerEnd :  function(){$("#ModalNextPhase").modal({
		    		show: true,
		    		backdrop: "static",
		    		keyboard: false
		    		})}
		        });
		
		      });
		      </script>';
      } ?>
    
  </body> 
</html>