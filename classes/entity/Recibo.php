<?php 
spl_autoload_register(function($class_name) { require_once $class_name . '.php'; });

class Recibo implements JsonSerializable {
	private $numero;
	private $data;
	private $cliente;
	private $itens;

	public function __construct($numero, $data, $cliente, $itens) {
		$this->numero = $numero;
		$this->data = $data;
		$this->cliente = $cliente;
		$this->itens = $itens;
	}

	public function getNumero() {
		return $this->numero;
	}

	public function getData() {
		return $this->data;
	}

	public function getCliente() {
		return $this->cliente;
	}

	public function getItens() {
		return $this->itens;
	}

	public function setNumero($numero) {
		$this->numero = $numero;
	}

	public function setData($data) {
		$this->data = $data;
	}

	public function setCliente($cliente) {
		$this->cliente = $cliente;
	}

	public function setItens($itens) {
		$this->itens = $itens;
	}

	public function toString() {
		return $this->numero;
	}

	public function jsonSerialize() {
		return [
		"numero" => $this->numero,
		"data" => $this->data,
		"cliente" => $this->cliente,
		"itens" => $this->itens

		];
	}
}
?>