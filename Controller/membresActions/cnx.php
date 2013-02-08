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