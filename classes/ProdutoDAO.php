<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php';	});
	

	class ProdutoDAO {

		public static function salvar($produto) {
			$sql = 'insert into produto set codigo = :codigo, nome = :nome';
			$conn = ConnectionUtil::connection();

			$stmt = $conn->prepare($sql);
			$stmt->execute(array(
					'codigo' => $produto->getCodigo(),
					'nome' => $produto->getNome()
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
	}
 ?>