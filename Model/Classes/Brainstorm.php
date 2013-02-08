<?php
require_once '../../Controller/membresActions/cnx.php';
require_once 'user.php';

class Brainstorm{
	public $id;
	public $nom;
	public $description;
	public $createur;
	public $dateDebut;
	public $heureDebut;
	public $dureePhase1;
	public $dureePhase2;
	public $phase;
	public $active;
	public $competences;
	public $source;
	public $compterendu;
	
	public function __construct($idB = NULL){
		if($idB == NULL){
			$this->id="";
		}
		else{
			$this->id=$idB;
			$q = array('id'=>$this->id);
			$req = DBConnection::get()->prepare("SELECT * FROM brainstorming WHERE id = :id"); 
			$req->execute($q);
			$arr = $req->fetchAll();
			$index=0;
			$this->nom =  $arr[$index]['nom'];
			$this->description =  stripslashes($arr[$index]['description']);
			$this->createur =  $arr[$index]['createur'];
			$this->dateDebut = $arr[$index]['dateDebut'];
			$this->heureDebut = $arr[$index]['heureDebut'];
			$this->dureePhase1 =  $arr[$index]['dureePhase1'];
			$this->dureePhase2 =  $arr[$index]['dureePhase2'];
			$this->phase =  $arr[$index]['phase'];
			$this->active =  $arr[$index]['active'];
			$this->source = $arr[$index]['source'];
			$this->compterendu = stripslashes($arr[$index]['compterendu']);
			$this->competences = preg_split('/;/',$arr[$index]['competences'],NULL,PREG_SPLIT_NO_EMPTY);
			if($this->active==1)
				$this->updatePhase();
		}
	}
	
	public function getParticipants(){
		$q=Array("brainstorm"=>($this->id), "admin"=>'0');
		$sql = 'SELECT user FROM permission WHERE brainstorm = :brainstorm AND admin = :admin';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$arr = $req->fetchAll();
		$result = Array();
		$i=0;
		foreach($arr as $arr1)
		{
			$email = $arr1['user'];
			$temp = new User($email);
			$result[$i] = $temp;
			$i = $i+1;
		}
		return $result;
	}
	
	public function isAdminBstrm($email){
		if(!empty($email)&&!empty($this->id)){
			$q=Array("user"=>$email, "brainstorm"=>($this->id), "admin"=>'1');
			$sql = 'SELECT * FROM permission WHERE user = :user AND brainstorm = :brainstorm AND admin = :admin';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$count=$req->rowCount($sql);
			if($count==1)
				return true;
			else
				return false;
		}else{
			return false;
		}
	}
	
