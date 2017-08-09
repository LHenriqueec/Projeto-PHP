<?php 
	header("Access-Control-Allow: *");
	header("Content-Type = application/json, charset=UTF-8");
	
	$produto = json_decode(file_get_contents("php://input"));
	$conn = new PDO("mysql:host=localhost; dbname=estudos", "luiz", "200901");
	$stmt = $conn->prepare("update produto set nome = :nome where codigo = :codigo");
	$stmt->execute(array(
			'codigo' => $produto->codigo,
			'nome' => $produto->nome
		));	
	

	echo json_encode($produto);
?>