<?php 
session_start();
require_once '../../Controller/membresActions/authentification.php';
require_once '../../Controller/membresActions/cnx.php';

if(Auth::islogged()){
	header("location:../../index.php");
}

$uid ="";
if(isset($_POST['uid'])) $uid = $_POST['uid'];

if(!empty($_POST) && strlen($_POST['nom'])>1 && strlen($_POST['entreprise'])>1 && strlen($_POST['poste'])>1 && strlen($_POST['prenom'])>1 && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['password']===$_POST['confirm_password']){
	/*Verification que l'email n'est pas déjà associé à un compte*/
	$q = array('email'=>addslashes($_POST['email']));
	$sql = 'SELECT email,token FROM users WHERE email = :email';
	$req = DBConnection::get()->prepare($sql);
	$req->execute($q);
	$count=$req->rowCount($sql);
	if($count==0){ 
		//l'email n'est associé à aucun autre compte donc creation de l'user en db
		$nom = ucwords(addslashes($_POST['nom']));
		$prenom = ucwords(addslashes($_POST['prenom']));
		$entreprise=addslashes($_POST['entreprise']);
		$poste=ucwords(addslashes($_POST['poste']));
		$password = sha1($_POST['password']);
		$email=addslashes($_POST['email']);
		$token = sha1(uniqid(rand()));
		$q = array('nom'=>$nom, 'prenom'=>$prenom, 'email'=>$email, 'password'=>$password, 'entreprise'=>$entreprise, 'poste'=>$poste,'token'=>$token, 'drupalID'=>$uid);
		$sql = 'INSERT INTO users (nom, prenom, email, password, entreprise, poste, token, drupalID) VALUES (:nom, :prenom, :email, :password, :entreprise, :poste, :token, :drupalID)';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);

	
		//Envoyer un mail de confirmation d'activation du compte
		$to = $email;
		$sujet = 'Activation de votre compte SoPro';
		$body = '
		Bonjour, veuillez activer votre compte en cliquant ici -> 
		<a   href="http://localhost/View/Site/activate.php?token='. $token .'&email=' .$to .'" >Activation du compte</a>';
		$entete = "MIME-Version: 1.0\r\n";
		$entete .= "Content-type: text/html; charset=UTF-8\r\n";
		$entete .= 'From: SoPro Brainstorming Tool' . '\r\n' . 'Reply-To: contact@sopro.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		//mail($to,$sujet,$body,$entete);
	}else{
			//l'email est déjà associé à un compte, renvoi d'un message d'erreur
			$error_userexist = "Cette adresse email est déjà associée à un compte soPro.";
	}
	
	
}else if(!(isset($_POST['nom']))){
}else if(!empty($_POST) && strlen($_POST['nom'])<2){
	$error_nom = 'Votre nom doit contenir au minimum 2 caractères';
}else if(!empty($_POST) && strlen($_POST['prenom'])<2){
	$error_prenom = 'Votre prénom doit contenir au minimum 2 caractères';
}else if(!empty($_POST) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$error_email = 'Votre email est invalide';
}else if(!empty($_POST) && $_POST['password']!=$_POST['confirm_password']){
	$error_password = 'Vos mots de passe ne sont pas identiques';
}else if(!empty($_POST) && strlen($_POST['entreprise'])<2){
	$error_entreprise = 'Le nom de votre entreprise doit contenir au minimum 2 caractères';
}else if(!empty($_POST) && strlen($_POST['poste'])<2){
	$error_poste = 'Votre poste doit contenir au minimum 2 caractères';
}

?>

