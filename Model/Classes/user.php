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
require_once '../../Controller/membresActions/cnx.php';

class User{

	//properties
	public $nom;
	public $prenom;
	public $email;
	public $password;
	public $entreprise;
	public $poste;
	public $competences;
	public $linkedin;
	public $viadeo;
	public $twitter;
	public $facebook;
	public $googleplus;
	public $image;
	
	public function __construct($email = NULL){
		if($this->nom==NULL)
			$this->nom="";
		if($this->prenom==NULL)
			$this->prenom="";
		if($this->email==NULL)
			$this->email="";
		if($this->entreprise==NULL)
			$this->entreprise="";
		if($this->poste==NULL)
			$this->poste="";
		if($this->linkedin==NULL)
			$this->linkedin="";
		if($this->viadeo==NULL)
			$this->viadeo="";
		if($this->twitter==NULL)
			$this->twitter="";
		if($this->facebook==NULL)
			$this->facebook="";
		if($this->googleplus==NULL)
			$this->googleplus="";
		if($this->image==NULL)
			$this->image="";
		if($this->competences==NULL)
			$this->competences="";
		
		if($email){
			$q = array('email'=>$email);
			$sql = "SELECT * FROM users WHERE email= :email";
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$arr = $req->fetchAll();
			$index=0;
			$this->nom =  stripslashes($arr[$index]['nom']);
			$this->prenom =  stripslashes($arr[$index]['prenom']);
			$this->email =  $arr[$index]['email'];
			$this->password = $arr[$index]['password'];
			$this->entreprise = stripslashes($arr[$index]['entreprise']);
			$this->image= $arr[$index]['image'];
			$this->poste =  stripslashes($arr[$index]['poste']);
			$this->competences = preg_split('/;/',$arr[$index]['competences'],NULL,PREG_SPLIT_NO_EMPTY);
		}
	}
	
	public function getSocialNetworks(){
		if(!empty($this->email)){
			$q = array('email'=>$this->email);
			$sql = "SELECT linkedin, viadeo, twitter, facebook, googleplus FROM users WHERE email= :email";
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$arr = $req->fetchAll();
			$index=0;
			$this->linkedin =  stripslashes($arr[$index]['linkedin']);
			$this->viadeo = stripslashes ($arr[$index]['viadeo']);
			$this->twitter = stripslashes( $arr[$index]['twitter']);
			$this->facebook =  stripslashes($arr[$index]['facebook']);
			$this->googleplus =  stripslashes($arr[$index]['googleplus']);
		}
	}
	
	public function getImage(){
		if(!empty($this->email)){
			$q = array('email'=>$this->email);
			$sql = "SELECT image FROM users WHERE email= :email";
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$arr = $req->fetchAll();
			$index=0;
			$this->image =  $arr[$index]['image'];
		}
	}
	
	public function getAllBrainstorm(){
		$result = Array();
		$result['admin']=$this->getAllAdminBrainstorm();
		$result['adminFinished']=$this->getAllAdminFinishedBrainstorl();
		$result['participant']=$this->getAllParticipantBrainstorm();
		$result['participantFinished']=$this->getAllParticipantFinishedBrainstorm();
		
		return $result;
	}
	
	private function getAllAdminBrainstorm(){
		$q = Array("active"=>1,  "admin"=>1, "email"=>$this->email, "phase"=> 5);
		$req = DBConnection::get()->prepare("SELECT * FROM permission t1 INNER JOIN brainstorming t2 ON t1.brainstorm = t2.id WHERE (t2.active = :active AND  t1.admin= :admin AND t1.user = :email AND t2.phase <> :phase ) ORDER BY t2.dateDebut, t2.heureDebut asc");
		$req->execute($q);
		$all = $req->fetchAll(PDO::FETCH_ASSOC);
		return $all;
	}	
	
	private function getAllAdminFinishedBrainstorl(){
		$q = array("active"=>"1", "email"=>$this->email, "admin"=>"1", "phase"=> "5");
		$req = DBConnection::get()->prepare("SELECT * FROM permission t1 INNER JOIN brainstorming t2 ON t1.brainstorm = t2.id WHERE t2.active = :active AND t1.user = :email AND t1.admin= :admin AND t2.phase= :phase ORDER BY t2.dateDebut, t2.heureDebut desc");
		$req->execute($q);
		$all = $req->fetchAll(PDO::FETCH_ASSOC);
		return $all;
	}
	
	private function getAllParticipantBrainstorm(){
		$q = array("active"=>"1", "email"=>$this->email, "admin"=>"0", "phase"=> "3");
		$req = DBConnection::get()->prepare("SELECT * FROM permission t1 INNER JOIN brainstorming t2 ON t1.brainstorm = t2.id WHERE t2.active = :active AND t1.user = :email AND t1.admin= :admin AND t2.phase< :phase ORDER BY t2.dateDebut, t2.heureDebut asc");
		$req->execute($q);
		$all = $req->fetchAll(PDO::FETCH_ASSOC);
		return $all;
	}
	
	private function getAllParticipantFinishedBrainstorm(){
		$q = array("active"=>"1", "email"=>$this->email, "admin"=>"0", "phase"=> "2");
		$req = DBConnection::get()->prepare("SELECT * FROM permission t1 INNER JOIN brainstorming t2 ON t1.brainstorm = t2.id WHERE t2.active = :active AND t1.user = :email AND t1.admin= :admin AND t2.phase > :phase ORDER BY t2.dateDebut, t2.heureDebut desc");
		$req->execute($q);
		$all = $req->fetchAll(PDO::FETCH_ASSOC);
		return $all;
	}
}


?>
