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
	})
	.when("/recibo", {
		templateUrl : "views/recibo.html",
		controller : "reciboController as cRecibo"
		
	});
});

app.service("containerRecibo", function() {

	this.selecionarRecibo = function(recibo) {
		this.recibo = recibo;
	}
});

// CONTROLLER: RECIBO
app.controller("reciboController", function(containerRecibo) {
	var ctrl = this;
	ctrl.recibo = containerRecibo.recibo;
	ctrl.recibo.itens = containerRecibo.recibo.itens;

	var item_buffer;
	var itens = [];
	ctrl.recibo.itens.forEach(function(item) {
		if(!item_buffer || item_buffer.produto.codigo != item.produto.codigo) {
			item_buffer = {};
			item_buffer.produto = item.produto;
			item_buffer.quantidade = 0;

			var filter_itens = ctrl.recibo.itens.filter(function(itemFilter) {
				return item_buffer.produto.codigo == itemFilter.produto.codigo;
			});

			filter_itens.forEach(function(item) {
				item_buffer.quantidade += Number.parseInt(item.quantidade);
			});

			itens.push(item_buffer);
		}
	});

	ctrl.recibo.itens = itens;
});

// CONTROLLER: MAIN
app.controller("mainController", function($scope, $http, $rootScope, containerRecibo) {
	var ctrl = this;
	var itemRecibo;
	ctrl.recibo_info;

	carregarProdutos();

	carregarClientesSemCompra();

	carregarRecibos();

	ctrl.novoRecibo = function() {
		ctrl.recibo = {};
		ctrl.recibo.numero = gerarNumero();
		ctrl.recibo.data = new Date();

		$http.post("classes/action/cliente/CarregarClientes.php").then(function(response) {
			ctrl.clientes = response.data;
			if(ctrl.clientes.length == 0) ctrl.clientes = undefined;
		});
	}

	ctrl.cancelar = function() {
		carregarClientesSemCompra();
		carregarProdutos();
		ctrl.isNew = false;
	}

	ctrl.salvar = function() {
		var json = angular.toJson(ctrl.recibo);
		
		$http.post('classes/action/recibo/SalvarRecibo.php', json);
		if(!ctrl.recibos) ctrl.recibos = [];
		ctrl.recibos.push(ctrl.recibo);
		ctrl.recibo = {};
	}

	ctrl.deletar_recibo = function(index) {
		ctrl.recibos[index].itens.forEach(recalcularProdutos);
		
		$http.get('classes/action/recibo/DeletarRecibo.php?recibo=' + ctrl.recibos[index].numero);
		
		ctrl.recibos.splice(index, 1);
		if(ctrl.recibos.length == 0) ctrl.recibos = undefined;
	}

	ctrl.selecionarCliente = function(cliente) {
		ctrl.recibo.cliente = cliente;
		ctrl.isNew = true;
	}

	ctrl.buscarProduto = function() {
		$http.get("classes/action/produto/BuscarProduto.php?search=" +ctrl.searchProduto).then(function(response) {
			var data = response.data;
			ctrl.item = {};
			ctrl.item.produto = {codigo:data.codigo, nome:data.nome};
			ctrl.disponivel = data.quantidade;
			if(!ctrl.item.produto) {
				ctrl.searchProduto = "Não encontrado";
			} else {
				ctrl.searchProduto =  ctrl.item.produto.codigo + " - " + ctrl.item.produto.nome;
			}
		});
	}

	ctrl.inserir = function() {
		if(!ctrl.recibo.itens) {
			ctrl.recibo.itens = [];
			ctrl.recibo.total = 0;
		}
		ctrl.recibo.itens.push(ctrl.item);
		ctrl.recibo.total += Number.parseInt(ctrl.item.quantidade);
		ctrl.searchProduto = '';
		ctrl.item = {};
	}

	ctrl.imprimir_recibo = function(index) {
		containerRecibo.selecionarRecibo(ctrl.recibos[index]);
	}

	ctrl.infoRecibo = function(index) {
		var recibo = ctrl.recibos[index];
		ctrl.recibo_info = '';
		
		var item_buffer;
		recibo.itens.forEach(function(item) {
			if(!item_buffer || item_buffer.produto.codigo != item.produto.codigo) {
				item_buffer = {};
				item_buffer.produto = item.produto;
				item_buffer.quantidade = 0;

				var filter_itens = recibo.itens.filter(function(itemFilter) {
					return item_buffer.produto.codigo == itemFilter.produto.codigo;
				});

				filter_itens.forEach(function(item) {
					item_buffer.quantidade += Number.parseInt(item.quantidade);
				});

				ctrl.recibo_info += item_buffer.produto.nome + ": " + item_buffer.quantidade + "\n";
			}
		});
	}

	function gerarNumero() {
		if(!ctrl.recibos || ctrl.recibos.length == 0) {
			return '17000';
		} else {
			index = ctrl.recibos.length - 1;
			return Number.parseInt(ctrl.recibos[index].numero) + 1;
		}
	}

	function carregarClientesSemCompra() {
		$http.post("classes/action/cliente/CarregarClientesSemCompra.php").then(function(response) {
			ctrl.clientesSemCompra = response.data;
			if(ctrl.clientesSemCompra.length == 0) ctrl.clientesSemCompra = undefined;
		});
	}

	function carregarProdutos() {
		$http.post("classes/action/nota/CarregarItensNota.php").then(function(response) {
			ctrl.itens = response.data;
			ctrl.total = 0;
			if(ctrl.itens.length == 0) {
				ctrl.itens = undefined
			} else {
				for (i = 0; i < ctrl.itens.length; i++) {
					ctrl.total += Number.parseInt(ctrl.itens[i].quantidade);
				}
			}
		});
	}

	function carregarRecibos() {
		$http.post("classes/action/recibo/CarregarRecibos.php").then(function(response) {
			ctrl.recibos = response.data;
			if(ctrl.recibos.length == 0) {
				ctrl.recibos = undefined;
				return;
			}

			for(var index = 0; index < ctrl.recibos.length; index++) {
				var recibo = ctrl.recibos[index];

				for(var i = 0; i < recibo.itens.length; i++) {
					if(!recibo.total) recibo.total = 0;
					recibo.total += Number.parseInt(recibo.itens[i].quantidade);
				}

			}
		});


	}

	// função usada no forEach para calcular do produtos por item
	function recalcularProdutos(item) {
		itemRecibo = item;
		var itemNota = ctrl.itens.find(procurarItemNota);
		itemNota.quantidade = Number.parseInt(itemNota.quantidade) + Number.parseInt(item.quantidade);
		ctrl.total += Number.parseInt(item.quantidade);
	}

	// função usada no 'find' de arrays
	function procurarItemNota(itemNota) {
		return itemNota.codigo == itemRecibo.produto.codigo;
	}
});

