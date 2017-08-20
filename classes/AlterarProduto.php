<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });
	header("Access-Control-Allow: *");
	header("Content-Type = application/json, charset=UTF-8");
	
	$produto = json_decode(file_get_contents("php://input"));
	ProdutoDAO::alterar($produto);
	

	echo json_encode($produto);
?>