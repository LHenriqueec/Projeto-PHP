<?php 

class Cliente implements JsonSerializable {

	private $cnpj;
	private $nome;
	private $endereco;
	private $contato;

	public function __construct($cnpj, $nome, $endereco, $contato) {
		$this->cnpj = $cnpj;
		$this->nome = $nome;
		$this->endereco = $endereco;
		$this->contato = $contato;

	}

	public function getCnpj() {
		return $cnpj;
	}
	
	public function getNome() {
		return $nome;
	}
	
	public function getEndereco() {
		return $endereco;
	}
	
	public function getContato() {
		return $contato;
	}

	public function setCnpj($cnpj) {
		$this->cnpj = $cnpj;
	}

	public function setNome($nome) {
		$this->nome = $nome;
	}

	public function setEndereco($endereco) {
		$this->endereco = $endereco;
	}

	public function setContato($contato) {
		$this->contato = $contato;
	}

	public function jsonSerialize() {
		return [
		"cnpj" => $this->cnpj,
		"nome" => $this->nome,
		"endereco" => $this->endereco,
		"contato" => $this->contato
		];
	}
}

?>