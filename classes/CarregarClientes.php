<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; } );

	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf8");
	
	
	$result = ProdutoDAO::carregar();
	echo json_encode($result);

 ?>