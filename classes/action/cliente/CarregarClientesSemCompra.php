<?php 
	require_once "../../dao/ClienteDAO.php";
	
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");
	
	echo json_encode(ClienteDAO::carregarClientesSemCompra());
?>