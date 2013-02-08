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

class Auth{
	
	static function islogged(){
	
		if(isset($_SESSION['Auth']) && isset($_SESSION['Auth']['email'])&& isset($_SESSION['Auth']['password'])){
			$q = array('email'=>$_SESSION['Auth']['email'],'password'=>$_SESSION['Auth']['password']);
			$sql = 'SELECT email, password FROM users WHERE email = :email AND password = :password';
			$req = DBConnection::get()->prepare($sql);
			$req->execute($q);
			$count = $req->rowCount($sql);
			if($count==1){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
}

?>