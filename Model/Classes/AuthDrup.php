<?php
require_once './Controller/membresActions/cnx.php';
class AuthDrup
{
	static function islogged($uid)
	{
			
				$q = array('drupalID'=>$uid);
				$sql = 'SELECT * FROM users WHERE drupalID = :drupalID';
				$req = DBConnection::get()->prepare($sql);
				$req->execute($q);
				$count = $req->rowCount($sql);
				if($count!=1) return false;
				else
				{
				echo "coucou";
					foreach($req as $data)
					{
						if($data["email"]!="")$_SESSION['Auth']["email"] = $data["email"];
						if($data["password"]!="")$_SESSION['Auth']["password"]= $data["password"];
						if($data["nom"]!="")$_SESSION['Auth']["nom"]= $data["nom"];
						if($data["prenom"]!="")$_SESSION['Auth']["prenom"]= $data["prenom"];
						return true;
					}
				}
				
			
				
	}

}
?>