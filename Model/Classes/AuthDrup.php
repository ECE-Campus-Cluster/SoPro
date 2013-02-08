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