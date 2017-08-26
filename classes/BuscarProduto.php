<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });
	header("Access-Allow-Control: *");
	header("Content-Type: application/json, charset=utf-8");

	$search = $_GET['search'];

	echo json_encode(ProdutoDAO::buscar($search));
?>