<!DOCTYPE html>
<html lang="en">

  <?php include '../../View/common/header.php' ?>
  <body>
    <?php include '../../View/common/navigation.php' ?>

       <div class="container">
             
    <!-- Message d'erreur -->
	<?php
		if(isset($error_nom)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_nom.'
		 	</div>');
	 	}
	 	if(isset($error_password)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_password.'
		 	</div>');
	 	}
	 	if(isset($error_prenom)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_prenom.'
		 	</div>');
	 	}
	 	if(isset($error_email)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_email.'
		 	</div>');
	 	}
	 	if(isset($error_entreprise)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_entreprise.'
		 	</div>');
	 	}
	 	if(isset($error_poste)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_poste.'
		 	</div>');
	 	}
	 	if(isset($error_userexist)){
    		print('<div class="alert alert-error">
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Warning! </strong>'.$error_userexist.'
		 	</div>');
	 	}
	 	if(((!(isset($error_email)||isset($error_password)||isset($error_userexist)||isset($error_nom)||isset($error_prenom)||isset($error_password)||isset($error_entreprise)||isset($error_poste))) && !(empty($_POST)))){
	 			if(isset($_POST['uid'])&&!isset($_POST['nom'])){}
	 			else{
	 				print('<div class="alert alert-success"><b>Félicitation!</b> Votre compte a bien été créé. Un mail vous a été envoyé afin de l\'activer</div>');
	 			}
		 	}
?>

	<!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Bienvenue!</h1>
        <p>SoPro est une plateforme de brainStorming qui vous permet de collaborer avec votre équipe où que vous soyez....</p>
        <p><a class="btn btn-primary btn-large" href="../../View/site/information.php">Plus d'infos &raquo;</a></p>
      </div>
	
	<div class="signup">
				<form action="./signup.php" method="POST" onsubmit="return valider()">
  				<input class="champs1" type="text" name="nom" placeholder="Nom" value="<?php if(isset($_POST['nom'])){print($_POST['nom']);}else{print('');}?>"  required>
  				<input class="champs1" type="text" name="prenom" placeholder="Prénom" value="<?php if(isset($_POST['prenom'])){print($_POST['prenom']);}else{print('');} ?>" required><br>
				<input class="champs" type="email" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])){print($_POST['email']);}else{print('');} ?> " required><br>
				<input class="champs" type="text" name="entreprise" placeholder="Entreprise" value="<?php if(isset($_POST['entreprise'])){print($_POST['entreprise']);}else{print('');} ?>" required><br>
				<input type="hidden" value="<?php echo $uid; ?>" name="uid">
				<input class="champs" type="text" name="poste" placeholder="Poste" value="<?php if(isset($_POST['poste'])){print($_POST['poste']);}else{print('');} ?>" required><br>
				<input class="champs" type="password" id="p1" name="password" placeholder="Mot de passe" required><br>
				<input class="champs" type="password" name="confirm_password" required placeholder="Confirmation Mot de passe" onfocus="validatePass(document.getElementsById('p1'), this);" oninput="validatePass(document.getElementById('p1'), this);" ><br>
				 <label class="checkbox">
					 <input type="checkbox" required> En cochant cette case, j'accepte les <a href="cdu.php">Conditions d'Utilisation</a>
				</label>
				<input class="btn btn-primary btn-medium" type="submit" value="Submit">
		</form>
		
	</div>
	</div>


</script> 

      <hr>
    
    <?php include '../../View/common/footer.php'?>

    <!-- /container -->
 <script type="text/javascript">
	function validatePass(p1, p2) {
	    if (p1.value != p2.value || p1.value == '' || p2.value == '') {
	
	        p2.setCustomValidity('Mot de passe différent');
	
	    } else {
	        p2.setCustomValidity('');
	        
	
	    }
	}
</script>
    

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <script src="../../View/assets/js/jquery.js"></script>
    <script src="../../View/assets/js/bootstrap-transition.js"></script>
    <script src="../../View/assets/js/bootstrap-alert.js"></script>
    <script src="../../View/assets/js/bootstrap-modal.js"></script>
    <script src="../../View/assets/js/bootstrap-dropdown.js"></script>
    <script src="../../View/assets/js/bootstrap-scrollspy.js"></script>
    <script src="../../View/assets/js/bootstrap-tab.js"></script>
    <script src="../../View/assets/js/bootstrap-tooltip.js"></script>
    <script src="../../View/assets/js/bootstrap-popover.js"></script>
    <script src="../../View/assets/js/bootstrap-button.js"></script>
    <script src="../../View/assets/js/bootstrap-collapse.js"></script>
    <script src="../../View/assets/js/bootstrap-carousel.js"></script>
    <script src="../../View/assets/js/bootstrap-typeahead.js"></script> 

  </body>
</html>
