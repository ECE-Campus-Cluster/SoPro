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
      <img style="position: fixed; top: 0; left: 0; border: 0; z-index: 10000" src="../../View/assets/img/phase1.png" alt="Phase 1"/>

      <div class="span8">
      <div class="span9" style="text-align:center">
      <h4  style="color:black"><?php echo $brainstorm->nom; ?>  </h4>
     
      </div>
      <div class="offset4 span1">
       
        
       </div>
      </div>
        <div class="span8">
   
              <div id="chart">
			  
          </div>
                   			    	
        </div><!--/span-->
        
        <div class="span2 offset2" id="compteur">
        
        </div>
       <div class="span2 offset2">
       	  <div id="counter"></div>
       	  <button style="width:inherit; font-family:TriplexSansExtraBold; padding:5px
" class="btn btn-large btn-primary disabled" disabled="disabled">Nom du Noeud</button>
	      <div id="nodeInfo" class="well2" style="font-weight:bold">
          </div><!--/.well -->
           <button style="width:inherit; font-family:TriplexSansExtraBold; padding:5px
" class="btn btn-large btn-primary disabled" disabled="disabled">Commentaires</button>
          <div id="nodeInfo2" class="well2" style="font-weight:bold">
          </div><!--/.well -->
		  <div id='nodeId' value="0">  </div> <br>
		  <span class="span12"></span><br>

		  
        </div><!--/span-->

        
        <blockquote class="span12"><p><?php echo $brainstorm->description ?></p></blockquote>

      </div><!--/row-->
      <?php if($access==2){
     		print('<div class="span12"><a  href="../../View/Site/modifierbrainstorm.php?id='.$brainstorm->id.'" class="btn">Modifier</a>');
     		print(' <button class="btn btn-primary pull-right" onclick="$(\'#confirmmodalnext\').modal(\'show\');" >Passez à la phase 2 &raquo;</button>'); 
     		}?>
      	
      <hr/>
<!--/.fluid-container-->
<!-- MODALS-->
<div id="confirmmodalnext" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body">
	    Voulez-vous passer à la phase suivante ? <br/> Attention ! Plus aucunes idées ne pourront être ajoutées.
	</div>
	<div class="modal-footer">
		<button class="btn "  aria-hidden="true" data-dismiss="modal" >Annulez</button> 
	    <button class="btn btn-primary " aria-hidden="true" onclick="foo();" >Validez</button>
	</div>
</div>

<div id="ModalReconnexion" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		Problème de connexion au serveur
	</div>
	<div class="modal-body">
	    Vous avez été déconnecté du service.
	    Prochaine tentative de connexion dans <b id='tentative'></b>
	</div>
	<div class="modal-footer">
	    <a href="../../View/Site/mesbrainstorms.php" class="btn btn-primary " aria-hidden="true" >Retournez à mes brainstorms</a>
	</div>
</div>

<div id="ModalConnexion" class="modal hide" tabindex="-1" role="confirm" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		Problème de connexion au serveur
	</div>
	<div class="modal-body">
	    Un erreur est survenue lors de la connexion au serveur. 
	    Veuillez réessayer ulterieurement	</div>
	<div class="modal-footer">
		<button class="btn" aria-hidden="true" onclick="window.location.reload();"> Rafraichir </button>
	    <a href="../../View/Site/mesbrainstorms.php" class="btn btn-primary " aria-hidden="true" >Retournez à mes brainstorms</a>
	</div>
</div>

<div id="ModalJumpStart" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 	<div class="modal-header">
	    Phase terminée ! 
	</div>
	<div class="modal-body">
	    <p>L'administrateur de votre brainstorm vient d'achever la phase prématurément. Vous pouvez maintenant passer directement à la phase de vote ou revenir à vos brainstorms et voter ulterieurement.</p>
	</div>
	<div class="modal-footer">
		<button class="btn"  aria-hidden="true" onclick="redirectBrainstorms()" >Retour vers mes brainstorms &raquo;</button>
	    <button class="btn"  aria-hidden="true" onclick="window.location.reload()" >Passez à la phase 2 &raquo;</button>
	</div>
</div>

<script src="../../node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="../../Controller/Phases/pad-phase1.js"></script>
<script src="../../Controller/fonctions.js"></script>