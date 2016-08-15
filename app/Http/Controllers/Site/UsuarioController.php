<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Cargo;
use Illuminate\Validation\Factory;
use Validator;

class UsuarioController extends Controller
{
    private $request;
    private $usuario;
    private $validator;

    public function __construct(Request $request, User $usuario, Factory $validator){
        $this->request = $request;
        $this->usuario = $usuario;
        $this->validator = $validator;
    }

    public function getIndex($param){
        //dd($param);
        $titulo = 'Cadastro de Usuário';
        $empresa = Empresa::all()->find($param);
        $cargos = Cargo::all();

        return view('site.cadastra_usuario', compact('titulo', 'empresa', 'cargos'));

    }

    public function postAdicionarUsuario(){

        $dadosForm = $this->request->all();

        //válida os dados referente as regras na model
        $valida_required = $this->validator->make($dadosForm, User::$rules_required);
        $valida_size = $this->validator->make($dadosForm, User::$rules_size);
        $valida_type = $this->validator->make($dadosForm, User::$rules_type);
        $valida_duplicated = $this->validator->make($dadosForm, User::$rules_duplicated);
        $valida_confirmation = $this->validator->make($dadosForm, User::$rules_confirmation);

        //válida os campos obrigatórios
        if ($valida_required->fails()) {
            $messages = $valida_required->messages();

            if ($messages->all()) {
                $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!<i class='material-icons right'>warning</i>");
            }

            return $displayErrors;
        };

        //válida a quantidade mínima de caracteres por campo
        if ($valida_size->fails()) {
            $messages = $valida_size->messages();

            if ($messages->all()) {
                $displayErrors = array("A senha deve ter no mínimo 6 caracteres!<i class='material-icons right'>warning</i>");
            }

            return $displayErrors;
        };

        //válida os tipos dos campos
        if ($valida_type->fails()) {
            $messages = $valida_type->messages();

            $displayErrors = array();

            foreach ($messages->all("<p>:message<i class='material-icons right'>warning</i></p>") as $error) {
                array_push($displayErrors, $error);
            }

            return $displayErrors;
        };


        //válida os registros duplicados
        if ($valida_duplicated->fails()) {
            $messages = $valida_duplicated->messages();

            $displayErrors = array();

            foreach ($messages->all("<p>:message<i class='material-icons right'>warning</i></p>") as $error) {
                array_push($displayErrors, $error);
            }

            return $displayErrors;
        };

        //válida confirmação de senha
        if ($valida_confirmation->fails()) {
            $messages = $valida_confirmation->messages();

            if ($messages->all()) {
                $displayErrors = array("A confirmação da senha não confere!<i class='material-icons right'>warning</i>");
            }

            return $displayErrors;
        };

        //efetua o cadastro do usuário criptografando a senha
        User::create([
            'name' => $dadosForm['name'],
            'email' => $dadosForm['email'],
            'password' => bcrypt($dadosForm['password']),
            'id_empresa' => $dadosForm['id_empresa'],
            'id_cargo' => $dadosForm['id_cargo']
        ]);

        return 1;
    }
}
