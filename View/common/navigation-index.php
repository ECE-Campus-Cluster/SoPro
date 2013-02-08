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
<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand soproicone" href="index.php">SoPro</a>
          
          
          <div class="nav-collapse collapse">
          
	          <!---Navigation Bar when member not logged -->
	          <?php 
		          if (!isset($_SESSION['Auth']) || $_SESSION['Auth']==NULL) {
		          	print_r('
			          	<ul class="nav">
			              <li><a href="index.php">Accueil</a></li>
			              <li><a href="./View/Site/signup.php">S\'inscrire</a></li>
			              <li><a href="./View/Site/information.php">À propos de</a></li>
			              <li><a href="./View/Site/contact.php">Contact</a></li>
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
			              <li><a href="index.php">Accueil</a></li>
			              <li class="dropdown">
			              	<div class="btn-group">
				                <a class="btn btn-primary" href="./View/Site/home.php"><i class="icon-home icon-white"> </i>  Mon Espace</a>
				                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
				                <ul class="dropdown-menu">
				                  <li><a href="./View/Site/profil.php">Mon Profil</a></li>
				                  <li><a href="./View/Site/mesbrainstorms.php">Mes Brainstorms</a></li>
				                  <li><a href="./View/Site/newbrainstorm.php">Créer un Brainstorm</a></li>
				                  <li class="divider"></li>
				                  <li><a href="./View/Site/annuaire.php">Annuaire</a></li>
				                  <li><a href="./View/Site/invite.php">Invitez des contacts</a></li>
				                </ul>
				             </div>
			              </li>
			              <li><a href="./View/Site/information.php">À propos de</a></li>
			              <li><a href="./View/Site/contact.php">Contact</a></li>
			                </li>
			            </ul>
			            
		               	<div class="btn-group pull-right">
		                <a class="btn btn-primary" href="./View/Site/profil.php"><i class="icon-user icon-white"> </i>   '. $_SESSION['Auth']['prenom'].' '.$_SESSION['Auth']['nom'] .'</a>
		                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		                <ul class="dropdown-menu">
		                	<li><a href="./View/Site/modificationprofile.php"><i class="icon-pencil"></i> Modifier</a></li>
						    <li><a href="./Controller/membresActions/logout.php"><i class="icon-remove"></i> Log out</a></li>
						</ul>
						</div >
			            
			        ');
			   }
			?>
             
          </div><!--/.nav-collapse -->
        </div>
      </div>
</div>
