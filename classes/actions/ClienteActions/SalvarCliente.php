<?php 
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$cliente = json_decode(file_get_contents("php://input"));
	$sql = "insert into cliente (cnpj, nome, uf, cidade, bairro, logradouro, telefone, celular, email) values(:cnpj, :nome, :uf, :cidade, :bairro, :logradouro, :telefone, :celular, :email)";
	
	$conn = new PDO("mysql:host=localhost;dbname=estudos", "luiz", "200901");
	
	$stmt = $conn->prepare($sql);
	$stmt->execute(array(
		'cnpj' => $cliente->cnpj,
		'nome' => strtolower($cliente->nome),
		'uf' => strtolower($cliente->uf),
		'cidade' => strtolower($cliente->cidade),
		'bairro' => strtolower($cliente->bairro),
		'logradouro' => strtolower($cliente->logradouro),
		'telefone' => $cliente->telefone,
		'celular' => $cliente->celular,
		'email' => $cliente->email
	));

	echo json_encode($cliente);
	
 ?>