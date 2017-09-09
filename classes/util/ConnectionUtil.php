<?php 

	spl_autoload_register(function($class_name) { include $class_name . '.php'; });
	
	class ConnectionUtil {

		public static function connection() {
			return new PDO("mysql:host=localhost;dbname=estudos", "luiz", "200901");
		}
	}
 ?>