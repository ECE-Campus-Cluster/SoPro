<?php 
session_start();

require './membresActions/authentification.php';
require './membresActions/user.php';


if(Auth::islogged()){
	//Modification des données de l'utilisateur si quelque chose a été posté
	if(!empty($_POST)){
		//si il y a eu modification du mail
		if($_POST['email']!=$_SESSION['Auth']['email']){
				$q = array('email'=>$_POST['email']);
				$sql = "SELECT * FROM users WHERE email= :email";
				$req = DBConnection::get()->prepare($sql);
				$req->execute($q);
				$count = $req->rowCount($sql);
				
			if($count != 0){ 
				//l'email est déjà associé à un compte
				$error_email="La modification des données n'a pas été effectuée car le nouvel email est déjà associé à un compte. Veuillez recommencer.";
			}else{ 
				$email = $_POST['email'];
			}
		}else{
			$email = $_SESSION['Auth']['email'];
		}
		
		//s'il y a eu modification du mot de passe
		if(!($_POST['newpassword']==="")){
			//mauvais password entrer
			if(!($_SESSION['Auth']['password']===sha1($_POST['oldpassword'])))
			{
				$error_oldpwd="Erreur lors de la saisie de votre mot de passe. Veuillez recommencer.";
			}
			else{ //pas d'erreur de saisie au niveau du mot de passe actuel
				//le nouveau mot de passe ne correspond pas à la confirmation
				if($_POST['newpassword']!=$_POST['confirmpassword'])
				{
					$error_newpwd="Le nouveau mot de passe et la confirmation du mot de passe son différent. Veuillez recommencer.";
				}
				else{ //pas d'erreur de saisie au niveau du nouveau mot de passe
					$password = sha1($_POST['newpassword']);
				}
			}	
		}else{ //pas de changement du mot de passe
			$password =  $_SESSION['Auth']['password'];
		}
		
		//Update de la base de données si pas d'erreur
		if(!(isset($error_email)||isset($error_newpwd)||isset($error_oldpwd))){
			//faire la liste de compétence
			$competences='';
			foreach($_POST['competences'] as $competence){
					$competences .= $competence.';'; 
			}
			$q = array('email'=>$_SESSION['Auth']['email'], 'mail'=>$email, 'password'=>$password,'nom'=>$_POST['nom'],'prenom'=>$_POST['prenom'],'poste'=>$_POST['poste'],'entreprise'=>$_POST['entreprise'],'competences'=>$competences);
			$sql = "UPDATE users SET prenom= :prenom, nom= :nom, email= :mail, entreprise= :entreprise, poste= :poste,password= :password, competences= :competences WHERE email= :email";
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$_SESSION['Auth']['email']=$email;
			$_SESSION['Auth']['password']=$password;
			$_SESSION['Auth']['prenom']=$_POST['prenom'];
			$_SESSION['Auth']['nom']=$_POST['nom'];
		}		
	}		
	$member = new User($_SESSION['Auth']['email']);
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
		
		<!--Messages d'erreur lié à la modification des données dans la base-->
		<?php
			
		 	if(isset($error_oldpwd)){
	    		print('<div class="alert alert-error alert-block">
			    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    <h4>Warning!</h4>'.$error_oldpwd.'
			 	</div>');
		 	}
		 	if(isset($error_newpwd)){
	    		print('<div class="alert alert-error alert-block">
			    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    <h4>Warning!</h4>'.$error_newpwd.'
			 	</div>');
		 	}
		 	if(!(isset($error_email)||isset($error_newpwd)||isset($error_oldpwd))&& !(empty($_POST)))
			 	print('<div class="alert alert-success"><b>Félicitation!</b> Votre compte a bien été modifié.</div>');
		?>
		<?php
			//recupération de la liste de compétence 
			$xml = simplexml_load_file('./assets/xml/competences.xml');
			$competenceList = $xml->competence;
		?>
	    <div class="article">
	    <form id='formModif' action="./modificationprofile.php" method="POST" onsubmit="return valider()">
	    	<fieldset class="control-group">
				<label class="control-label" for="prenom">Prénom</label>
				<input type="text" value="<?php print($member->prenom) ?>" name="prenom" maxlength="20">
				<p>Entrez votre vrai prénom afin que les personnes que vous connaissez puissent vous reconnaître.</p>
			</fieldset>
		    <fieldset class="control-group">
				<label class="control-label" for="nom">Nom</label>
				<input type="text" value="<?php print($member->nom) ?>" name="nom" maxlength="20">
				<p>Entrez votre vrai nom afin que les personnes que vous connaissez puissent vous reconnaître.</p>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="email">Email</label>
				<input type="text" value="<?php print($member->email) ?>" name="email" maxlength="20">
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="Entreprise">Entreprise</label>
				<input  type="text" value="<?php print($member->entreprise) ?>" name="entreprise" maxlength="20">
				<p>Entrez le nom de votre entreprise actuelle.</p>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="name">Poste</label>
				<input  type="text" value="<?php print($member->poste) ?>" name="poste" maxlength="20">
				<p>Entrez votre poste actuel au sein de votre entreprise.</p>
			</div>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="oldpassword">Ancien mot de passe</label>
				<input type="password" value="" name="oldpassword" maxlength="20">
				<p>Entrez votre mot de passe actuel afin de pouvoir le changer</p>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" id="p1" for="newpassword">Nouveau mot de passe</label>
				<input type="password" value="" name="newpassword" maxlength="20">
				<p>Entrez votre nouveau mot de passe.</p>
			</fieldset>
			<fieldset class="control-group">
				<label class="control-label" for="confirmpassword">Confirmation</label>
				<input type="password" value="" name="confirmpassword" maxlength="20">
				<p>Confirmer votre nouveau mot de passe</p>
			</fieldset>
			<!-- Competences-->
			<fieldset class="control-group">
			<label class="control-label" for="competences">Compétences</label>
			<?php 		 
				    	foreach($competenceList as $competence){
				    	    $bool=1;
				    		foreach($member->competences as $usercompetence){
					    		if($usercompetence==$competence){
						    		$bool=0;
					    		}	
				    		}
				    		if($bool){
					    		print('<input type="checkbox" name="competences[]" value="'.$competence.'" >'.$competence.'<br/>');
					    	}else{
						    	print('<input type="checkbox" name="competences[]" value="'.$competence.'" checked>'.$competence.'</br>');
					    	}
				    }
				?>
			</fieldset>
			<input class="btn btn-primary btn-medium" type="submit" value="Modifier">
		<form>
		</div>
    </div>
    
    
    <?php include './common/footer.php'?>

    <!-- /container -->
 <script type="text/javascript">
	function validatePass(p1, p2) {
	    if (p1.value != p2.value) {
	
	        p2.setCustomValidity('Mot de passe différent');
	
	    } else {
	        p2.setCustomValidity('');
	        
	
	    }
	}
</script>
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
