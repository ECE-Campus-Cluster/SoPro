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
	require_once "../../Controller/membresActions/cnx.php";
	// Where the file is going to be placed 
	$target_path = "../../View/assets/img_users/";
	/*Look if there was already an image for the user - if so delete it*/
	$q = array('email'=>$_SESSION['Auth']['email']);
	$sql = 'SELECT image from users  WHERE email= :email';
	$req = DBConnection::get()->prepare($sql);
	$req->execute($q);
	$count=$req->rowCount($sql);
	if($count==1){
		$arr = $req->fetchAll();
		if(file_exists($arr[0]['image'])){
					unlink($arr[0]['image']);
		}
	}
	/*change the target path name*/
	$split = preg_split('/\./',$_FILES['file']['name'],NULL,PREG_SPLIT_NO_EMPTY);
	$target_path = $target_path .$_SESSION['Auth']['email'].".".$split[(count($split)-1)];
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
	    print("<div class='alert alert-success alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Félicitations!</h4> Votre photo de profil a bien été uploadée.
		 	</div>");
	} else{
	    print("<div class='alert alert-error alert-block'>
		    <button type='button' class='close' data-dismiss='alert'>&times;</button>
		    <h4>Warning!</h4> Problème lors de l'upload. Veuillez recommencez.
		 	</div>");
	}
	/*put the correct path in mysql*/
	$q = array('email'=>$_SESSION['Auth']['email'], 'image'=>("../../View/assets/img_users/".$_SESSION['Auth']['email'].".".$split[(count($split)-1)])); 
	$sql = 'UPDATE users SET image = :image WHERE email= :email';
	$req = DBConnection::get()->prepare($sql);
	$req->execute($q);
	
?>