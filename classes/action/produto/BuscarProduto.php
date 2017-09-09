<?php 
	require_once "../../dao/ProdutoDAO.php";
	
	header("Access-Allow-Control: *");
	header("Content-Type: application/json, charset=utf-8");

	$search = $_GET['search'];

	echo json_encode(ProdutoDAO::buscar($search));
?>