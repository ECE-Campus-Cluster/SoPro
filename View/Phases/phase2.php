<script src="../../View/assets/js/d3.v3.min.js"></script>
<style>
body {
  font: 13px sans-serif;
  position: relative;
  width: 960px;
  height: 500px;
}

.node g{
  cursor: crosshair;
}

.node_selected circle {
  stroke:#2EFE2E;
}

.node_selected text {
	fill:black;
}

.drag_line {
  stroke: #999;
  stroke-width: 2;
  pointer-events: none;
}

.drag_line_hidden {
  stroke: #999;
  stroke-width: 0;
  pointer-events: none;
}

.link {
  stroke: #999;
  stroke-width: 2;
}

.link_selected{
	stroke:#2EFE2E;
}
text{
	color:black;
	
}
</style>
<div class="container2">
      <div class="row">
	      <img style="position: fixed; top: 0; left: 0; border: 0; z-index: 10000" src="../../View/assets/img/phase2.png" alt="Phase 2"/>
	      <div class="span12">
		      <div class="span9" style="text-align:center">

		     	 <h4  style="color:black"><?php echo $brainstorm->nom; ?>  </h4>
		      </div>
	      </div>
        <div class="span8">
   
              <div id="chart">
              </div>
         			    	
        </div><!--/span-->
        
       <div class="span2 offset2">
       	  <div id="counter"></div>
       	  <button style="width:inherit; font-family:TriplexSansExtraBold;padding:5px
" class="btn btn-large btn-primary disabled" disabled="disabled">Nom du Noeud</button>
	      <div id="nodeInfo" class="well2" style="font-weight:bold">
          </div><!--/.well -->
           <button style="width:inherit; font-family:TriplexSansExtraBold;padding:5px
" class="btn btn-large btn-primary disabled" disabled="disabled">Commentaires</button>
          <div id="nodeInfo2" class="well2" style="font-weight:bold">
          </div><!--/.well -->
		  <div id='nodeId' value="0">  </div> 

		  <div>
		  	<p> Participant ayant voté : <?php echo $brainstorm->getNbVote()."/".$brainstorm->getNbParticipant(); ?> </p>
		  </div>
        </div><!--/span-->
        
        <blockquote class="span12"><p><?php echo $brainstorm->description ?></p></blockquote>
         <?php
          		if($brainstorm->hasVoted($_SESSION['Auth']['email'])){
          			print('<div class="span12 ">');
          			print('<a  href="../../View/Site/modifierbrainstorm.php?id='.$brainstorm->id.'" class="btn">Modifier</a>');
	          		print(' <button class="btn btn-primary  disabled pull-right" onclick="" >Validez</button>');
	          		print(' <button class="btn pull-right" onclick="$(\'#confirmModalNext\').modal(\'show\');" >Passez à la phase 3 &raquo;</button>');
	          		print('</div>');
          		}else{
          			print('<div class="span10"><a  href="../../View/Site/modifierbrainstorm.php?id='.$brainstorm->id.'" class="btn">Modifier</a>');
          			print('<button class="btn btn-primary offset10 span2" onclick="$(\'#confirmModal\').modal(\'show\');" >Validez</button></div>');

          		}
          ?>

      </div><!--/row-->

      <hr><!--/.fluid-container-->

<!-- Modal de confirmation de vote -->
<div id="confirmModal" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
	    Voulez-vous valider votre vote ? <br/> Attention ! Une fois votre vote pris en compte, vous ne pourrez plus le changer.
	</div>
	<div class="modal-footer">
		<button class="btn "  aria-hidden="true" data-dismiss="modal" >Annulez</button>
	    <a href="../../View/Site/brainstorm.php?id=<?php echo $brainstorm->id ?>" class="btn btn-primary"  aria-hidden="true" onclick="voteValidation();" >Validez</a>
	</div>
</div>

<div id="confirmModalNext" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
	    Voulez-vous passer à la phase suivante ? <br/> Attention ! Les participants n'ayant pas encore voté ne pourront plus le faire.
	</div>
	<div class="modal-footer">
		<button class="btn "  aria-hidden="true" data-dismiss="modal" >Annulez</button>
	    <button  class="btn btn-primary " aria-hidden="true" onclick="passerSuivant();" >Validez</button>
	</div>
</div>

<script src="../../Controller/Phases/pad-phase2.js"></script>
<script src="../../Controller/fonctions.js"></script>