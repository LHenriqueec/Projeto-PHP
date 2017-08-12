<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>Dasa: Produtos</title>
</head>
<body>
	<?php include_once "menu.php"; ?>
	<script src="source/js/controllerProduto.js"></script> 

	<div ng-app="produtoApp" ng-controller="produtoController">
		<form class="form-inline">
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
						<td style="width:20%;text-align:center">
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