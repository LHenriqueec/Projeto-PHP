<?php 
	require_once "../../dao/ProdutoDAO.php";

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json, charset=UTF-8');

	$result = ProdutoDAO::carregar();

	echo json_encode($result);
 ?>