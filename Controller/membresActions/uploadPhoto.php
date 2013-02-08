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