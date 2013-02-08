<?php 
	require '../../Model/Classes/user.php';
	
	if(isset($_POST['mail']))
	{
	
		$mail=$_POST['mail'];
		$users = new User($mail); 
		$users->getSocialNetworks();
		$ch="";
		for($i=0;$i<sizeof($users->competences);$i++)
		{
			$ch=$ch.'<span class="label label-inverse labele">'.$users->competences[$i].' </span>';
		}
		
		
		 
		 echo 	'<div class="contentannuaire" >
						<div class="span6">
							<span> Nom:<span style="color:#525aac"> '.$users->nom.' </span></span><br>
							<span> Prénom:<span style="color:#525aac"> '.$users->prenom.'</span></span><br>
							<span>Entreprise:<span style="color:#525aac"> '.$users->entreprise.'</span></span><br>
							<span> Poste actuel:<span style="color:#525aac"> '.$users->poste.'</span></span><br>
						</div>
						<div class="span3 offset2">
							<img src="';
							if($users->image===""){
								echo "https://prezi-a.akamaihd.net/assets/common/img/blank-avatar.jpg";
							}else{
								echo $users->image;
							}
							echo '" alt="'. $users->nom.' '.$users->prenom . '">
						</div>
					</div>
					<h5 class="span12 offset3"> Liste des compétences:	</h5>
					
								<span class="span12">'.$ch.'</span>
								
					<div class="imagecontactdbb">
						 
						<a href="mailto:'.$mail.'" ><img src="../../View/assets/img/mail.jpeg" class="img-polaroid" width="10%" height="12%" /></a>';
						if($users->linkedin)
						echo '<a href="http://www.linkedin.com/in/'.$users->linkedin.'" target="_blank"><img src="../../View/assets/img/linkedIn.png" class="img-polaroid" width="5%" height="5%" /></a>';
						if($users->viadeo)
						echo '<a href="http://www.viadeo.com/fr/profile/'.$users->viadeo.'" target="_blank"><img src="../../View/assets/img/viadeo.png" class="img-polaroid" width="5%" height="5%" /></a>';
						if($users->twitter)
						echo '<a href="http://twitter.com/'.$users->twitter.'" target="_blank"><img src="../../View/assets/img/twitter.jpeg" class="img-polaroid" width="5%" height="5%" /></a>';
						if($users->facebook)
						echo '<a href="http://www.facebook.com/'.$users->facebook.'" target="_blank"><img src="../../View/assets/img/fcb.jpeg" class="img-polaroid" width="5%" height="5%" /></a> ';
						if($users->googleplus)
						echo '<a href="http://plus.google.com/'.$users->googleplus.'" target="_blank"><img src="../../View/assets/img/googleplus.png" class="img-polaroid" width="5%" height="5%" /></a>
						 
					</div>
					
				';
	}
	
?>