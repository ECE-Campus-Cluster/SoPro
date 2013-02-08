<?php
require_once '../../Controller/membresActions/cnx.php';
require_once 'user.php';

class Users{
	
	public static function getAll(){
			$db = DBConnection::get();
			$res = $db->query("SELECT email, nom, prenom, entreprise, poste, competences FROM users ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
			return $res;
			
	}
	
	function getCompetencesByUsers($competencerecherche){
		
		$mailuser=array();
		$db = DBConnection::get();
		$res2 = $db->query("SELECT email FROM users")->fetchAll(PDO::FETCH_ASSOC);
		foreach($res2 as $listmail)
			{
				foreach($listmail as $mail)
				{
					$user = new User($mail);
					foreach($user->competences as $cp)
					{
						if ($cp==$competencerecherche){
						array_push($mailuser,$mail);
						

						}
					
					
						
					}
												
				}
			}
			return $mailuser;
	}
	
	public static function getAllBySearch($regExp){
		$regExp=ucwords($regExp);
		$db = DBConnection::get();
		$all = $db->query("SELECT email, nom, prenom, competences FROM users ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
		$count = 0;
		foreach($all as $tempUser){
			$user = new User();
			$user->nom=$tempUser['nom'];
			$user->prenom=$tempUser['prenom'];
			$user->email=$tempUser['email'];
			if(preg_match('/^'.$regExp.'/',$user->nom)||preg_match('/^'.$regExp.'/',$user->prenom))
			{
				$result[$count]=$user;
				$count++;
			}
			else{
				$user->competences = preg_split('/;/',$tempUser['competences'],NULL,PREG_SPLIT_NO_EMPTY);
				$cont = 1;
				foreach($user->competences as $competence){
					if($cont){
						if(preg_match('/^'.$regExp.'/',$competence)){
							$result[$count]=$user;
							$count++;
							$cont=0;
						}
					}
				}
			}
		}
		return $result;
	}
}

?>