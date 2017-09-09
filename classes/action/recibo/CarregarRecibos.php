<?php 
	require_once "../../dao/ReciboDAO.php";

	$recibos = ReciboDAO::carregarRecibos();

	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	echo json_encode($recibos);
	
 ?>