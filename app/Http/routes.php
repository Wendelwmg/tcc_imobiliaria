<?php

/*
 * GRUPO DE ROTAS DO SISTEMA IMOBWEB
 */
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function(){

    Route::controller('usuarios', 'ImobWeb\UsuarioController');
    Route::controller('imobiliaria', 'ImobWeb\ImobiliariaController');
    Route::controller('relatorios', 'ImobWeb\RelatorioController');
    Route::controller('contratos', 'ImobWeb\ContratoController');
    Route::controller('clientes', 'ImobWeb\ClienteController');
    Route::controller('reservas', 'ImobWeb\ReservaController');
    Route::controller('vendas', 'ImobWeb\VendaController');
    Route::controller('funcionarios', 'ImobWeb\FuncionarioController');
    Route::controller('imoveis', 'ImobWeb\ImovelController');
    Route::controller('/', 'ImobWeb\HomeController');
});

/*
 * GRUPO DE ROTAS DO SITE IMOBWEB
 */
Route::group(['prefix' => 'site'], function () {
//    Route::get('teste/{mensagem}', 'Site\UsuarioController@postMailConfirmacao');
//    Route::get('cadastro-confirmacao/{titulo?}', function ($titulo = 'Confirmação de Cadastro') {
//        return view('site.confirma_cadastro', compact('titulo'));
//    });

    Route::get('confirmacao/{titulo?}', function ($titulo = 'Confirmação de E-mail') {
        return view('site.confirma_email', compact('titulo'));
    });
    Route::get('usuario/{id}', 'Site\UsuarioController@getIndex');
    Route::post('usuario', 'Site\UsuarioController@postAdicionarUsuario');
    Route::get('empresa/confirmacao-empresa/{id}', 'Site\EmpresaController@getConfirmacaoEmpresa');
    Route::get('empresa/confirmacao/{id}', 'Site\EmpresaController@getConfirmacao');
    Route::get('empresa/{id}', 'Site\EmpresaController@getIndex');
    Route::post('empresa', 'Site\EmpresaController@postAdicionarEmpresa');
    Route::post('send_mail', 'Site\PlanoController@postMailContato');

    /*Route::get('envia-email', function (){
        Mail::raw('Mesangem de testo puro', function($m){
           $m->to('taisapalenciano@gmail.com', 'Wendel')->subject('Enviando e-mails pela imobweb');
        });
    });*/

    Route::controller('/', 'Site\PlanoController');
});

// Rotas de autenticação
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Rotas de registro de usuários
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::get('/', function () {
    return view('welcome');
});