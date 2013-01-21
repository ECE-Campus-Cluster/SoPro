<?php
require_once './cnx.php';
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
  
  <head>
    <meta charset="utf-8">
    <title>Welcome to SoPro, the collaborative brainstorming tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="/assets/ico/favicon.png">
  </head>
  
  

  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="./index.php">SoPro</a>
          
          <div class="nav-collapse collapse">
          
	          <!---Navigation Bar when member not logged -->
	      <ul class="nav">
	          <li><a href="../index.php">Accueil</a></li>
	          <li><a href="../signup.php">S'inscrire</a></li>
	          <li><a href="../about.php">À propos de</a></li>
	          <li><a href="../contact.php">Contact</a></li>
	       </ul>
            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    <?php
	    if(isset($error_actif)){
			print('<div class="alert alert-block">
		    <h4>Warning! </h4>'.$error_actif.'
		 	</div>
		 	<p><a class="btn btn-large btn-primary" href="../index.php">Revenir à l\'accueil &raquo;</a></p>');
		}
		if(isset($prob_token)){
			print('<div class="alert alert-error alert-block">
		    <h4>Warning! </h4>'.$prob_token.'
		 	</div>
		 	<p><a class="btn btn-large btn-primary" href="../index.php">Revenir à l\'accueil &raquo;</a></p>');
		}
	    if(!(isset($error_actif)||isset($prob_token))&& !(empty($_GET)))
	    {
		    print('<div class="alert alert-success alert-block"><h4>Félicitation!</h4> Votre compte a bien été activé.</div><p><a class="btn btn-large btn-primary" href="../index.php">Revenir à l\'accueil &raquo;</a></p>');
		    
	    }
				 	
	?>
    
    
    
    
    <footer>
        <p style="text-align:center">&copy; Copyright ECE Paris 2013</p>
    </footer>

    </div><!-- /container -->

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
