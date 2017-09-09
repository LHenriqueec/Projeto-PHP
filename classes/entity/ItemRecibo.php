<?php 

class ItemRecibo implements JsonSerializable {

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

	public function getRecibo() {
		return $this->recibo;
	}

	public function getProduto() {
		return $this->produto;
	}

	public function getQuantidade() {
		return $this->quantidade;
	}

	public function getNota() {
		return $this->nota;
	}

	public function setRecibo($recibo) {
		$this->recibo = $recibo;
	}

	public function setProduto($produto) {
		$this->produto = $produto;
	}

	public function setQuantidade($quantidade) {
		$this->quantidade = $quantidade;
	}

	public function setNota($nota) {
		$this->nota = $nota;
	}

	public function jsonSerialize() {
		return [
		"recibo" => $this->recibo,
		"produto" => $this->produto,
		"quantidade" => $this->quantidade,
		"nota" => $this->nota
		];
	}
}
?>