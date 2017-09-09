<?php 
require_once "../../util/ConnectionUtil.php";
require_once "../../dao/ItemReciboDAO.php";

class ReciboDAO {

	public static function salvar($recibo) {
		$sql = "insert into recibo set numero=:numero, emissao=:emissao, cnpj_cliente=:cnpj_cliente";
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			"numero" => $recibo->numero,
			"emissao" => $recibo->data,
			"cnpj_cliente" => $recibo->cliente->cnpj
			));

		ItemReciboDAO::salvarItens($recibo->itens);
	}
}
?>