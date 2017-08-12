<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json, charset=UTF-8');

	$conn = new PDO("mysql:host=localhost;dbname=estudos", "luiz", "200901");
	$stmt = $conn->prepare("select * from produto");
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);

	echo '{ "produtos":' . json_encode($result) . '}';
 ?>