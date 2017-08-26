<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; } );

	class NotaDAO {

		public static function salvar($nota) {
			$sql = "insert into nota set numero=:numero, cnpj_cliente=:cnpj_cliente, emissao=:emissao";
			$conn = ConnectionUtil::connection();

			$stmt = $conn->prepare($sql);
			$stmt->execute(array (
					'numero' => $nota->numero,
					'cnpj_cliente' => $nota->cliente->cnpj,
					'emissao' => $nota->data
				));

			ItemNotaDAO::salvarItens($nota->itens, $nota);
		}

		public static function carregar() {
			$sql = "select n.numero, n.emissao, c.cnpj, c.nome from nota n inner join cliente c on c.cnpj = n.cnpj_cliente";
			$conn = ConnectionUtil::connection();

			if(isset($conn)) {
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
		}

		public static function deletar($nota) {
			ItemNotaDAO::deletar($nota);
		
			$sql = "delete from nota where numero = :numero";
			$conn = ConnectionUtil::connection();
			$stmt = $conn->prepare($sql);
			$stmt->execute(array (
				'numero' => $nota
			));
		}
	}

 ?>