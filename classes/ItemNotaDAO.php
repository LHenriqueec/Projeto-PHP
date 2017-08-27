<?php 
	spl_autoload_register(function($class_name) { include $class_name . '.php'; });
	

	class ItemNotaDAO {

		public static function carretarTotalItem() {
			$sql = "select p.codigo, p.nome, sum(i.quantidade) quantidade from produto p inner join item_nota i
				on p.codigo = i.produto_codigo group by p.codigo";
					
			$conn = ConnectionUtil::connection();
			$stmt = $conn->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}

		public static function salvarItens($itens, $nota) {
			$sql = "insert into item_nota set produto_codigo=:produto, quantidade=:quantidade, nota_numero=:nota";
			$conn = ConnectionUtil::connection();
			$stmt = $conn->prepare($sql);

			foreach ($itens as $item) {
				$stmt->execute(array(
						'produto' => $item->produto->codigo,
						'quantidade' => $item->quantidade,
						'nota' => $nota->numero
					));
			}
		}

		public static function deletar($nota) {
			$sql = "delete from item_nota where nota_numero = :nota";
			$conn = ConnectionUtil::connection();
			$stmt = $conn->prepare($sql);
			$stmt->execute(array (
				'nota' => $nota
			));
		}
	}
 ?>