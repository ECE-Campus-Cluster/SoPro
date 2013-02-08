<?php
	session_start();
?>
<html>
<table class="table table-striped table-hover">

<?php 
require '../../Model/Classes/users.php';
 
 
 $users = Users::getAllBySearch($_POST['bddsearch']);
 if(!empty($users)){
	 foreach($users as $user)
	 {
	 	if($user->email!=$_SESSION['Auth']['email'])
		 echo '<tr><td id="'.$user->email.'" href="#" onclick="loadUser(this.id);">'.$user->nom .' '.$user->prenom.'</td></tr>';
	 }
	 
 }
 else{
	 
	  print("<div class='alert alert-error alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Pas de résultats</h4>
		 	</div>");

 }

		
?>

</table>
</html>