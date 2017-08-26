<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php';	});
	

	class ProdutoDAO {

		public static function buscar($value) {
			$sql = "select * from produto where nome like '%" . $value . "%'";
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