<?php 
	require_once "../../dao/ClienteDAO.php";

	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf8");
	
	
	$result = ClienteDAO::carregar();
	echo json_encode($result);

 ?>