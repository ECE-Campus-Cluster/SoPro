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
  stroke:#FF0000;
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
	stroke:#FF0000;
}

text{
	color:black;
	
}
</style>
<div class="container2">
      <div class="row">
      <img style="position: fixed; top: 0; left: 0; border: 0; z-index: 10000" src="../../View/assets/img/phase3.png" alt="Phase 3"/>      
      <div class="span12">
     <div class="span9" style="text-align:center">
      <h4  style="color:black"><?php echo $brainstorm->nom; ?>  </h4>
     
      </div>
      </div>
        <div class="span8">
   
              <div id="chart">
          </div>
        </div>
        <div class="span2 offset2" id="compteur">
        
        </div>
      <div class="span2 offset2">
       	  <button style="width:inherit; font-family:TriplexSansExtraBold;padding:5px
" class="btn btn-large btn-primary disabled" disabled="disabled">Nom du Noeud</button>
	      <div id="nodeInfo" class="well2" style="font-weight:bold">
          </div><!--/.well -->
           <button style="width:inherit; font-family:TriplexSansExtraBold;padding:5px
" class="btn btn-large btn-primary disabled" disabled="disabled">Commentaires</button>
          <div id="nodeInfo2" class="well2" style="font-weight:bold">
          </div><!--/.well -->
		  <div id='nodeId' value="0">  </div> 

	
        </div><!--/span-->
	      <blockquote class="span12"><p><?php echo $brainstorm->description ?></p></blockquote> 
	      <div class="span12">
	          <a  href="../../View/Site/modifierbrainstorm.php?id=<?php echo $brainstorm->id; ?>" class="btn ">Modifier</a>
	          <button class="btn btn-primary pull-right" onclick="$('#confirmModal').modal('show');" >Passez à la phase 4 &raquo;</button>   
	      </div>   			    	
     </div><!--/span-->
          
     

      <hr>
<!--/.fluid-container-->
<!-- Modal de confirmation de vote -->
<div id="confirmModal" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
	    Voulez-vous sauvegarder le mind-map tel qu'il est et passer à la phase suivante ? <br/> Attention ! Vous ne pourrez plus revenir en arrière.
	</div>
	<div class="modal-footer">
		<button class="btn "  aria-hidden="true" data-dismiss="modal" >Annulez</button>
	    <button class="btn btn-primary"  aria-hidden="true" onclick="validation();" >Validez</button>
	</div>
</div>



<script src="../../Controller/Phases/pad-phase3.js"></script>
<script src="../../Controller/fonctions.js"></script>
