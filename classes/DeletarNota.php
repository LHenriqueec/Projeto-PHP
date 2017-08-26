<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });

	$nota = $_GET['nota'];

	NotaDAO::deletar($nota);
 ?>