//  CONTROLLER: NOTA
app.controller("notaController", function($http) {
	var ctrl = this;
	ctrl.isNew = false;
	ctrl.nota = undefined;
	ctrl.item = {};
	ctrl.itens = undefined;
	ctrl.total = 0;
	ctrl.search = undefined;

	$http.post('classes/action/nota/CarregarNotas.php')
	.then(function(response) {
		ctrl.notas = response.data;
		if(ctrl.notas.length == 0) ctrl.notas = undefined;
	});


	ctrl.novo = function() {
		$http.post('classes/action/cliente/CarregarClientes.php')
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
			url : 'classes/action/produto/BuscarProduto.php',
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
		

		$http.post('classes/action/nota/SalvarNota.php', json).then(function(response) {
			console.info(response.data);
		});
		if(!ctrl.notas) ctrl.notas = [];
		ctrl.notas.push(ctrl.nota);
		limpar();
		ctrl.isNew = false;
	};

	ctrl.deletar = function(index) {
		$http.get('classes/action/nota/DeletarNota.php?nota=' + ctrl.notas[index].numero);
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

// CONTROLLER: PRODUTO

app.controller("produtoController", function($scope, $http) {
	$scope.isEdit = false;
	$scope.produto = {};
	$scope.teste = 'mensagem não recebida!';

	$scope.$on('teste', function(event, message) {
		$scope.teste = message;
		console.info(message);
	});

	$http.post('classes/action/produto/CarregarProdutos.php')
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
			$http.post("classes/action/produto/AlterarProduto.php", json)
			.then(function(response) {
				console.info(response.data);
			});
		} else {
			$http.post("classes/action/produto/SalvarProduto.php", json)
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

		$http.post('classes/action/produto/DeletarProduto.php', {"codigo":produto.codigo})
		.then(function(response) {
			console.info(response.data);
		});
	};
});

// CONTROLLER: CLIENTE

app.controller("clienteCotnroller", function($scope, $http) {

	var isEdit = false;

	$http.post('classes/action/cliente/CarregarClientes.php')
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
			$http.post('classes/action/cliente/AlterarCliente.php', json);
			console.info(json);
		} else {
			$http.post('classes/action/cliente/SalvarCliente.php', json)
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
		$http.post('classes/action/cliente/DeletarCliente.php', cliente.cnpj);
		$scope.clientes.splice($scope.clientes.indexOf(cliente), 1);
		$scope.cliente = {};
		isEdit = false;
	};
});	