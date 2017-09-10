<?php 
	require_once "../../dao/ReciboDAO.php";

	$recibo = $_GET['recibo'];
	ReciboDAO::deletar($recibo);
 ?>