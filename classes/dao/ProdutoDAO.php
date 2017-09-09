<?php 
require_once "../../util/ConnectionUtil.php";


class ProdutoDAO {

	public static function buscar($value) {
		$sql = is_numeric($value) ? "select p.codigo, p.nome, sum(i.quantidade) quantidade from item_nota i inner join produto p
		on p.codigo = i.produto_codigo where p.codigo like '%" . $value . "%' group by p.codigo" : "select p.codigo, p.nome, sum(i.quantidade) quantidade from item_nota i inner join produto p on p.codigo = i.produto_codigo where p.nome like '%" . $value . "%' group by p.codigo";

		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public static function alterar($produto) {
		$sql = 'update produto set nome=:nome where codigo=:codigo';
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			'codigo'=> $produto->codigo,
			'nome'=> $produto->nome
			));

	}

	public static function salvar($produto) {
		$sql = 'insert into produto set codigo = :codigo, nome = :nome';
		$conn = ConnectionUtil::connection();

		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			'codigo' => $produto->codigo,
			'nome' => $produto->nome
			));
	}

	public static function carregar() {
		$sql = 'select * from produto';
		$conn = ConnectionUtil::connection();
		if (isset($conn)) {

			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);

			return $result;
		}
	}

	public static function deletar($codigo) {
		$sql = 'delete from produto where codigo=:codigo';
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array('codigo' => $codigo));
	}
}
?>