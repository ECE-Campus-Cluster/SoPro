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
    						<div class="span6">
    						<div class="page-header">
    						<h2>Agrandissez votre réseau</h2>
    						</div>
	    					<form >
							<input type="email" name="new_user" placeholder="E-mail1"><br>
							<input type="email" name="new_user2" placeholder="E-mail2"><br>
							<input type="email" name="new_user3" placeholder="E-mail3"><br>
							<button type="submit" class="btn">Envoyer invitations</button>
							</form>
    						</div>
    						
    						<div class="span5">
    						<img src="assets/img/bluetree.jpg"/>
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
