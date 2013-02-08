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