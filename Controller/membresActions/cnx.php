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
define('DSN', 'mysql:host=localhost;dbname=sopro;port=3306'); 
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root'); // NO! 

class DBConnection {

	static private $db;

	static function get() {
	
		if(!self::$db) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$db = new PDO(DSN,DB_USERNAME, DB_PASSWORD, $pdo_options);
		}
	
		return self::$db;
	}
}
?>