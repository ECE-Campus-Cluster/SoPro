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
<style>
.link {
  stroke: #999;
  stroke-width: 2;
  cursor: crosshair;
}
</style>
<div class="span12" style="text-align:center">
      <h5 style="color:black; margin-top:-5px; margin-bottom:-5px;"><?php echo $brainstorm->nom; ?>  </h5>
 </div>
<!-- onglet de navigation -->
<ul id="myTab" class="nav nav-tabs">
	  <li class="active"><a href="#brainstorm" data-toggle="tab">Brainstorm</a></li>
	  <li><a href="#commentaires" data-toggle="tab" >Commentaires</a></li>
	  <li><a href="#recapitulatif" data-toggle="tab">Recapitulatif</a></li>
</ul>

<div if="myTabContent" class="tab-content">
<!---Premiere page - Brainstorm : PAD + Ajout compte rendu --->
 <div class="tab-pane fade active in" id="brainstorm">
	 <div id="chart">
     </div>
     <hr class="bs-docs-separator">
	 <div>
	 	<textarea id="cr" class="input-block-level" name="cr" rows="5" placeholder="Compte-rendu"></textarea>
	 </div>	
	      <hr class="bs-docs-separator">

	<div class="span11">
	          <a  href="../../View/Site/modifierbrainstorm.php?id=<?php echo $brainstorm->id; ?>" class="btn">Modifier</a>
	          <button class="btn btn-primary pull-right" onclick="$('#confirmModal').modal('show');" >Finir le brainstorm &raquo;</button>   
    </div>  
 </div>
 
 <!-- Deuxième page - Commentaires : tableau de commentaires sur les noeuds -->
 <div class="tab-pane fade" id="commentaires">
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
 
 <!-- Troisième page - Recapitulatif : Récapitulatif des informations du pad -->
 <div class="tab-pane fade" id="recapitulatif">
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
	if($tab=='') $tab ='<td></td>';
	foreach($brainstorm->competences as $cp)
	{
		if($competences=='') $competences = $competences.'<td>'.$cp.'</td>';
		else{ $competences = $competences.'<tr> <td></td><td>'.$cp.'</td> </tr>';}
	}
	if($competences=='') $competences ='<td></td>';
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
							   <td>Liste des participants </td>
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
 
</div>


<!-- Modal de confirmation de fin -->
<div id="confirmModal" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
	    Voulez-vous sauvegarder le compte-rendu tel qu'il est et finaliserle brainstorm ? <br/> Attention ! Vous ne pourrez plus revenir en arrière.
	</div>
	<div class="modal-footer">
		<button class="btn "  aria-hidden="true" data-dismiss="modal" >Annulez</button>
	    <a class="btn btn-primary"  href="../../View/Site/brainstorm.php?id=<?php echo $brainstorm->id;?>" aria-hidden="true" onclick="goCr();" >Validez</a>
	</div>
</div>

<script src="../../View/assets/js/d3.v3.min.js"></script>
<script src="../../Controller/Phases/pad-phase4.js"></script>
<script src="../../Controller/fonctions.js"></script>
