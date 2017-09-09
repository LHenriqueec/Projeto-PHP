<?php 
	require_once "../dao/NotaDAO.php";

	$nota = $_GET['nota'];

	NotaDAO::deletar($nota);
 ?>