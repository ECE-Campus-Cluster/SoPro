<?php
	require_once "../../Model/Classes/Brainstorm.php";
	print("inside");
	$bstrm = new Brainstorm($_POST['id']);
	print_r($bstrm);
	if(isset($_POST['cr'])){
		$q = Array('id'=> $_POST['id'], "cr"=> $_POST['cr']);
		$sql = 'UPDATE brainstorming SET compterendu = :cr WHERE id = :id';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$brainstorm = new Brainstorm($_POST['id']);
		print('saved');
		}
	$bstrm->nextPhase();
	print_r($bstrm);
?>