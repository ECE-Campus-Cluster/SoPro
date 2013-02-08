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
<!DOCTYPE html>
<html lang="en">
<style>
.link {
  stroke: #999;
  stroke-width: 2;
  cursor: crosshair;
}
</style>
  <?php include '../../View/common/header.php' ?>
  
  <body>
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
    	}    	
    ?>
    <div>
	    <h4  style="color:black"><?php echo $brainstorm->nom; ?>  </h4>
	     <hr class="bs-docs-separator">
	    <!-- Id du brainstorm dans un input caché -->
	    <input id="brainstormhidden" type="hidden" value="<?php print($_GET['id']); ?>">
	    <div >
	    	<h5>Compte-rendu</h5>
		    	 <div id="chart">
	     </div>
		 <div>
		 	<p> <?php echo $brainstorm->compterendu; ?></p>
		 </div>
		</div>
    </div>
    <div >
    	<h5>Commentaires</h5>
 <?php

		$string = file_get_contents("../../View/assets/json/".$brainstorm->id.".json");
		$json_a = json_decode($string, true);
		
		$node_name = array();
		$node_comment = array();
		
		
		foreach ($json_a['nodes'] as $data_array)
		{
			array_push($node_name, $data_array['name']);
			array_push($node_comment, $data_array['comment']);
			
		}

		$tab = '<table class="table"> <tr>
		       <th>Nom du Noeud</th>
		       <th>Commentaires</th>
		   </tr>
		 ';

		for($i=0; $i<sizeof($node_name);$i++)
		{
			if($node_comment[$i]!=""){
			$tab = $tab.'<tr> 
				<td> '.$node_name[$i].' </td> <td> '.$node_comment[$i].' </td>';
				}
		}

		$tab = $tab.'</table>'; ?>
	<div>
		<?php echo $tab; ?>
	</div>
	</div>
	
	<div >
    	<h5>Informations générales</h5>
<?php
	$list_participant = $brainstorm->getParticipants();
	
	$user = new User($brainstorm->createur);
	$tab = '';
	$competences="";
	foreach($list_participant as $liste)
	{
		if($tab=='') $tab = $tab.'<td>'.$liste->nom.' '.$liste->prenom.'</td>';
		else{ $tab = $tab.'<tr> <td></td><td>'.$liste->nom.' '.$liste->prenom.'</td> </tr>';}
	}
	
	foreach($brainstorm->competences as $cp)
	{
		if($competences=='') $competences = $competences.'<td>'.$cp.'</td>';
		else{ $competences = $competences.'<tr> <td></td><td>'.$cp.'</td> </tr>';}
	}
	
	$dDebut = explode("-", $brainstorm->dateDebut);
	
	$date = $dDebut[2].'/'.$dDebut[1].'/'.$dDebut[0];
	
		echo'
	
				<div>
						<table class="table table-striped" width="200"> 
							<tr>
							   <td>Administrateur du document      </td>
							   <td>'.$user->nom.' '.$user->prenom.'</td>
							</tr>
							<tr>
							   <td>Liste des participant </td>
							   '.$tab.'
						    </tr>
							<tr>
							   <td>Compétences associés au document </td>
							   '.$competences.'
						    </tr>
							<tr>
							   <td>Date de debut </td>
							   <td>'.$date.'</td>
						    </tr>
							<tr>
							   <td>Heure de debut </td>
							   <td>'.$brainstorm->heureDebut.'</td>
						    </tr>
						</table>
				</div>
		';
			
	?>
	</div>

    </div><!-- Le javascript 
    ================================================== -->
    
    <!-- Placed at the end of the document so the pages load faster -->
    <?php 
    	if($access==0){
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
  </body> 
</html>