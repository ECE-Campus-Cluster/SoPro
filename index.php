<?php 
session_start();
require_once './membresActions/cnx.php'; 
?>

<?php
if(!empty($_POST)){
	$email = $_POST['email'];
	$password = sha1($_POST['password']);
	$q = array('email'=>$email, 'password'=>$password);
	$sql = 'SELECT email, password, nom, prenom FROM users WHERE email = :email AND password = :password;';
	$req = DBConnection::get()->prepare($sql);
	$req->execute($q);
	$arr = $req->fetchAll();
	$count = $req->rowCount($sql);
	if($count == 1){
		//creation de la variable de session
		$_SESSION['Auth'] = array(
			'email' => $email,
			'password' => $password,
			'nom' => $arr[0]['nom'],
			'prenom'=> $arr[0]['prenom']
			);
		header('Location:perso.php');
	}else{
		$error_actif = "Erreur de connection. Verifier votre identifiant et/ou mot de passe";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <?php include './common/header.php' ?>
  
  <body>
    <?php include './common/navigation.php' ?>
    <div class="container">
    	

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit bandeau">
        <h1>SoPro</h1>
        <p>The collaborative brainstorming tool</p>
        <p><a href="./signup.php" class="btn btn-primary btn-large">Sign Up Now</a></p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span6">
          <h3>Plus qu'un outils</h3>
          <p>Brainstorming personnel ou collaboratif, Gestion de réunion, Modélisation de contenu, Prise de notes, Aide à la prise de décision.... et plus encore. Découvrez ici tout ce que cet outil peut vous apporter.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span6">
          <h3>Nos beta testeurs vous en parle</h3>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>
      <br><br>
      <blockquote>
	      <p>Une solution bien aboutie pour quelque chose développé en 1 mois par des étudiants</p>
	      <small>Steve Jobs <cite href="www.apple.fr">The Other World Time</cite></small>
  	</blockquote>

      <?php include './common/footer.php'?>

    </div> <!-- /container -->

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

  </body>
</html>
