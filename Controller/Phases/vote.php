<?php
	session_start();
	require_once '../../Controller/membresActions/authentification.php';
	require_once '../../Model/Classes/Brainstorm.php';
	$brainstorm = new Brainstorm($_POST['id']);
	if($brainstorm->hasRights($_SESSION['Auth']['email'])&& !($brainstorm->hasVoted($_SESSION['Auth']['email'])))
	{
		$ideas = preg_split('/;/',$_POST['ideas'],NULL,PREG_SPLIT_NO_EMPTY);
		$sql = 'UPDATE vote SET nombre = nombre + 1 WHERE brainstorm = :brainstorm AND idea = :idea';
		$req = DBConnection::get()->prepare($sql);
		foreach($ideas as $idea){
			$q = Array('brainstorm'=>$_POST['id'], 'idea'=>$idea);
			$req->execute($q);
		}
		$q = Array('brainstorm'=>$_POST['id'], 'user'=>$_SESSION['Auth']['email']);
		$sql = 'UPDATE permission SET vote = 1 WHERE brainstorm = :brainstorm AND user = :user';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
	}
?>