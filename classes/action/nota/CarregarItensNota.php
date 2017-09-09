<?php 
	require_once "../../dao/ItemNotaDAO.php";

	echo json_encode((ItemNotaDAO::carretarTotalItem()));
	
?>