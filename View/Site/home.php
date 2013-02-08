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

if(Auth::islogged()){
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
    	<div class="page-header">
    	<h2></h2>
    	</div>
	    	<div class="span5">
	   		<div class="acceuil">
				<a href="../../View/Site/profil.php" class="btn btn-large1">Mon Profil</a>
				<a href="../../View/Site/newbrainstorm.php" class="btn btn-large1">Nouveau Brainstorm</a>
				<a href="../../View/Site/mesbrainstorms.php" class="btn btn-large1">Mes Brainstorms</a>
				<a href="../../View/Site/annuaire.php" class="btn btn-large1">Annuaire</a>
				<a href="../../View/Site/invite.php" class="btn btn-large1">Invitez des collaborateurs</a>
	   		</div>
			
			</div>
			<div class="span6">
			<div id="myCarousel" class="carousel slide">
				  <!-- Carousel items -->
				  <div class="carousel-inner">
				    <div class="active item">
					    <img class="imgslider" src="../../View/assets/img/slider1.jpg"/>
					    <div class="carousel-caption">
					    <h4>Restez connectés</h4>
<p>Avec SoPro, restez connectés et partagés vos idées avec vos collaborateurs où que vous soyez</p>
					    </div>
				    </div>
				    <div class="item">
					    <img class="imgslider" src="../../View/assets/img/slider2.jpg"/>
					    <div class="carousel-caption">
					    <h4>Gagnez en productivité</h4>
<p>Une expérience utilisateur évoluée, les frais de déplacements en moins</p>
					    </div>

				    </div>
				    <div class="item">
					    <img class="imgslider" src="../../View/assets/img/slider3.jpg"/>
					    <div class="carousel-caption">
					    <h4>Third Thumbnail label</h4>
<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
					    </div>
				    </div>
				    <div class="item">
					    <img class="imgslider" src="../../View/assets/img/slider4.jpg"/>
					    <div class="carousel-caption">
					    <h4>Third Thumbnail label</h4>
<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
					    </div>
				    </div>

				  </div>
				  <!-- Carousel nav -->
				  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
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
    <script src="../../View/assets/js/bootstrap-transition.js"></script>
    <script src="../../View/assets/js/bootstrap-alert.js"></script>
    <script src="../../View/assets/js/bootstrap-modal.js"></script>
    <script src="../../View/assets/js/bootstrap-dropdown.js"></script>
    <script src="../../View/assets/js/bootstrap-tab.js"></script>
    <script src="../../View/assets/js/bootstrap-tooltip.js"></script>
    <script src="../../View/assets/js/bootstrap-popover.js"></script>
    <script src="../../View/assets/js/bootstrap-button.js"></script>
    <script src="../../View/assets/js/bootstrap-collapse.js"></script>
    <script src="../../View/assets/js/bootstrap-carousel.js"></script>
    <script src="../../View/assets/js/bootstrap-typeahead.js"></script>
  </body>
</html>
