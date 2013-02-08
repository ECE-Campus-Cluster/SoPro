<?php
session_start();
require_once '../../Controller/membresActions/cnx.php'; 

//si il y a eu modification du mail
if($_POST['email']!=$_SESSION['Auth']['email']){
		$q = array('email'=>$_POST['email']);
		$sql = 'SELECT * FROM users WHERE email= :email';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$count = $req->rowCount($sql);
		
	if($count != 0){ 
		//l'email est déjà associé à un compte
		$error_email="La modification des données n'a pas été effectuée car le nouvel email est déjà associé à un compte. Veuillez recommencer.";
		print("<div class='alert alert-error alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Warning!</h4>".$error_email."
		 	</div>");

	}else{ 
		$email = $_POST['email'];
	}
}else{
	$email = $_SESSION['Auth']['email'];
}
	
//s'il y a eu modification du mot de passe
if(!($_POST['newpassword']==='')){
	//mauvais password entrer
	if(!($_SESSION['Auth']['password']===sha1($_POST['oldpassword'])))
	{
		$error_oldpwd='Erreur lors de la saisie de votre mot de passe. Veuillez recommencer.';
		print("<div class='alert alert-error alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Warning!</h4>".$error_oldpwd."
		 	</div>");

	}
	else{ //pas d'erreur de saisie au niveau du mot de passe actuel
		//le nouveau mot de passe ne correspond pas à la confirmation
		if(strlent($_POST['newpassword'])!=0){
			if($_POST['newpassword']!=$_POST['confirmpassword'])
			{
				$error_newpwd='Le nouveau mot de passe et la confirmation du mot de passe sont différents. Veuillez recommencer.';
	    		print("<div class='alert alert-error alert-block'>
			    <button type='button' class='close' data-dismiss='alert'>&times;</button>
			    <h4>Warning!</h4>".$error_newpwd."
			 	</div>");
			}
			else{ //pas d'erreur de saisie au niveau du nouveau mot de passe
				$password = sha1($_POST['newpassword']);
			}
		}
	}	
}else{ //pas de changement du mot de passe
	$password =  $_SESSION['Auth']['password'];
}
	
//Update de la base de données si pas d'erreur
if(!(isset($error_email)||isset($error_newpwd)||isset($error_oldpwd))){
	if(strlen($_POST['nom'])<2){
		print("<div class='alert alert-error alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Warning!</h4>Votre nom doit contenir au moins 2 caractères.
		 	</div>");
	}else if(strlen($_POST['prenom'])<2){
		print("<div class='alert alert-error alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Warning!</h4>Votre prénom doit contenir au moins 2 caractères.
		 	</div>");
	}else{
		//faire la liste de compétence
		$twitter=addslashes($_POST['twitter']);
		$facebook=addslashes($_POST['facebook']);
		$viadeo=addslashes($_POST['viadeo']);
		$linkedin=addslashes($_POST['linkedin']);
		$googleplus=addslashes($_POST['googleplus']);
	
		$q = array('email'=>$_SESSION['Auth']['email'], 'mail'=>$email, 'password'=>$password,'nom'=>ucwords($_POST['nom']),'prenom'=>ucwords($_POST['prenom']),'poste'=>ucwords($_POST['poste']),'entreprise'=>$_POST['entreprise'],'competences'=>$_POST['competences'], "twitter"=>$_POST['twitter'], "googleplus"=>$_POST['googleplus'], "facebook"=>$_POST['facebook'], "viadeo"=>$_POST['viadeo'], "linkedin"=>$_POST['linkedin']);
		$sql = 'UPDATE users SET prenom= :prenom, nom= :nom, email= :mail, entreprise= :entreprise, poste= :poste,password= :password, competences= :competences, twitter= :twitter, linkedin= :linkedin, facebook= :facebook, viadeo= :viadeo, googleplus= :googleplus WHERE email= :email';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$_SESSION['Auth']['email']=$email;
		$_SESSION['Auth']['password']=$password;
		$_SESSION['Auth']['prenom']=$_POST['prenom'];
		$_SESSION['Auth']['nom']=$_POST['nom'];
		print("<div class='alert alert-success alert-block'>
			    <button type='button' class='close' data-dismiss='alert'>&times;</button>
			    <h4>Félicitations!</h4> Votre compte a bien été modifié.
			 	</div>");
	}
}

?>