<?php 
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf8");
	
	$sql = "select * from cliente";
	$conn = new PDO("mysql:host=localhost;dbname=estudos", "luiz", "200901");
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);

	echo '{ "clientes":' . json_encode($result) . '}';

 ?>