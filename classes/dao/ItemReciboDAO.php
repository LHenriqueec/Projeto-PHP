<?php 
require_once "../../util/ConnectionUtil.php";

class ItemReciboDAO {

	public static function salvarItens($itens) {
		$sql = "insert into item_recibo (recibo_numero, produto_codigo, quantidade, nota_numero) values ";

		for ($index = 0; $index < sizeof($itens); $index++) {
			if($index > 0) $sql .= ", ";
			$sql .= "(" . $itens[$index]->getRecibo() . ", " . $itens[$index]->getProduto()->codigo . ", ". $itens[$index]->getQuantidade() . ", " . $itens[$index]->getNota() . ")";
		}

		$conn = ConnectionUtil::connection();
		$conn->exec($sql);
	}
}
?>