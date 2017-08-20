<?php 
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$cliente = json_decode(file_get_contents("php://input"));
	$sql = "delete from cliente where cnpj = :cnpj";

	$conn = new PDO("mysql:host=localhost;dbname=estudos", "luiz", "200901");
	$stmt = $conn->prepare($sql);
	$stmt->execute(array(
			'cnpj' => $cliente->cnpj
		));
 ?>