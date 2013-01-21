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
	          <?php 
		          if (!isset($_SESSION['Auth']) || $_SESSION['Auth']==NULL) {
		          	print_r('
			          	<ul class="nav">
			              <li><a href="./index.php">Accueil</a></li>
			              <li><a href="./signup.php">S\'inscrire</a></li>
			              <li><a href="./about.php">À propos de</a></li>
			              <li><a href="./contact.php">Contact</a></li>
			            </ul>
			           <form class="navbar-form pull-right" method="POST" action="./index.php"> 
			           		<input class="span2" type="text" name="email" placeholder="Email"> 
			           		<input class="span2" type="password" name="password" placeholder="Password"> 
			           		<input type="submit" value="Sign In" class="btn">
			           </form>
			        '); 
		          }
				else { //Navigation bar if the member is logged
					print_r('
						<ul class="nav">
			              <li><a href="./index.php">Accueil</a></li>
			              <li class="dropdown">
			              	<div class="btn-group">
				                <a class="btn btn-primary" href="perso.php"><i class="icon-home icon-white"> </i>  Mon Espace</a>
				                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
				                <ul class="dropdown-menu">
				                  <li><a href="#">Mon Profil</a></li>
				                  <li><a href="#">Mes Brainstroms</a></li>
				                  <li><a href="./newbrainstorm.php">Créer un Brainstorm</a></li>
				                  <li class="divider"></li>
				                  <li><a href="#">Annuaire</a></li>
				                  <li><a href="#">Invitez des contacts</a></li>
				                </ul>
				             </div>
			              </li>
			              <li><a href="#about">À propos de</a></li>
			              <li><a href="#contact">Contact</a></li>
			                </li>
			            </ul>
			            
		               	<div class="btn-group pull-right">
		                <a class="btn btn-primary" href="#"><i class="icon-user icon-white"> </i>   '. $_SESSION['Auth']['prenom'].' '.$_SESSION['Auth']['nom'] .'</a>
		                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		                <ul class="dropdown-menu">
		                	<li><a href="./modificationprofile.php"><i class="icon-pencil"></i> Modifier</a></li>
						    <li><a href="./membresActions/logout.php"><i class="icon-remove"></i> Log out</a></li>
						</ul>
						</div >
			            
			        ');
			   }
			?>
             
          </div><!--/.nav-collapse -->
        </div>
      </div>
</div>
