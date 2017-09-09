<?php 
	require_once "../../dao/ProdutoDAO.php";

	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=UTF-8");
	// TODO: Crirar função na camada DAO
	
	$produto = json_decode(file_get_contents("php://input"));
	$conn = new PDO("mysql:host=localhost; dbname=estudos", "luiz", "200901");
	$stmt = $conn->prepare("delete from produto where codigo = :codigo");
	$stmt->execute(array("codigo" => $produto->codigo));

	echo json_encode($produto);
 ?>