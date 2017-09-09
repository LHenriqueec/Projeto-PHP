<?php 
require_once "../../entity/ItemRecibo.php";
require_once "../../entity/Produto.php";
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

	public static function carregarItensRecibo($recibo) {
		$sql = "select * from item_recibo i inner join produto p
		on i.produto_codigo = p.codigo where i.recibo_numero=:recibo_numero";

		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			"recibo_numero" => $recibo->getNumero()
			));

		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		$itens = array();
		foreach ($result as $value) {
			$item = new ItemRecibo($value->recibo_numero, new Produto($value->codigo, $value->nome), $value->quantidade, $value->nota_numero);

			array_push($itens, $item);
		}

		$recibo->setItens($itens);
	}
}
?>