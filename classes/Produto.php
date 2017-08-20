<?php 

	class Produto {
		private $codigo;
		private $nome;

		function __construct() {}

		public function getCodigo() {
			return $this->codigo;
		}

		public function getNome() {
			return $this->nome;
		}

		public function setCodigo($codigo) {
			$this->codigo = $codigo;
		}

		public function setNome($nome) {
			$this->nome = $nome;
		}
	}

 ?>