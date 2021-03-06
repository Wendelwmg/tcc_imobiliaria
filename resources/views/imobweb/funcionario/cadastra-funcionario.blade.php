@extends('imobweb.template.index')

@section('content')

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

        <ul class="nav menu">
            <li><a href="/dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Home</a></li>
            @shield('view.imovel')<li><a href="/dashboard/imoveis"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg> Imoveis</a></li>@endshield
            @shield('view.funcionario')<li  class="active"><a href="/dashboard/funcionarios"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Funcionários</a></li>@endshield
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
                <li><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg></li>
                <li><a href="/dashboard/funcionarios">Funcionários</a></li>
                <li class="active">Cadastro de Funcionário</li>
            </ol>
        </div><!--/.row-->
        @shield('create.funcionario')
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cadastro de Funcionário</h1>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Informe os dados do novo funcionário.</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="/dashboard/funcionarios/cadastra-funcionario" send="/dashboard/funcionarios/cadastra-funcionario">
                            {!! csrf_field() !!}
                            <div class="form-group form-inline">
                                <label for="tipo_pessoa" class="control-label col-sm-2">Tipo Pessoa: </label>
                                <label class="form-check-inline col-sm-1">
                                    <input class="form-check-input" type="radio" name="tipo_pessoa" id="radio_cpf" value="F"> CPF
                                </label>
                                <label class="form-check-inline ">
                                    <input class="form-check-input" type="radio" name="tipo_pessoa" id="radio_cnpj" value="J"> CNPJ
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" id="label_cpfCnpj"  for="cpf_cnpj"></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control cpf_cnpj" name="cpf_cnpj" placeholder="" value="{{old('cpf_cnpj')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" id="label_nomeRazao"  for="nome_razao"></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control nome_razao" name="nome_razao" placeholder="" value="{{old('nome_razao')}}">
                                </div>
                            </div>
                            <div id="tipo_cpf" style="display: none;">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="rg">RG: <strong class="color-red">*</strong></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="rg" placeholder="Digite o RG" value="{{old('rg')}}">
                                    </div>
                                </div>
                            </div>
                            <div id="tipo_cnpj" style="display: none;">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="nome_fantasia">Nome Fantasia:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nome_fantasia" placeholder="Digite o nome fantasia" value="{{old('nome_fantasia')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="rep_legal">Representante legal: <strong class="color-red">*</strong></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="rep_legal" placeholder="Digite o representante legal" value="{{old('rep_legal')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="inscricao">Inscrição: <strong class="color-red">*</strong></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="inscricao" placeholder="Digite o número de inscrição" value="{{old('inscricao')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="creci">CRECI: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="creci" placeholder="Digite o número de creci" value="{{old('creci')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="data_nascimento">Data de Nascimento: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="data_nascimento" placeholder="Digite a data de nascimento" value="{{old('data_nascimento')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="telefone">Telefone: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="telefone" placeholder="Digite o número de telefone" value="{{old('telefone')}}">
                                </div>
                            </div>
                            <div class="form-group form-inline">
                                <label for="usuario" class="control-label col-sm-2">Usuário do Sistema: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_user">
                                        <option value="">Selecione uma opção</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-inline">
                                <label for="cargo" class="control-label col-sm-2">Cargo: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_cargo">
                                        <option value="">Selecione uma opção</option>
                                        @foreach($cargos as $cargo)
                                            <option value="{{$cargo->id}}">{{$cargo->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" hidden>
                                <label class="control-label col-sm-2" for="empresa">Empresa:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="id_empresa" placeholder="empresa" value="{{Auth::user()->id_empresa}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="cep">CEP: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cep" placeholder="Digite o número de cep" value="{{old('cep')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="rua">Rua: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="rua" placeholder="Digite a rua" value="{{old('rua')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="numero">Número: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="numero" placeholder="Digite o número da residência" value="{{old('numero')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="bairro">Bairro: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="bairro" placeholder="Digite o bairro" value="{{old('bairro')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="cidade">Cidade: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cidade" placeholder="Digite a cidade" value="{{old('cidade')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="uf">Estado: <strong class="color-red">*</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="uf" placeholder="Digite o estado" value="{{old('uf')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                    <a href="/dashboard/funcionarios" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </form>
                        </div>                                               
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

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        

         $("#radio_cpf").attr('checked', true);

         if ($("#radio_cpf").prop("checked")){

             $("#tipo_cnpj input").val("");
             $("#tipo_cnpj").hide();
             $("#tipo_cpf").show();
             $("#label_cpfCnpj").html('CPF: <strong class="color-red">*</strong>');
             $(".cpf_cnpj").attr('placeholder', 'Digite o número do CPF');
             $("#label_nomeRazao").html('Nome: <strong class="color-red">*</strong>');
             $(".nome_razao").attr('placeholder', 'Digite o nome');

         }else{

             $("#tipo_cpf input").val("");
             $("#tipo_cpf").hide();
             $("#tipo_cnpj").show();
             $("#label_cpfCnpj").html('CNPJ: <strong class="color-red">*</strong>');
             $(".cpf_cnpj").attr('placeholder', 'Digite o número do CNPJ');
             $("#label_nomeRazao").html('Razão Social: <strong class="color-red">*</strong>');
             $(".nome_razao").attr('placeholder', 'Digite a razão social');
         }

        $("#radio_cpf").click(function () {
            $(".cpf_cnpj").val("");
            $("#tipo_cnpj input").val("");
            $("#tipo_cnpj").hide();
            $("#tipo_cpf").show();
            $("#label_cpfCnpj").html('CPF: <strong class="color-red">*</strong>');
            $(".cpf_cnpj").attr('placeholder', 'Digite o número do CPF');
            $("#label_nomeRazao").html('Nome: <strong class="color-red">*</strong>');
            $(".nome_razao").attr('placeholder', 'Digite o nome');
        });

        $("#radio_cnpj").click(function () {
            $(".cpf_cnpj").val("");
            $("#tipo_cpf input").val("");
            $("#tipo_cpf").hide();
            $("#tipo_cnpj").show();
            $("#label_cpfCnpj").html('CNPJ: <strong class="color-red">*</strong>');
            $(".cpf_cnpj").attr('placeholder', 'Digite o número do CNPJ');
            $("#label_nomeRazao").html('Razão Social: <strong class="color-red">*</strong>');
            $(".nome_razao").attr('placeholder', 'Digite a razão social');
        });           

    });
</script>

<script>
    $(function(){
        $("form").submit(function(){
            var dadosForm = $(this).serialize();

            jQuery.ajax({
                method:"POST",
                url: jQuery(this).attr("send"),
                data: dadosForm,
                beforeSend: iniciaPreloader()
            }).done(function(data){
                finalizaPreloader();

                if(data == 1){
                    swal({   
                        title: "Funcionário cadastrado com sucesso!",   
                        type: "success",   
                        timer: 4000,   
                        showConfirmButton: false 
                        });
                        setTimeout("$(window.document.location).attr('href', '/dashboard/funcionarios'); ", 4000);                   				    	
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