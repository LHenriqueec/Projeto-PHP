angular.module('produtoApp', []).controller('produtoController', function($scope, $http) {

	$scope.isEdit = false;
	$scope.produtoSelec = {};

	$http.post('classes/actions/ProdutoActions/CarregarProdutos.php')
	.then(function(response) {
		$scope.produtos = response.data.produtos;
	});

	$scope.editar = function(produto) {
		console.log(produto.nome);
		$scope.produtoSelec = produto;
		$scope.isEdit = true;
	};	

	$scope.salvar = function() {
		if($scope.isEdit) {
			$http.post("classes/actions/ProdutoActions/AlterarProduto.php", {"codigo":$scope.produtoSelec.codigo, "nome":$scope.produtoSelec.nome})
				.then(function(response) {
					console.info(response.data);
				});
		} else {
			$http.post("classes/actions/ProdutoActions/SalvarProduto.php", {"codigo":$scope.produtoSelec.codigo, "nome":$scope.produtoSelec.nome})
				.then(function(response) {
					console.info(response.data);
				});
			$scope.produtos.push($scope.produtoSelec);
		}

		$scope.isEdit = false;
		$scope.produtoSelec = {};
	};

	$scope.remover = function(produto) {
		$scope.produtos.splice($scope.produtos.indexOf(produto), 1);
		$scope.isEdit = false;
		$scope.produtoSelec = {};

		$http.post('classes/actions/ProdutoActions/DeletarProduto.php', {"codigo":produto.codigo})
			.then(function(response) {
				console.info(response.data);
		});
	};
});