	public function hasRights($email){
		if(!empty($email)&&!empty($this->id))
		{
			$q=Array("user"=>$email, "brainstorm"=>($this->id));
			$sql = 'SELECT * FROM permission WHERE user = :user AND brainstorm = :brainstorm';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$count=$req->rowCount($sql);
			if($count==1){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function hasVoted($email){
		if(!empty($email)&&!empty($this->id))
		{
			$q=Array("user"=>$email, "brainstorm"=>($this->id), "vote"=>"1");
			$sql = 'SELECT * FROM permission WHERE user = :user AND brainstorm = :brainstorm AND vote = :vote';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$count=$req->rowCount($sql);
			if($count==1){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function isActive(){
		$q = Array("id"=>($this->id), "active"=>'1');
		$sql = 'SELECT * FROM brainstorming WHERE id = :id AND active= :active';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$count=$req->rowCount($sql);
		if($count==1){
			return true;
		}else{
			return false;
		}
	}
	
	function passage($nextP){
	   	switch($nextP){
		   	case 1:	//Passage à la première phase : Création du fichier ../../View/assets/json/brainstormID.json avec un point source
		   			$str= "../../View/assets/json/".$this->id.".json";
		   			$fjson = fopen($str, "w+");
		   			fwrite($fjson, '{"nodes":[{"x":1475,"y":775,"id":0,"name":"'.$this->source.'","parent":null,"degree":0,"hasChild":0,"comment":null,"group":0}]'.',"links":[],"lastGroup":0}');
		   			fclose($fjson);
		   			break;
		   	case 2: //Passage de la phase 1 à 2 : Creation en base de données des lignes correspondant aux idées du brainstorm et permettant le vote des participants lors de la phase 2
		   			//Ouverture du json et recuperation du contenu
		   			$str= "../../View/assets/json/".$this->id.".json";
		   			$fjson = fopen($str, "r+");
		   			$json = fgets($fjson, 100000);
		   			fclose($fjson);
		   			//Creation des objets correspondant au json
		   			$tableau = json_decode($json, true);
		   			//Pour toute les idées récupération de leur id et création de leur ligne dans la table de vote
		   			$req = DBConnection::get()->prepare("INSERT INTO vote (brainstorm , idea) VALUES (:brainstorm, :idea)");
		   			foreach($tableau["nodes"] as $idea){
			   			$q = Array("brainstorm"=>$this->id, "idea"=>$idea["id"]);
			   			$req->execute($q);
		   			}
		   			break;
		   	case 3: //Passage de la phase 2 à 3 : Récupération du nombre de vote en base de données, reconstruction du json avec le nombre de vote pour chaque idée et destruction des lignes correspondant aux idées du brainstorm en base de donnée
		   			//Récupération en lecture des données dans le json
		   			$str= "../../View/assets/json/".$this->id.".json";
		   			$fjson = fopen($str, "r+");
		   			$json = fgets($fjson, 100000);
		   			fclose($fjson);
		   			//Création des objets correspondant au data du json
		   			$data = json_decode($json, true);
		   			//Preparation de la requete sql
		   			$req = DBConnection::get()->prepare("SELECT * FROM vote WHERE brainstorm = :brainstorm AND idea = :idea");
		   			for($i=0; $i<count($data["nodes"]); $i++){
			   			$q = Array("brainstorm"=>$this->id, "idea"=>$data["nodes"][$i]["id"]);
			   			$req->execute($q);
			   			$ans = $req->fetchAll();
			   			$index=0;
			   			$data["nodes"][$i]["vote"] = $ans[$index]["nombre"];
		   			}
		   			//Encodage des objets en json
		   			$strData=json_encode($data);
		   			//Ouverture du fichier en lecture et écriture des données dedans
		   			$str= "../../View/assets/json/".$this->id.".json";
		   			$fj = fopen($str, "w+");
		   			fwrite($fj, $strData);
		   			fclose($fj);
		   			//Destruction des lignes de la table vote correspondant à ce brainstorm
		   			$req = DBConnection::get()->prepare("DELETE FROM vote WHERE brainstorm = :brainstorm");
			   		$q = Array("brainstorm"=>$this->id);
			   		$req->execute($q);
		   			break;
			   	}
		   	}
	
	public function updatePhase(){
		$update=0;
		if($this->phase==0){
			/*Verifier si la date de debut est passée ou pas*/
			if(time()>=strtotime($this->dateDebut.' '.$this->heureDebut)){
				$this->phase=1;
				$this->passage(1);	
				$update=1;
			}
		}elseif($this->phase==1){
			$datePhase1 = new DateTime($this->dateDebut.' '.$this->heureDebut);
			$duree = preg_split('/:/',$this->dureePhase1,NULL,PREG_SPLIT_NO_EMPTY);
			$datePhase1->add(date_interval_create_from_date_string(" ".$duree[0]." hours "));
			$datePhase1->add(date_interval_create_from_date_string($duree[1]." min "));
			$datePhase1->add(date_interval_create_from_date_string($duree[2]." seconds "));
			if(time()>=$datePhase1->getTimestamp()){
				$this->phase=2;
				$this->passage(2);
				$update=1;
			}
		}elseif($this->phase==2){
			$datePhase2 = new DateTime("".$this->dateDebut.' '.$this->heureDebut."");
			$duree = preg_split('/:/',$this->dureePhase1,NULL,PREG_SPLIT_NO_EMPTY);
			$datePhase2->add(date_interval_create_from_date_string($duree[0]." hours "));
			$datePhase2->add(date_interval_create_from_date_string($duree[1]." min "));
			$datePhase2->add(date_interval_create_from_date_string($duree[2]." seconds "));
			$duree = preg_split('/:/',$this->dureePhase2,NULL,PREG_SPLIT_NO_EMPTY);
			$datePhase2->add(date_interval_create_from_date_string($duree[0]." hours "));
			$datePhase2->add(date_interval_create_from_date_string($duree[1]." min "));
			$datePhase2->add(date_interval_create_from_date_string($duree[2]." seconds "));
			if(time()>=$datePhase2->getTimestamp()){
				$this->phase=3;
				$this->passage(3);
				$update=1;
			}
		}
		if($update==1){
			$q = Array("phase"=>$this->phase, "id"=>$this->id);
			$sql = 'UPDATE brainstorming SET phase= :phase WHERE id= :id';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
		}
	}
	
	
	public function nextPhase(){
		if($this->phase==0){
			$currentTime = new DateTime("now");
			$this->dateDebut = $currentTime->format('Y-m-d');
			$this->heureDebut = $currentTime->format('H:i:s');
			$this->phase=1;
			$q = Array("phase"=>$this->phase, "dateDebut"=>$this->dateDebut, "heureDebut"=>$this->heureDebut, "id"=>$this->id);
			$sql = 'UPDATE brainstorming SET phase= :phase , dateDebut = :dateDebut, heureDebut= :heureDebut  WHERE id= :id';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$this->passage(1);
		}elseif($this->phase==3){
			$this->phase=4;
			$q = Array("phase"=>$this->phase, "id"=>$this->id);
			$sql = 'UPDATE brainstorming SET phase= :phase WHERE id= :id';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
		}elseif($this->phase==4){
			$this->phase=5;
			$q = Array("phase"=>$this->phase, "id"=>$this->id);
			$sql = 'UPDATE brainstorming SET phase= :phase WHERE id= :id';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
		}elseif($this->phase==1){
			$currentTime = new DateTime("now");
			$beginningDate = new DateTime($this->dateDebut.' '.$this->heureDebut);
	    	$remaining = date_diff($currentTime,$beginningDate);
	    	$this->dureePhase1 = $remaining->format('%H:%I:%S');
	    	$this->phase = 2;
	    	$this->passage(2);
	    	$q = Array("phase"=>$this->phase, "dureePhase1"=>$this->dureePhase1, "id"=>$this->id);
			$sql = 'UPDATE brainstorming SET phase= :phase, dureePhase1 = :dureePhase1  WHERE id= :id';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
	    }elseif($this->phase==2){
	    	$currentTime = new DateTime("now");
			$beginningDate = new DateTime($this->dateDebut.' '.$this->heureDebut);
			$duree = preg_split('/:/',$this->dureePhase1,NULL,PREG_SPLIT_NO_EMPTY);
			$beginningDate->add(date_interval_create_from_date_string($duree[0]." hours "));
			$beginningDate->add(date_interval_create_from_date_string($duree[1]." min "));
			$beginningDate->add(date_interval_create_from_date_string($duree[2]." seconds "));
	    	$remaining = date_diff($currentTime,$beginningDate);
    		$this->dureePhase2 = $remaining->format('%H:%I:%S');
	    	$this->phase = 3;    
	    	$q = Array("phase"=>$this->phase, "dureePhase2"=>$this->dureePhase2, "id"=>$this->id);
			$sql = 'UPDATE brainstorming SET phase= :phase, dureePhase2 = :dureePhase2  WHERE id= :id';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$this->passage(3);
    	}
   	}
   	
   	function getNbParticipant(){
   		$q=Array("brainstorm"=>$this->id);
	   	$sql = 'SELECT * FROM permission WHERE brainstorm= :brainstorm';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$count=$req->rowCount($sql);
		return $count;
   	}
   	
   	function getNbVote(){
	   	$q=Array("brainstorm"=>$this->id, "vote"=>1);
	   	$sql = 'SELECT * FROM permission WHERE brainstorm =:brainstorm AND vote = :vote';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$count=$req->rowCount($sql);
		return $count;
   	}
}
?>