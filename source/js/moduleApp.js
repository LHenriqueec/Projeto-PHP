var app = angular.module("menuApp", ["ngRoute"]);

app.config(function($routeProvider) {
	$routeProvider
	.when("/", {
		templateUrl : "views/main.html",
		controller : "mainController as main"
	})
	.when("/clientes", {
		templateUrl : "views/clientes.html",
		controller : "clienteCotnroller"
	})
	.when("/produtos", {
		templateUrl : "views/produtos.html",
		controller : "produtoController"
	})
	.when("/notas", {
		templateUrl : "views/notas.html",
		controller : "notaController as cNota"
	});
});

<!-- Main controller -->
app.controller("mainController", function($scope, $http, $rootScope) {
	var ctrl = this;
	ctrl.itens = undefined;
	ctrl.total = 0;
	
	$http.post('classes/CarregarItensNota.php')
	.then(function(response) {
		ctrl.itens = response.data;

		if(ctrl.itens.length == 0) {
			ctrl.itens = undefined;
		} else {
			for(var i = 0; ctrl.itens.length > i; i++) {
				ctrl.total += Number.parseInt(ctrl.itens[i].quantidade);
			}
		}
	});

	$http.post('classes/CarregarClientesSemCompra.php')
	.then(function(response) {
		ctrl.clientes = response.data;
		console.info(response.data[0]);
	});
});

<!-- Nota Controller -->
app.controller("notaController", function($http) {
	var ctrl = this;
	ctrl.isNew = false;
	ctrl.nota = undefined;
	ctrl.item = {};
	ctrl.itens = undefined;
	ctrl.total = 0;
	ctrl.search = undefined;

	$http.post('classes/CarregarNotas.php')
	.then(function(response) {
		ctrl.notas = response.data;
		if(ctrl.notas.length == 0) ctrl.notas = undefined;
	});


	ctrl.novo = function() {
		$http.post('classes/CarregarClientes.php')
		.then(function(response) {
			ctrl.clientes = response.data;
		});
		ctrl.nota = {};
		ctrl.nota.data = new Date();
		ctrl.isNew = true;
	};

	ctrl.inserir = function() {
		if(!ctrl.itens) ctrl.itens = [];
		ctrl.itens.push(ctrl.item);
		ctrl.search = '';
		ctrl.item = {};
	};

	ctrl.buscarProduto = function() {
		if (!ctrl.search)
			return;
		var req = {
			method : 'GET',
			url : 'classes/BuscarProduto.php',
			params : {
				search : ctrl.search
			}
		};
		$http(req).then(
			function(response) {
				var produto = response.data;

				if (!produto) {
					ctrl.search = 'Não encontrado';
				} else {
					ctrl.item.produto = produto;
					ctrl.search = produto.codigo
					+ " - " + produto.nome;
				}
			});
	};

	ctrl.salvar = function() {
		ctrl.nota.itens = ctrl.itens;
		var json = angular.toJson(ctrl.nota);
		

		$http.post('classes/SalvarNota.php', json).then(function(response) {
			console.info(response.data);
		});
		if(!ctrl.notas) ctrl.notas = [];
		ctrl.notas.push(ctrl.nota);
		limpar();
		ctrl.isNew = false;
	};

	ctrl.deletar = function(index) {
		$http.get('classes/DeletarNota.php?nota=' + ctrl.notas[index].numero);
		ctrl.notas.splice(index, 1);
		if(ctrl.notas.length == 0) ctrl.notas = undefined;
	};

	ctrl.selecionarCliente = function(cliente) {
		ctrl.nota.cliente = cliente;
	};

	ctrl.confirmar = function() {
		
	};

	ctrl.cancelar = function() {
		ctrl.isNew = false;
		limpar();

	};

	function limpar() {
		ctrl.nota = undefined;
		ctrl.itens = undefined;
	};
});

<!-- Produto controller -->

app.controller("produtoController", function($scope, $http) {
	$scope.isEdit = false;
	$scope.produto = {};
	$scope.teste = 'mensagem não recebida!';

	$scope.$on('teste', function(event, message) {
		$scope.teste = message;
		console.info(message);
	});

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
		$scope.clientes = response.data;
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
		$http.post('classes/DeletarCliente.php', cliente.cnpj);
		$scope.clientes.splice($scope.clientes.indexOf(cliente), 1);
		$scope.cliente = {};
		isEdit = false;
	};
});	