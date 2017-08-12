<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<title>Dasa: Clientes</title>
</head>
<body>
	<?php include_once "menu.php"; ?>
	<script src="source/js/controllerCliente.js"></script>

	<div ng-app="clienteApp" ng-controller="clienteController">
		
		<form class="form-horizontal">
			<div class="panel panel-default">
				<div class="panel-body">
					<head>
						<h4>Cliente</h4>
					</head>

					<div class="row">
						<div class="col-md-4">
							<header>
								<h5>Dados</h5>
							</header>

							<div class="form-group">
								<label for="cnpj" class="control-label col-md-2">CNPJ</label>
								<div class="col-md-12">
									<input id="cnpj" class="form-control" type="text" name="cnpj" placeholder="CNPJ do cliente" ng-model="cliente.cnpj">
								</div>
							</div>

							<div class="form-group">
								<label for="nome" class="control-label col-md-2">Nome</label>
								<div class="col-md-12">
									<input id="nome" class="form-control" type="text" name="nome" placeholder="Nome do cliente" ng-model="cliente.nome">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<header>
								<h5>Endereço</h5>

								<div class="form-group">
									<label class="control-label col-md-1">UF</label>
									<div class="col-md-12">
										<select class="form-control" ng-model="cliente.endereco.uf" style="width:20%">
											<option>DF</option>
											<option>GO</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="cidade" class="control-label col-md-2">Cidade</label>
									<div class="col-md-12">
										<input id="cidade" class="form-control" type="text" name="cidade" placeholder="Cidade do cliente" ng-model="cliente.endereco.cidade">
									</div>
								</div>

								<div class="form-group">
									<label for="bairro" class="control-label col-md-2">Bairro</label>
									<div class="col-md-12">
										<input id="bairro" class="form-control" type="text" name="bairro" placeholder="Bairro do cliente" ng-model="cliente.endereco.bairro">
									</div>
								</div>

								<div class="form-group">
									<label for="logradouro" class="control-label col-md-2">Logradouro</label>
									<div class="col-md-12">
										<input id="logradouro" class="form-control" type="text" name="logradouro" placeholder="Logradouro do cliente" ng-model="cliente.endereco.logradouro">
									</div>
								</div>
							</header>
						</div>
						<div class="col-md-4">
							<header>
								<h5>Contato</h5>
							</header>

							<div class="form-group">
								<label for="telefone" class="control-label col-md-2">Telefone</label>
								<div class="col-md-12">
									<input id="telefone" class="form-control" type="text" name="telefone" placeholder="Telefone do cliente" ng-model="cliente.contato.telefone">
								</div>
							</div>

							<div class="form-group">
								<label for="celular" class="control-label col-md-2">Celular</label>
								<div class="col-md-12">
									<input id="celular" class="form-control" type="text" name="celular" placeholder="Celular do cliente" ng-model="cliente.contato.celular">
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="control-label col-md-2">E-mail</label>
								<div class="col-md-12">
									<input id="email" class="form-control" type="text" name="email" placeholder="E-mail do cliente" ng-model="cliente.contato.email">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-offset-8 col-sm-1">
									<button type="button" class="btn btn-primary" ng-click="salvar();">Salvar</button>
							  	</div>
						  	</div>
						</div>
					</div>
				</div>
			</div>
		</form>

		
		<div class="panel" style="width:20%">
				<input type="text" class="form-control" placeholder="Procurar Cliente" ng-model="nameFilter">
		</div>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>CNPJ</th>
					<th>Nome</th>
					<th>Bairro</th>
					<th>Endereço</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="cliente in clientes  | filter : nameFilter">
					<td>{{cliente.cnpj | uppercase}}</td>
					<td>{{cliente.nome | uppercase}}</td>
					<td>{{cliente.endereco.bairro | uppercase}}</td>
					<td>{{cliente.endereco.logradouro | uppercase}}</td>
					<td style="width:20%;text-align:center">
						<button type="button" class="btn btn-info" ng-click="alterar(cliente)">Alterar</button>
						<button type="button" class="btn btn-danger" ng-click="remover(cliente)">Deletar</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</body>
</html>