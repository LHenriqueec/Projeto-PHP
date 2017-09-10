<?php 
require_once "../../entity/Contato.php";
require_once "../../entity/Endereco.php";
require_once "../../entity/Cliente.php";
require_once "../../util/ConnectionUtil.php";

class ClienteDAO {

	public static function carregar() {
		$sql = 'select * from cliente';
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);

		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);

		return self::createList($result);
		
	}

	public static function carregarClientesSemCompra() {
		$sql = "select c.* from cliente c inner join recibo r
		on c.cnpj = r.cnpj_cliente where week(r.emissao) < week(now()) group by c.cnpj
		union
		select c.* from cliente c
		where not exists (select r.numero from recibo r where r.cnpj_cliente = c.cnpj)";

		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);

		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);

		return self::createList($result);
	}

	public static function salvar($cliente) {
		$sql = "insert into cliente set cnpj=:cnpj, nome=:nome, uf=:uf, cidade=:cidade, bairro=:bairro, logradouro=:logradouro, telefone=:telefone, celular=:celular, email=:email";

		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			'cnpj' => $cliente->cnpj,
			'nome' => strtolower($cliente->nome),
			'uf' => strtolower($cliente->uf),
			'cidade' => strtolower($cliente->cidade),
			'bairro' => strtolower($cliente->bairro),
			'logradouro' => strtolower($cliente->logradouro),
			'telefone' => $cliente->telefone,
			'celular' => $cliente->celular,
			'email' => $cliente->email
			));
	}

	public static function alterar($cliente) {
		$sql = "update cliente set nome = :nome, uf = :uf, cidade = :cidade, bairro = :bairro, logradouro = :logradouro, telefone = :telefone, celular = :celular, email = :email where cnpj = :cnpj";
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			'cnpj' => $cliente->cnpj,
			'nome' => strtolower($cliente->nome),
			'uf' => strtolower($cliente->uf),
			'cidade' => strtolower($cliente->cidade),
			'bairro' => strtolower($cliente->bairro),
			'logradouro' => strtolower($cliente->logradouro),
			'telefone' => $cliente->telefone,
			'celular' => $cliente->celular,
			'email' => $cliente->email
			));
	}

	public static function deletar($cnpj) {
		$sql = "delete from cliente where cnpj = :cnpj";
		$conn = ConnectionUtil::connection();
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(
			'cnpj' => $cnpj
			));
	}

	private static function createList($result) {
		$clientes = array();
		foreach ($result as $value) {
			$endereco = new Endereco($value->uf, $value->cidade, $value->bairro, $value->logradouro);
			$contato = new Contato($value->telefone, $value->celular, $value->email, $value->responsavel);
			$cliente = new Cliente($value->cnpj, $value->nome, $endereco, $contato);
			array_push($clientes, $cliente);
		}

		return $clientes;
	}
}
?>