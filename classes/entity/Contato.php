<?php 
	class Contato implements JsonSerializable {

		private $telefone;
		private $celular;
		private $email;
		private $responsavel;

		public function __construct($telefone, $celular, $email, $responsavel) {
			$this->telefone = $telefone;
			$this->celular = $celular;
			$this->email = $email;
			$this->responsavel = $responsavel;

		}

		public function getTelefone() {
			return $telefone;
		}

		public function getCelular() {
			return $celular;
		}

		public function getEmail() {
			return $email;
		}

		public function getResponsavel() {
			return $responsavel;
		}

		public function setTelefone($telefone) {
			$this->telefone = $telefone;
		}

		public function setCelular($celular) {
			$this->celular = $celular;
		}

		public function setEmail($email) {
			$this->email = $email;
		}

		public function setResponsavel($responsavel) {
			$this->responsavel = $responsavel;
		}

		public function jsonSerialize() {
			return [
			"telefone" => $this->telefone,
			"celular" => $this->celular,
			"email" => $this->email,
			"responsavel" => $this->responsavel
			];
		}

	}
 ?>