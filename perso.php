<?php 
session_start();
require './membresActions/authentification.php';

if(Auth::islogged()){
}else{
	header("Location:index.php");	
	
}
?>
<!DOCTYPE html>
<html lang="en">
  
  <?php include './common/header.php' ?>
  
  <body>
    <?php include './common/navigation.php' ?>

    	<div class="container">
    	<div class="page-header">
    	<h2></h2>
    	</div>
	    	<div class="span5">
	   		<div class="acceuil">
				<title> Vous avez 0 brainstorms en cours </title>
				<a href="./profil.php" class="btn btn-large1">Mon Profil</a>
				<a href="./newbrainstorm.php" class="btn btn-large1">Nouveau Brainstorm</a>
				<a href="./mybrainstorms.php" class="btn btn-large1">Mes Brainstorms</a>
				<a href="./annuaire.php" class="btn btn-large1">Annuaire</a>
				<a href="./invite.php" class="btn btn-large1">Invitez des collaborateurs</a>
	   		</div>
			
			</div>
			<div class="span6">
			<div id="myCarousel" class="carousel slide">
				  <!-- Carousel items -->
				  <div class="carousel-inner">
				    <div class="active item">
					    <img class="imgslider" src="assets/img/slider1.jpg"/>
					    <div class="carousel-caption">
					    <h4>Restez connectés</h4>
<p>Avec SoPro, restez connectés et partagés vos idées avec vos collaborateurs où que vous soyez</p>
					    </div>
				    </div>
				    <div class="item">
					    <img class="imgslider" src="assets/img/slider2.jpg"/>
					    <div class="carousel-caption">
					    <h4>Gagnez en productivité</h4>
<p>Une expérience utilisateur évoluée, les frais de déplacements en moins</p>
					    </div>

				    </div>
				    <div class="item">
					    <img class="imgslider" src="assets/img/slider3.jpg"/>
					    <div class="carousel-caption">
					    <h4>Third Thumbnail label</h4>
<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
					    </div>
				    </div>
				    <div class="item">
					    <img class="imgslider" src="assets/img/slider4.jpg"/>
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
    <?php include './common/footer.php'?>

    <!-- /container -->
 
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="./js/slides.min.jquery.js"></script>

  </body>
</html>
