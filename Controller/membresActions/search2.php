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