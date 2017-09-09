<?php
	require_once "../dao/NotaDAO.php";
	
	header("Access-Control-Allow: *");
	header("Content-Type: application/json, charset=utf-8");

	$values = NotaDAO::carregar();

	$notasDB = array();
	foreach ($values as $value) {
		array_push($notasDB, array(
			"numero" => $value->numero,
			"data" => $value->emissao,
			"cliente" => array(
				"cnpj" => $value->cnpj,
				"nome" => $value->nome,
			)
		));
	}

	echo json_encode(($notasDB));
 ?>