<?php 
session_start();
require_once '../../Controller/membresActions/authentification.php';
require_once '../../Model/Classes/user.php';
if(Auth::islogged()){
	if(isset($_GET['user'])&&!empty($_GET['user'])){
		$mail=$_GET['user'];
	}else{
		$mail = $_SESSION['Auth']['email'];
	}
}else{
	header("Location:../../index.php");	
	
}
$user = new User($mail);
$ch="";
for($i=0;$i<sizeof($user->competences);$i++)
{
	$ch=$ch.'<span class="label label-inverse labele">'.$user->competences[$i].' </span>';
}
?>
<!DOCTYPE html>
<html lang="en">
  
  <?php include '../../View/common/header.php' ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>

    	<div class="container">
	    <div class="page-header">
	    	<h2>Profil</h2>
	    </div>
	    
	    <div class="row">
		    <div class="span8">
				<div class="row details">
					<div class="span3 avatar">
						<img src="<?php if($user->image==""){echo "https://prezi-a.akamaihd.net/assets/common/img/blank-avatar.jpg";}else{echo $user->image;}?>" alt="<?php echo $user->nom.' '.$user->prenom; ?>" />
					</div>
					<div class="span5">
						<h1 class="name" style="font-family:TriplexSansExtraBold"><?php echo $user->nom.' '.$user->prenom; ?></h1>
						<p class="about">
							<span>Entreprise: <?php echo $user->entreprise; ?></span><br>
							<span>Poste actuel: <?php echo $user->poste; ?></span><br>
						</p>
						<h5> Compétences:</h5>
						<span><?php echo $ch; ?></span>
					</div>
				</div>
			</div>
			
			<?php
			if($user->email==$_SESSION['Auth']['email']){
				print('
					<div class="span3 offset9">
								    <a class="btn" href="../../View/Site/modificationprofile.php">Modifier mon profil</a>
					</div>
				');
			}
			?>
		</div>		
		<hr class="separator"/>
	
	</div>
    <!-- /container -->	   
    <?php include '../../View/common/footer.php'?>
    
 
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
