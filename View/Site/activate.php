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
require_once '../../Controller/membresActions/cnx.php';
?>
<?php
	$token = $_GET['token'];
	$email = $_GET['email'];
	if(!empty($_GET)){
		$q = array('email'=>$email, 'token'=>$token);
		$sql = 'SELECT email,token FROM users WHERE email = :email AND token = :token';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$count=$req->rowCount($sql);
		if($count == 1){
			$v = array('email'=>$email, 'activer'=>'1');
			//Vérifier si l'utilisateur est actif
			$sql = 'SELECT email,activer FROM users WHERE email = :email AND activer = :activer';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($v);
			$dejactif = $req->rowCount($sql);
			
			if($dejactif==1){
				$error_actif = 'Votre compte utilisateur est déjà actif';
			}else{
				//Activation du compte
				$u = array('email'=>$email, 'activer'=>'1');
				$sql = 'UPDATE users SET activer = :activer WHERE email = :email';
				$req = DBConnection::get()->prepare($sql);
				$req->execute($u);
				$activated = 'Félicitation ! Votre compte vient d\'être activé';
			}
		}else{
			//Utilisateur inconnu
			$prob_token = 'Mauvais lien d\'activation.';

		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  
 <?php include('../../View/common/header.php'); ?>
  
  

  <body>
 <?php include('../../View/common/navigation.php'); ?>

    <div class="container">
    <?php
	    if(isset($error_actif)){
			print('<div class="alert alert-block">
		    <h4>Warning! </h4>'.$error_actif.'
		 	</div>
		 	<p><a class="btn btn-large btn-primary" href="../../index.php">Revenir à l\'accueil &raquo;</a></p>');
		}
		if(isset($prob_token)){
			print('<div class="alert alert-error alert-block">
		    <h4>Warning! </h4>'.$prob_token.'
		 	</div>
		 	<p><a class="btn btn-large btn-primary" href="../../index.php">Revenir à l\'accueil &raquo;</a></p>');
		}
	    if(!(isset($error_actif)||isset($prob_token))&& !(empty($_GET)))
	    {
		    print('<div class="alert alert-success alert-block"><h4>Félicitation!</h4> Votre compte a bien été activé.</div><p><a class="btn btn-large btn-primary" href="../../index.php">Revenir à l\'accueil &raquo;</a></p>');
		    
	    }
				 	
	?>
    
    
    
    
    <?php include('../../View/common/footer.php'); ?>
    </div><!-- /container -->

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
