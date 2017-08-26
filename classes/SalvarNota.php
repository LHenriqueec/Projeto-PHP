<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$nota = json_decode(file_get_contents("php://input"));

	$nota->data = date_create($nota->data);
	$nota->data = date_format($nota->data, "d/m/Y");
	ItemNotaDAO::salvarItens($nota->itens);
	NotaDAO::salvar($nota);

?>