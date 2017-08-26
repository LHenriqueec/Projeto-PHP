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
	}

 ?>