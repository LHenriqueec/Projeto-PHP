angular.module('clienteApp', []).controller('clienteController', function($scope, $http) {
	
	$scope.cliente = {};
	$scope.clientes = [];

	$scope.valuesUF = ["Emil", "Tobias", "Linus"];

	var isEdit = false;

	$scope.salvar = function() {
		if(isEdit) {
			
		} else {
			$scope.clientes.push($scope.cliente);
		}
		
		$scope.cliente = {};
		isEdit = false;
	};

	$scope.alterar = function(cliente) {
		$scope.cliente = cliente;
		isEdit = true;
	};

	$scope.remover = function(cliente) {
		$scope.clientes.splice($scope.clientes.indexOf(cliente), 1);
		$scope.cliente = {};
		isEdit = false;
	};
});