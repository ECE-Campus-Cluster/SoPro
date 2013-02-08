<style>
.link {
  stroke: #999;
  stroke-width: 2;
  cursor: crosshair;
}
h6{
	display:none;
}
div #headerPrint {
	display:none;
}

</style>
<div id="headerPrint"><img id="logoprint" src='../../View/assets/img/SoProLogo/SoProFin2.png' ><i>SoPro, outil de brainstorm collaboratif</i></div>
<div class="span12" style="text-align:center">
      <h5 style="color:black; margin-top:-5px; margin-bottom:-5px;"><?php echo $brainstorm->nom; ?>  </h5>
 </div>
<!-- onglet de navigation -->
<ul id="myTab" class="nav nav-tabs">
	  <li class="active"><a href="#brainstorm" data-toggle="tab">Brainstorm</a></li>
	  <li><a href="#commentaires" data-toggle="tab" >Commentaires</a></li>
	  <li><a href="#recapitulatif" data-toggle="tab">Récapitulatif</a></li>
</ul>

<div if="myTabContent" class="tab-content">
<h6>Compte-rendu du brainstorm</h6>
<!---Premiere page - Brainstorm : PAD + Ajout compte rendu --->
 <div class="tab-pane fade active in" id="brainstorm">
	 <div id="chart">
     </div>
     <hr class="bs-docs-separator">
	 <div>
	 	<p> <?php echo $brainstorm->compterendu; ?></p>
	 </div>
	 <hr class="bs-docs-separator">
	 <div>
	 	 <button  class="btn btn-success pull-right" onclick="window.print();" >Imprimer</button>
	</div>

 </div>
 <!-- Deuxième page - Commentaires : tableau de commentaires sur les noeuds -->
 <div class="tab-pane fade " id="commentaires">
 <h6 class='titrePrint'>Commentaires</h6>
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
 <h6 >Récapitulatif des informations du brainstorm</h6>
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
<script src="../../View/assets/js/d3.v3.min.js"></script>
<script src="../../Controller/Phases/pad-phase5.js"></script>