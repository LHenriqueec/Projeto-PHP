<?php 
	require_once "../dao/NotaDAO.php";
	require_once "../dao/ItemNotaDAO.php";
	
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$nota = json_decode(file_get_contents("php://input"));

	$nota->data = date_create($nota->data);
	$nota->data = date_format($nota->data, "Y-m-d");
	ItemNotaDAO::salvarItens($nota->itens);
	NotaDAO::salvar($nota);

?>