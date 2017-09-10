<?php 
require_once "../../entity/Contato.php";
require_once "../../entity/Endereco.php";
require_once "../../entity/Cliente.php";
require_once "../../entity/Recibo.php";
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

	public static function deletar($recibo) {
		$sql = "delete from recibo where numero = :numero";
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			"numero" => $recibo
			));
	}

	public static function carregarRecibos() {
		$sql = "select * from recibo r inner join cliente c
		on r.cnpj_cliente = c.cnpj";

		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);

		$recibos = array();
		foreach ($result as $value) {
			$endereco = new Endereco($value->uf, $value->cidade, $value->bairro, $value->logradouro);
			$contato = new Contato($value->telefone, $value->celular, $value->email, $value->responsavel);
			$cliente = new Cliente($value->cnpj, $value->nome, $endereco, $contato);
			$recibo = new Recibo($value->numero, $value->emissao, $cliente, null);

			ItemReciboDAO::carregarItensRecibo($recibo);
			array_push($recibos, $recibo);
		}

		return $recibos;
	}
}
?>