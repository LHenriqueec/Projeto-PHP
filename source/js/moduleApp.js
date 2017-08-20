var app = angular.module("menuApp", ["ngRoute"]);

app.config(function($routeProvider) {
	$routeProvider
		.when("/", {
			templateUrl : "views/main.html",
			controller : "mainController"
		})
		.when("/clientes", {
			templateUrl : "views/clientes.html",
			controller : "clienteCotnroller"
		})
		.when("/produtos", {
			templateUrl : "views/produtos.html",
			controller : "produtoController"
		});
});

<!-- Main controller -->
app.controller("mainController", function($scope, $http) {
	$scope.produtos = [
				{codigo: 10, nome: "picole", quantidade: 500},
				{codigo: 12, nome: "cup", quantidade: 500},
				{codigo: 123, nome: 'pote', quantidade: 120}
				];
	$scope.total = 0;

	for (var i = $scope.produtos.length - 1; i >= 0; i--) {
		var produto = $scope.produtos[i];
		$scope.total += produto.quantidade;

	}

	
});

<!-- Produto controller -->

app.controller("produtoController", function($scope, $http) {
	$scope.isEdit = false;
	$scope.produto = {};

	$http.post('classes/CarregarProdutos.php')
	.then(function(response) {
		$scope.produtos = response.data;
	});

	$scope.editar = function(produto) {
		console.log(produto.nome);
		$scope.produto = produto;
		$scope.isEdit = true;
	};	

	$scope.salvar = function() {
		var json = angular.toJson($scope.produto);

		if($scope.isEdit) {
			$http.post("classes/AlterarProduto.php", json)
				.then(function(response) {
					console.info(response.data);
				});
		} else {
			$http.post("classes/SalvarProduto.php", json)
				.then(function(response) {
					console.info(response.data);
				});
			$scope.produtos.push($scope.produto);
		}

		$scope.isEdit = false;
		$scope.produto = {};
	};

	$scope.remover = function(produto) {
		$scope.produtos.splice($scope.produtos.indexOf(produto), 1);
		$scope.isEdit = false;
		$scope.produto = {};

		$http.post('classes/DeletarProduto.php', {"codigo":produto.codigo})
			.then(function(response) {
				console.info(response.data);
		});
	};
});

<!-- Cliente controller -->

app.controller("clienteCotnroller", function($scope, $http) {

	var isEdit = false;

	$http.post('classes/CarregarClientes.php')
		.then(function(response) {
			$scope.clientes = response.data.clientes;
		});

	$scope.novo = function() {
		$scope.cliente = {};
		isEdit = false;
	}

	$scope.salvar = function() {
		var json = angular.toJson($scope.cliente);
		
		if(isEdit) {
			$http.post('classes/AlterarCliente.php', json);
			console.info(json);
		} else {
			$http.post('classes/SalvarCliente.php', json)
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
		$http.post('classes/DeletarCliente.php', {"cnpj":cliente.cnpj});
		$scope.clientes.splice($scope.clientes.indexOf(cliente), 1);
		$scope.cliente = {};
		isEdit = false;
	};
});	