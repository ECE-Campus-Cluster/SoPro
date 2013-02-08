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
require '../../Controller/membresActions/authentification.php';
require '../../Model/Classes/user.php';

if(Auth::islogged()){
	$user = new User($_SESSION['Auth']['email']);
	$brainstorm=$user->getAllBrainstorm();
}else{
	header("Location:../../index.php");	
	
}
?>
<!DOCTYPE html>
<html lang="en">
  
  <?php include '../../View/common/header.php' ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>

    <div class="container">
    	<!-- <div class="page-header">
    		<h2>Brainstorms</h2>
    	</div>-->
    	<div class="article" >
    	<!--Affichage des brainstorm en cours appartenant à l'utilisateur -->
    		    	<!-- onglet de navigation -->
			<ul id="myTab" class="nav nav-tabs">
				  <li class="active"><a href="#encours" data-toggle="tab">Brainstorms en cours</a></li>
				  <li><a href="#terminés" data-toggle="tab" >Brainstorms terminés</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="encours">
					<ul class="thumbnails">
					<?php
						foreach($brainstorm['admin'] as $bstrm){
							$createur= new User($bstrm['createur']);
							/*creation du status*/
							$status='En cours';
							if($bstrm['phase']==0){
								$beginning = new DateTime($bstrm['dateDebut'].' '.$bstrm['heureDebut']);
								if(time()<$beginning->getTimestamp())
									$status='En attente';
							}elseif($bstrm['phase']==5){
								$status='Terminé';
							}
							print('
								<li class="span6">
									<div class="thumbnail">
										<div class="caption">
											<h4>'.$bstrm['nom'].'</h4>
											<p>'.$bstrm['description'].'</p>
											<p> By <a href="../../View/Site/profil.php?id='.$createur->email.'">'.$createur->prenom.' '.$createur->nom.'</a> démarrage le '.$bstrm['dateDebut'].' à '.$bstrm['heureDebut'].'</p>
											<p>
												<a href="../../View/Site/brainstorm.php?id='.$bstrm['brainstorm'].'" class="btn btn-primary">Entrer</a>
												<a href="../../View/Site/modifierbrainstorm.php?id='.$bstrm['brainstorm'].'" class="btn">Modifier</a>
												<b>   '.$status.'</b>
											</p>
										</div>
									</div>
								</li>
							');
						}
					?>
					</ul>
					<ul class="thumbnails">
					<?php
						foreach($brainstorm['participant'] as $bstrm){
							$createur= new User($bstrm['createur']);
							/*creation du status*/
							$status='En cours';
							if($bstrm['phase']==0){
								$beginning = new DateTime($bstrm['dateDebut'].' '.$bstrm['heureDebut']);
								if(time()<$beginning->getTimestamp())
									$status='En attente';
							}elseif($bstrm['phase']==5){
								$status='Terminé';
							}
							print('
								<li class="span6">
									<div class="thumbnail">
										<div class="caption">
											<h4>'.$bstrm['nom'].'</h4>
											<p>'.$bstrm['description'].'</p>
											<p> By <a href="../../View/Site/profil.php?id='.$createur->email.'">'.$createur->prenom.' '.$createur->nom.'</a> démarrage le '.$bstrm['dateDebut'].' à '.$bstrm['heureDebut'].'</p>
											<p>
												<a href="../../View/Site/brainstorm.php?id='.$bstrm['brainstorm'].'" class="btn btn-primary">Entrer</a>
												<b>   '.$status.'</b>
											</p>
										</div>
									</div>
								</li>
							');
						}
					?>
					</ul>
				</div>
				<div class="tab-pane fade" id="terminés">
					<ul class="thumbnails">
					<?php
						foreach($brainstorm['adminFinished'] as $bstrm){
							$createur= new User($bstrm['createur']);
							/*creation du status*/
							$status='En cours';
							if($bstrm['phase']==0){
								$beginning = new DateTime($bstrm['dateDebut'].' '.$bstrm['heureDebut']);
								if(time()<$beginning->getTimestamp())
									$status='En attente';
							}elseif($bstrm['phase']==5){
								$status='Terminé';
							}
							print('
								<li class="span6">
									<div class="thumbnail">
										<div class="caption">
											<h4>'.$bstrm['nom'].'</h4>
											<p>'.$bstrm['description'].'</p>
											<p> By <a href="../../View/Site/profil.php?id='.$createur->email.'">'.$createur->prenom.' '.$createur->nom.'</a> démarrage le '.$bstrm['dateDebut'].' à '.$bstrm['heureDebut'].'</p>
											<p>
												<a href="../../View/Site/brainstorm.php?id='.$bstrm['brainstorm'].'" class="btn btn-primary">Voir</a>
												<a href="../../View/Site/modifierbrainstorm.php?id='.$bstrm['brainstorm'].'" class="btn">Modifier</a>
												<b>   '.$status.'</b>
											</p>
										</div>
									</div>
								</li>
							');
						}
					?>
					</ul>
					<ul class="thumbnails">
				<?php
					foreach($brainstorm['participantFinished'] as $bstrm){
						$createur= new User($bstrm['createur']);
						/*creation du status*/
						$status='En cours';
						if($bstrm['phase']==0){
							$beginning = new DateTime($bstrm['dateDebut'].' '.$bstrm['heureDebut']);
							if(time()<$beginning->getTimestamp())
								$status='En attente';					}elseif($bstrm['phase']==5){
							$status='Terminé';
						}
						print('
							<li class="span6">
								<div class="thumbnail">
									<div class="caption">
										<h4>'.$bstrm['nom'].'</h4>
										<p>'.$bstrm['description'].'</p>
										<p> By <a href="../../View/Site/profil.php?id='.$createur->email.'">'.$createur->prenom.' '.$createur->nom.'</a> démarrage le '.$bstrm['dateDebut'].' à '.$bstrm['heureDebut'].'</p>
										<p>');
											if($status==="En cours"){
												print('<a href="#" class="btn btn-primary disabled"');
											}else{
												print('<a href="../../View/Site/brainstorm.php?id='.$bstrm['brainstorm'].'" class="btn btn-primary "');	
											}
											print('
											">Voir</a>
											<b>   '.$status.'</b>
										</p>
									</div>
								</div>
							</li>
						');
					}
				?>
				</ul>
				</div>
			</div>
    	</div>
	</div>
    <?php include '../../View/common/footer.php'?>
    <!-- /container -->
 
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../View/assets/js/jquery.js"></script>
    <script src="../../View/assets/js/bootstrap.js"></script>

  </body>
</html>
