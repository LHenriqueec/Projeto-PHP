<?php 
	require_once "../../dao/ClienteDAO.php";
	
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$cnpj = json_decode(file_get_contents("php://input"));
	ClienteDAO::deletar($cnpj);
 ?>