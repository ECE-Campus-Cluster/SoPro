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
    
    <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
    <div class="page-header">
    	<h2>Mon Profil</h2>
    	</div>
    
    <div class="row">
	    <div class="span8">
			<div class="row details">
				<div class="span3 avatar">
					<img src="https://prezi-a.akamaihd.net/assets/common/img/blank-avatar.jpg" alt="Avatar of Titone Awesomar"/>
					</div>
					<div class="span5">
						<h1 class="name" style="font-family:TriplexSansExtraBold">Marion DISTLER</h1>
						<p class="about">
							<a href="/settings/about/">Dites quelque chose sur vous</a><br>
						<span>Date de Naissance :</span><br>
						<span>Poste actuel :</span><br>
						</p>
						<h5> Compétences :</h5>
						<span class="label label-inverse">C++</span>
						<span class="label label-inverse">HTML5</span>
						<span class="label label-important">Machine Learning</span>
						<span class="label label-important">Business model</span>
						<span class="label label-success">Membre du Rottary Club de Bordeaux</span>
					</div>

					</div>
				</div>
			</div>
		</div>
							<hr class="separator"/>
														<ul id="presentations" class="prezi-list thumbnails"/>
	</div>
	</div>    
     <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
      <?php include './common/footer.php'?>
      
      
    <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
