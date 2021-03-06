@extends('imobweb.template.index')

@section('content')
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

        <ul class="nav menu">
            <li><a href="/dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Home</a></li>
            @shield('view.imovel')<li  class="active"><a href="/dashboard/imoveis"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg> Imoveis</a></li>@endshield
            @shield('view.funcionario')<li><a href="/dashboard/funcionarios"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Funcionários</a></li>@endshield
            @shield('view.cliente')<li><a href="/dashboard/clientes"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Clientes</a></li>@endshield
            @shield('view.venda')<li><a href="/dashboard/vendas"><svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"/></svg> Vendas</a></li>@endshield
            @shield('view.reserva')<li><a href="/dashboard/reservas"><svg class="glyph stroked lock"><use xlink:href="#stroked-lock"/></svg> Reservas</a></li>@endshield
            @shield('view.contrato')<li><a href="/dashboard/contratos"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Contratos</a></li>@endshield
            @shield('view.relatorio')<li><a href="/dashboard/relatorios"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Relatórios</a></li>@endshield

            <li role="presentation" class="divider"></li>
            @shield('view.imobiliaria')<li><a href="/dashboard/imobiliaria"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Imobiliaria</a></li>@endshield
            @shield('view.usuario')<li><a href="/dashboard/usuarios"><svg class="glyph stroked key"><use xlink:href="#stroked-key"></use></svg> Usuários</a></li>@endshield
        </ul>

    </div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></li>
                <li class="active">Imóveis</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Imóveis</h1>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Consulta de Imóveis.</div>
                    <div class="panel-body">
                        <form class="form-horizontal form-pesquisa" method="post" action="/dashboard/imoveis/pesquisar">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="codigo">Código do Imóvel:</label>
                                <div class="col-sm-10">
                                    <input name="codigo" type="text" placeholder="Digite o código do imóvel" class="form-control" value="{{old('codigo')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="tipo_imovel">Tipo de Imóvel:</label>
                                <div class="col-sm-10">
                                    <select name="id_tipo_imovel" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        @foreach($tiposImoveis as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->descricao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                    @shield('create.imovel')
                                        <a href="/dashboard/imoveis/cadastra-imovel" class="btn btn-default">Novo</a>
                                    @else
                                        <a href="/dashboard/imoveis/cadastra-imovel" class="btn btn-default" disabled>Novo</a>
                                    @endshield
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$tituloTabela or 'Todos os Imóveis:'}}</div>
                    <div class="panel-body">
                        <table class="table table-hover"  id="imovel-table">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Rua</th>
                                <th>Número</th>
                                <th>Bairro</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($imoveis as $imovel)
                                <tr>
                                    <td>{{$imovel->codigo}}</td>
                                    <td>{{$imovel->nome_tipo}}</td>
                                    <td>{{$imovel->rua}}</td>
                                    <td>{{$imovel->numero}}</td>
                                    <td>{{$imovel->bairro}}</td>
                                    <td>
                                        @shield('edit.imovel')
                                            <a href="/dashboard/imoveis/edita-imovel/{{$imovel->id}}" class="btn btn-success btn-xs">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </a>
                                        @else
                                            <a href="/dashboard/imoveis/edita-imovel/{{$imovel->id}}" class="btn btn-success btn-xs" disabled>
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </a>
                                        @endshield
                                        @shield('delete.imovel')
                                            <a href="" onclick="modalDeleta('/dashboard/imoveis/deleta-imovel/{{$imovel->id}}')" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        @else
                                            <a href="" onclick="modalDeleta('/dashboard/imoveis/deleta-imovel/{{$imovel->id}}')" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" disabled>
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        @endshield
                                        @shield('create.imovel')
                                            <a href="/dashboard/imoveis/upload-imagem/{{$imovel->id}}" class="btn btn-primary btn-xs">
                                                <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                                            </a>
                                        @else
                                            <a href="/dashboard/imoveis/upload-imagem/{{$imovel->id}}" class="btn btn-primary btn-xs" disabled>
                                                <span class="glyphicon glyphicon-camera" aria-hidden="true"></span>
                                            </a>
                                        @endshield
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $imoveis->render() !!}
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>


    <!-- Modal de Deletar -->
    <div class="modal fade" id="modalDeletar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Exclusão de Imóvel</h4>
                </div>
                <div class="modal-body">
                    <form action="">
                        <input type="text" id="url-deletar" class="form-control" name="id" value="" style="display: none">
                    </form>
                    <p>Deseja realmente excluir este imóvel?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="deletaImovel">Confirmar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preloader -->
    <div class="modal fade bs-example-modal-sm" id="modalPreloader" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="spinner"></div>
                <p class="spinner-text">carregando..</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        //Chama modal de excluir
        function modalDeleta(url){

            $('#url-deletar').val(url);
            $('#modalDeletar').modal('show');
        }

        //Efetua a exclusão do imóvel
        $("#deletaImovel").click(function() {
            var url = $("#url-deletar").val();

            var request = $.ajax({
                url: url,
                method: "GET",
                beforeSend: iniciaPreloader()
            });
            request.done(function(data){
                finalizaPreloader();

                if(data == "1"){
                    $('#modalDeletar').modal('hide');

                    swal({
                        title: "Imóvel excluído com sucesso!",
                        type: "success",
                        timer: 4000,
                        showConfirmButton: false
                    });
                    setTimeout("$(window.document.location).attr('href', '/dashboard/imoveis'); ", 4000);
                }else{
                    $('#modalDeletar').modal('hide');
                    swal("Falha ao excluir imóvel! Informe o erro a ImobWeb no contato (16)99999-9999.", "","error");
                }

            });
            request.fail(function(){
                finalizaPreloader();
                swal("Falha Inesperada! Informe o erro a ImobWeb no contato (16)99999-9999.", "","error");
            });

            return false;
        });

        function iniciaPreloader(){
            $('#modalPreloader').modal({backdrop: 'static',  keyboard: false})
        }

        function finalizaPreloader(){
            $('#modalPreloader').modal('hide');
        }
    </script>
@endsection