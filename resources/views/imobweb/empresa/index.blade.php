@extends('imobweb.template.index')

@section('content')	
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

		<ul class="nav menu">
			<li><a href="/dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Home</a></li>
			@shield('view.imovel')<li><a href="/dashboard/imoveis"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg> Imoveis</a></li>@endshield
			@shield('view.funcionario')<li><a href="/dashboard/funcionarios"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Funcionários</a></li>@endshield
			@shield('view.cliente')<li><a href="/dashboard/clientes"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Clientes</a></li>@endshield
			@shield('view.venda')<li><a href="/dashboard/vendas"><svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"/></svg> Vendas</a></li>@endshield
			@shield('view.reserva')<li><a href="/dashboard/reservas"><svg class="glyph stroked lock"><use xlink:href="#stroked-lock"/></svg> Reservas</a></li>@endshield
			@shield('view.contrato')<li><a href="/dashboard/contratos"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Contratos</a></li>@endshield
			@shield('view.relatorio')<li><a href="/dashboard/relatorios"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Relatórios</a></li>@endshield

			<li role="presentation" class="divider"></li>
			@shield('view.imobiliaria')<li class="active"><a href="/dashboard/imobiliaria"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Imobiliaria</a></li>@endshield
			@shield('view.usuario')<li><a href="/dashboard/usuarios"><svg class="glyph stroked key"><use xlink:href="#stroked-key"></use></svg> Usuários</a></li>@endshield
		</ul>

	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg></li>
				<li class="active">Imobiliária</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Imobiliária</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">{{$imobiliaria->razao_social}}.</div>
					<div class="panel-body">

						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-2" for="razao_social">Razão Social:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="razao_social" placeholder="{{$imobiliaria->razao_social}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="nome_fantasia">Nome Fantasia:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nome_fantasia" placeholder="{{$imobiliaria->nome_fantasia}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cnpj">CNPJ:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="cnpj" placeholder="{{$imobiliaria->cnpj}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="email">E-mail:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="email" placeholder="{{$imobiliaria->email}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="telefone">Telefone:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="telefone" placeholder="{{$imobiliaria->telefone}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="inscricao">Inscrição:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="inscricao" placeholder="{{$imobiliaria->inscricao}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="creci">CRECI:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="creci" placeholder="{{$imobiliaria->creci}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cep">CEP:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="cep" placeholder="{{$imobiliaria->cep}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="rua">Rua:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="rua" placeholder="{{$imobiliaria->rua}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="numero">Número:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="numero" placeholder="{{$imobiliaria->numero}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="bairro">Bairro:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="bairro" placeholder="{{$imobiliaria->bairro}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cidade">Cidade:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="cidade" placeholder="{{$imobiliaria->cidade}}" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="uf">Estado:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="uf" placeholder="{{$imobiliaria->uf}}" readonly>
								</div>
							</div>
							@if($plano->id == 1)
								<div class="form-group">
									<label class="control-label col-sm-2" for="plano">Plano Vigente:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="plano" placeholder="{{$plano->nome}} - 100% {{$plano->valor}}" readonly>
									</div>
								</div>
							@else
								<div class="form-group">
									<label class="control-label col-sm-2" for="plano">Plano Vigente:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="plano" placeholder="{{$plano->nome}} - R$ {{$plano->valor}}" readonly>
									</div>
								</div>
							@endif
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection