<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$cliente = json_decode(file_get_contents("php://input"));
	
	ClienteDAO::salvar($cliente);
	echo json_encode($cliente);
	
 ?>