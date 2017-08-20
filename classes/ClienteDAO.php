<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });

	class ClienteDAO {

		public static function carregar() {
			$sql = 'select * from cliente';
			$conn = ConnectionUtil::connection();
			$stmt = $conn->prepare($sql);

			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
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
	}
 ?>