<?php 
	require_once "../../dao/ReciboDAO.php";

	$recibos = ReciboDAO::carregarRecibos();
	sort($recibos);

	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	echo json_encode($recibos);
	
 ?>