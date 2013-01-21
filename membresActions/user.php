<?php
require_once 'cnx.php';

class User{

	//properties
	public $nom;
	public $prenom;
	public $email;
	public $password;
	public $entreprise;
	public $poste;
	public $competences;
	
	public function __construct($email = NULL){
		if($nom==NULL)
			$nom="";
		if($prenom==NULL)
			$prenom="";
		if($email==NULL)
			$email="";
		if($entreprise==NULL)
			$entreprise="";
		if($poste==NULL)
			$poste="";
			
		if($email){
			$q = array('email'=>$email);
			$sql = "SELECT * FROM users WHERE email= :email";
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$arr = $req->fetchAll();
			$this->nom =  $arr[0]['nom'];
			$this->prenom =  $arr[0]['prenom'];
			$this->email =  $arr[0]['email'];
			$this->password = $arr[0]['password'];
			$this->entreprise = $arr[0]['entreprise'];
			$this->poste =  $arr[0]['poste'];
			$this->competences = preg_split('/;/',$arr[0]['competences'],NULL,PREG_SPLIT_NO_EMPTY);
		}
	}
	
	
}


?>
