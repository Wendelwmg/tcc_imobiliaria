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
            @shield('view.imobiliaria')<li><a href="/dashboard/imobiliaria"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Imobiliaria</a></li>@endshield
            @shield('view.usuario')<li  class="active"><a href="/dashboard/usuarios"><svg class="glyph stroked key"><use xlink:href="#stroked-key"></use></svg> Usuários</a></li>@endshield
        </ul>

    </div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><svg class="glyph stroked key"><use xlink:href="#stroked-key"></use></svg></li>
                <li><a href="/dashboard/usuarios">Usuários</a></li>
                <li class="active">Edição de Usuário</li>
            </ol>
        </div><!--/.row-->
        @shield('edit.usuario')
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edição de Usuários</h1>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Informe os dados a serem alterados.</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="/dashboard/usuarios/edita-usuario/{{$usuario->id}}" send="/dashboard/usuarios/edita-usuario/{{$usuario->id}}">
                            {!! csrf_field() !!}
                            <div class="form-group" hidden>
                                <label class="control-label col-sm-2" for="empresa">Empresa:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="id_empresa" placeholder="empresa" value="{{$usuario->id_empresa}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="nome">Nome: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" placeholder="Digite o nome de usuário" value="{{$usuario->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">E-mail: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="Digite o e-mail" value="{{$usuario->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="senha">Senha: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" placeholder="Digite a nova senha" value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="confirma_senha">Confirmar Senha: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Digite a senha novamente">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                    <a href="/dashboard/usuarios" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endshield
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

    <!-- Modal Status Success-->
    <div class="modal fade bs-example-modal-sm" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header header-success">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="message-success"></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Status Warning-->
    <div class="modal fade bs-example-modal-sm" id="modalWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header header-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="message-warning"></h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $("form").submit(function(){
                var dadosForm = $(this).serialize();
                console.log(dadosForm);
                jQuery.ajax({
                    method:"POST",
                    url: jQuery(this).attr("send"),
                    data: dadosForm,
                    beforeSend: iniciaPreloader()
                }).done(function(data){
                    finalizaPreloader();

                    if(data == 1){                        
                        swal({   
                            title: "Usuário alterado com sucesso!",   
                            type: "success",   
                            timer: 4000,   
                            showConfirmButton: false 
                            });
                            setTimeout("$(window.document.location).attr('href', '/dashboard/usuarios'); ", 4000);                        
                    }else{
                        for(var t in data){
                            swal(data[t], "","warning");                            
                        }
                    }

                }).fail(function(){
                    finalizaPreloader();                    
                    swal("Falha Inesperada! Informe o erro a ImobWeb no contato (16)99999-9999.", "","error");
                });
                return false;
            });
        });

        function iniciaPreloader(){
            $('#modalPreloader').modal({backdrop: 'static',  keyboard: false})
        }

        function finalizaPreloader(){
            $('#modalPreloader').modal('hide');
        }
    </script>

@endsection