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
	if(!(empty($_POST))){
		$user = new User($_SESSION['Auth']['email']);
		foreach($_POST as $email){
			if(!empty($email)){
				$to = $email;
				$sujet = 'Rejoignez la communauté SoPro';
				$body = 'Bonjour, '.$user->prenom.' '.$user->nom.' vous invite à rejoindre la communauté SoPro afin de pouvoir travailler en collaboration avec vous.<br/>SoPro est une outil de brainstorming collaboratif en ligne qui vous permettra de retirer le meilleur de vos séances de brainstorming.<br/><a   href="http://localhost/sopro/signup.php>Rejoignez la communauté maintenant !</a>';
				$entete = "MIME-Version: 1.0\r\n";
				$entete .= "Content-type: text/html; charset=UTF-8\r\n";
				$entete .= 'From: SoPro Brainstorming Tool Team' . '\r\n' . 'Reply-To: contact@sopro.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
				//mail($to,$sujet,$body,$entete);
			}
		}
	}
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
    						<div class="span6">
    						<div class="page-header">
    						<h2>Agrandissez votre réseau</h2>
    						</div>
	    					<form method="POST" action="./invite.php" >
								<input type="email" name="new_user1" placeholder="E-mail"><br>
								<input type="email" name="new_user2" placeholder="E-mail"><br>
								<input type="email" name="new_user3" placeholder="E-mail"><br>
							<input type="submit" class="btn" value='Envoyer invitations'>
							</form>
    						</div>
    						
    						<div class="span5">
    						<img src="../../View/assets/img/bluetree.jpg"/>
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
    <script src="../../View/assets/js/bootstrap-scrollspy.js"></script>
    <script src="../../View/assets/js/bootstrap-tab.js"></script>
    <script src="../../View/assets/js/bootstrap-tooltip.js"></script>
    <script src="../../View/assets/js/bootstrap-popover.js"></script>
    <script src="../../View/assets/js/bootstrap-button.js"></script>
    <script src="../../View/assets/js/bootstrap-collapse.js"></script>
    <script src="../../View/assets/js/bootstrap-carousel.js"></script>
    <script src="../../View/assets/js/bootstrap-typeahead.js"></script>
    <script>
       	function ajoutEmail(){
       		var count=4;
    		console.log(document.getElementById("emaildiv").innerHTML);
    		console.log(count);
	    	document.getElementById("emaildiv").innerHTML += '<input type="email" name="new_user'+count+'" placeholder="E-mail'+count+'"><br>';
	    	count=count+1;
	    	console.log(count);

    	}
  </body>
</html>