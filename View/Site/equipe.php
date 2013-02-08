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
?>
<!DOCTYPE html>
<html lang="en">
  <?php include '../../View/common/header.php'   ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>
  


    <div class="container">
    
    	<div class="page-header">
    		<h5>Chef de projet</h5>
    	</div>
    
    	<div class="row">
	    	<div class="span8">
				<div class="row details">
					<div class="span1 avatar">
						<img src="../../View/assets/img/maxence.png"/>
					</div>
					<div class="span5">
						<h5 class="name" style="font-family:TriplexSansExtraBold">Maxence Verneuil</h5>
						<span>Majeure: SI, Mineure: Métiers du Conseil</span><br>
						<span>Site web : Eclipse Day Paris</span><br>
						<span>Plateforme de trading VITA</span><br>
						<span>Objectif professionnel: Travailler dans les métiers du conseil.
						Chef de Projet (MOA)</span><br>	
					</div>
					
				</div>
			</div>
		</div>
		
    
		<div class="page-header">
    		<h5>Membres de l'équipe</h5>
    	</div>
	
    
    
    
    	<div class="row">
	    	<div class="span6">
				<div class="row details">
					<div class="span1 avatar">
						<img src="../../View/assets/img/marion.png"/>
					</div>
					<div class="span5">
						<h5 class="name" style="font-family:TriplexSansExtraBold">Marion Distler</h5>
						<span>Majeure: SI, Mineure: Métiers du Conseil</span><br>
						<span>Développement de modèles dans un cabinet de conseil en stratégie et organisation</span><br>
						<span>Objectif professionnel: Poursuivre une carrière dans les métiers du conseil</span><br>	
					</div>
					
				</div>
			</div>
			
			
			
	    <div class="span6">
			<div class="row details">
				<div class="span1 avatar">
					<img src="../../View/assets/img/elodie.jpg"/>
				</div>
				<div class="span5">
					<h5 class="name" style="font-family:TriplexSansExtraBold">Elodie Dufilh-Plassy</h5>
					<span>Majeure: SI, Mineure: Métiers du Conseil</span><br>
					<span>Développement du site de l’observatoire SIRH</span><br>
					<span>Objectif professionnel: Poursuivre dans les métiers du conseil SI (stage ING4 réalisé dans ce domaine)</span><br>	
				</div>
					
			</div>
		</div>  
    	</div>
			  
		<div class="row">
	    	<div class="span6">
				<div class="row details">
					<div class="span1 avatar">
						<img src="../../View/assets/img/alvynn.png"/>
					</div>
					<div class="span5">
						<h5 class="name" style="font-family:TriplexSansExtraBold">Alvynn Conhye</h5>
						<span>Majeure: SI , Mineure: Audiovisuel</span><br>
						<span>Développement de sites web en réponse aux besoins des PME (stage ING4)</span><br>
						<span>Objectif professionnel: Travailler dans la création de sites web et des technologies internet.</span><br>	
					</div>
				</div>
	    	</div>
	
			
			
	    <div class="span6">
			<div class="row details">
				<div class="span1 avatar">
					<img src="../../View/assets/img/anthony.png"/>
				</div>
				<div class="span5">
					<h5 class="name" style="font-family:TriplexSansExtraBold">Anthony Osmar</h5>
					<span>Majeure: SI, Mineure: Métiers du Conseil</span><br>
					<span>Développement d’un outil de gestion de portefeuille</span><br>
					<span>Objectif professionnel : Commencer sa carrière dans le conseil</span><br>						</div>
					
				</div>
			</div>
		</div>
    	</div>

		</div>
							<hr class="separator"/></div>    
     <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
      <?php include '../../View/common/footer.php'?>
      
      
    <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="../../View/assets/js/jquery.js"></script>
    <script src="../../View/assets/js/bootstrap-dropdown.js"></script>

  </body>
</html>
