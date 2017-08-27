<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });

	echo json_encode((ItemNotaDAO::carretarTotalItem()));
	
?>