<?php 

class ItemRecibo {

	private $recibo;
	private $produto;
	private $quantidade;
	private $nota;

	public function __construct($recibo, $produto, $quantidade, $nota) {
		$this->recibo = $recibo;
		$this->produto = $produto;
		$this->quantidade = $quantidade;
		$this->nota = $nota;
	}

	function getRecibo() {
		return $this->recibo;
	}

	function getProduto() {
		return $this->produto;
	}

	function getQuantidade() {
		return $this->quantidade;
	}

	function getNota() {
		return $this->nota;
	}

	function setRecibo($recibo) {
		$this->recibo = $recibo;
	}

	function setProduto($produto) {
		$this->produto = $produto;
	}

	function setQuantidade($quantidade) {
		$this->quantidade = $quantidade;
	}

	function setNota($nota) {
		$this->nota = $nota;
	}


}
?>