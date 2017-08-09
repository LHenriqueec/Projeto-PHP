
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Estudando PHP</title>
	
</head>
<body>

	<?php include_once("menu.php");?>
	<script src='source/js/produtoController.js'></script>
	<script type="text/javascript">
		angular.module('produtoApp', []).controller('produtoController', function($scope, $http) {

	$scope.isEdit = false;
	$scope.produtoSelec = {};

	$http.get('classes/actions/ProdutoActions/CarregarProdutos.php')
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
		angular.module('produtoApp', ['ngRoute']).config(function($routeProvider) {
		    $routeProvider
		    .when("/", {
		        templateUrl : "main.htm"
		    })
		    .when("/red", {
		        templateUrl : "red.htm"
		    })
		    .when("/green", {
		        templateUrl : "green.htm"
		    })
		    .when("/blue", {
		        templateUrl : "blue.htm"
		    });
		});
	</script>

	<div ng-app="produtoApp" ng-controller="produtoController">
		<form class="form-inline" method="post" action="dados.php?insert=true">
			<div class="panel panel-default">
				<div class="panel-body">
					<header>
						<h4>Produto</h4>
					</header>
					<div class="form-group">
						<label for="codigo">Código</label>
						<input id="codigo" class="form-control" type="text" name="codigo" placeholder="Código do produto" ng-model="produtoSelec.codigo">
					</div>

					<div class="form-group">
						<label for="nome">Nome</label>
						<input id="nome" class="form-control" type="text" name="produto" placeholder="Nome do produto" ng-model="produtoSelec.nome">
					</div>

					<button type="button" class="btn btn-primary" ng-click="salvar()">Salvar</button>
				</div>
			</div>
		
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Código</th>
						<th>Produto</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="produto in produtos">
						<td>{{produto.codigo}}</td>
						<td>{{produto.nome  | uppercase}}</td>
						<td>
							<button type="button" class="btn btn-info" ng-click="editar(produto)">Alterar</button>
							<button type="button" class="btn btn-danger" ng-click="remover(produto)">Deletar</button>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</body>
</html>