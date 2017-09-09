<?php 

class Endereco implements JsonSerializable {

	private $uf;
	private $cidade;
	private $bairro;
	private $logradouro;

	public function __construct($uf, $cidade, $bairro, $logradouro) {
		$this->uf = $uf;
		$this->cidade = $cidade;
		$this->bairro = $bairro;
		$this->logradouro = $logradouro;

	}

	public function getUf() {
		return $uf;
	}
	
	public function getCidade() {
		return $cidade;
	}
	
	public function getBairro() {
		return $bairro;
	}
	
	public function getLogradouro() {
		return $logradouro;
	}

	public function setUf($uf) {
		$this->uf = $uf;
	}

	public function setCidade($cidade) {
		$this->cidade = $cidade;
	}

	public function setBairro($bairro) {
		$this->bairro = $bairro;
	}

	public function setLogradouro($logradouro) {
		$this->logradouro = $logradouro;
	}

	public function jsonSerialize() {
		return [
		"uf" => $this->uf,
		"cidade" => $this->cidade,
		"bairro" => $this->bairro,
		"logradouro" => $this->logradouro
		];
	}

}
?>