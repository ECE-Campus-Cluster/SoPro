<?php
require_once 'cnx.php';
require_once 'user.php';

class Users{
	
	public static function getAll(){
			$db = DBConnection::get();
			$res = $db->query("SELECT email, nom, prenom, entreprise, poste, competences FROM users")->fetchAll(PDO::FETCH_ASSOC);
	return $res;
			
	}
}

?>