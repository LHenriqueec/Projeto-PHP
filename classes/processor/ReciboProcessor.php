<?php 
require_once "../../dao/ItemNotaDAO.php";
class ReciboProcessor {

	public static function processarRecibo($recibo) {
		$itensRecibo = array();
		$recibo->data =  date_create($recibo->data)->format("Y-m-d");
		foreach ($recibo->itens as $itemRecibo) {
			$itensNota = ItemNotaDAO::buscarItem($itemRecibo);
			$quantidade = $itemRecibo->quantidade;

			$index = 0;

			while($quantidade > 0) {
				if($quantidade > $itensNota[$index]->quantidade) {
					$item = new ItemRecibo($recibo->numero, $itemRecibo->produto, $itensNota[$index]->quantidade, $itensNota[$index]->nota_numero);
					$quantidade -= $itensNota[$index]->quantidade;
					$itensNota[$index]->quantidade = 0;
				} else {
					$item = new ItemRecibo($recibo->numero, $itemRecibo->produto, $quantidade, $itensNota[$index]->nota_numero);
					$itensNota[$index]->quantidade -= $quantidade;
					$quantidade = 0;
				}
				array_push($itensRecibo, $item);
				$index++;
			}
		}

		$recibo->itens = $itensRecibo;
	}
}
?>