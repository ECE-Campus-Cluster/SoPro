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
require_once './Controller/membresActions/cnx.php'; 
require_once './Model/Classes/AuthDrup.php'; 


if(!empty($_POST)){
	$email = $_POST['email'];
	$password = sha1($_POST['password']);
	$q = array('email'=>$email, 'password'=>$password, "activer" =>1);
	$sql = 'SELECT email, password, nom, prenom FROM users WHERE email = :email AND password = :password AND activer = :activer';
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
		header('Location:./View/Site/home.php');
	}else{
		$error_actif = "Erreur de connection. Verifier votre identifiant et/ou mot de passe";
	}
}
$uid="";
if(isset($_GET["drupalID"]))
{
	$uid=$_GET["drupalID"];
	$autDrup = new AuthDrup();
	
	if ($autDrup->islogged($uid))
	{
		header('Location:index.php');
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <?php include './View/common/header-index.php'; ?>
  
  <body>
    <?php include './View/common/navigation-index.php'; ?>
    
    <div class="hero-unit2 titreacceuil">
	     <h1>Inscrivez-vous!</h1>
	     <p>Une alternative innovante aux focus group</p>
	    <form method='POST' action='./View/Site/signup.php' name="signup">
		
			<input type="hidden" name="uid" value="<?php echo $uid;?>">
			 
			<input  type="submit" class="btn btn-primary btn-large"  value="S'inscrire" name="S'inscrire">
			
		</form>
	</div>
    <div class="container">
    	

      <!-- Main hero unit for a primary marketing message or call to action -->
     

      <!-- Example row of columns -->
      <div class="row">
        <div class="span6">
          <h4>Plus qu'un outils</h4>
          <p>Brainstorming personnel ou collaboratif, Gestion de réunion, Modélisation de contenu, Prise de notes, Aide à la prise de décision.... et plus encore. Découvrez ici tout ce que cet outil peut vous apporter.</p>
          <p><a class="btn" href="./View/Site/start.php">View details &raquo;</a></p>
       </div>
        <div class="span6">
          <h4>Présentation</h4>
          <p>SoPro a été réalisé par une équipe projet composée de 5 élèves de l'ECE Paris Ecole d'Ingénieurs.</p>
          <p><a class="btn" href="./View/Site/equipe.php">View details &raquo;</a></p>
        </div>
      </div>
      <br><br>
      
       </div> <!-- /container -->
      <?php include './View/common/footer-index.php'?>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./View/assets/js/jquery.js"></script>
    <script src="./View/assets/js/bootstrap-transition.js"></script>
    <script src="./View/assets/js/bootstrap-alert.js"></script>
    <script src="./View/assets/js/bootstrap-modal.js"></script>
    <script src="./View/assets/js/bootstrap-dropdown.js"></script>
    <script src="./View/assets/js/bootstrap-scrollspy.js"></script>
    <script src="./View/assets/js/bootstrap-tab.js"></script>
    <script src="./View/assets/js/bootstrap-tooltip.js"></script>
    <script src="./View/assets/js/bootstrap-popover.js"></script>
    <script src="./View/assets/js/bootstrap-button.js"></script>
    <script src="./View/assets/js/bootstrap-collapse.js"></script>
    <script src="./View/assets/js/bootstrap-carousel.js"></script>
    <script src="./View/assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>