angular.module('clienteApp', []).controller('clienteController', function($scope, $http) {
	
	$scope.cliente = {};
	

	$scope.valuesUF = ["Emil", "Tobias", "Linus"];

	var isEdit = false;

	$http.post('classes/actions/ClienteActions/CarregarClientes.php')
		.then(function(response) {
			$scope.clientes = response.data.clientes;
		});

	$scope.salvar = function() {
		var json = angular.toJson($scope.cliente);
		
		if(isEdit) {
			$http.post('classes/actions/ClienteActions/AlterarCliente.php', json);
			console.info(json);
		} else {
			$http.post('classes/actions/ClienteActions/SalvarCliente.php', json)
				.then(function(response) {
					console.info(response.data);
				});
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
		$http.post('classes/actions/ClienteActions/DeletarCliente.php', {"cnpj":cliente.cnpj});
		$scope.clientes.splice($scope.clientes.indexOf(cliente), 1);
		$scope.cliente = {};
		isEdit = false;
	};
});