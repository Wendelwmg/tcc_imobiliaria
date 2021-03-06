<?php

namespace App\Http\Controllers\ImobWeb;

use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Funcionario;
use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Validation\Factory;

class FuncionarioController extends Controller
{
    private $request;
    private $funcionario;
    private $validator;

    public function __construct(Request $request, Funcionario $funcionario, Factory $validator)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->funcionario = $funcionario;
        $this->validator = $validator;
    }

    public function getIndex(){

        $titulo = 'ImobWeb - Funcionários';
        $empresaUserAtual = Auth::user()->id_empresa;
        $funcionarios = $this->funcionario->getFuncionario($empresaUserAtual);

        if(count($funcionarios) == 0){
            $tituloTabela = 'Resultados da Pesquisa: Nenhum registro encontrado!';
        }
                      
        return view('imobweb.funcionario.index', compact('titulo', 'funcionarios', 'tituloTabela'));
    }

    public function getCadastraFuncionario(){

        $titulo = 'ImobWeb - Cadastro de Funcionário';
        $cargos = Cargo::whereNotIn('id', [1])->get();
        $empresaUserAtual = Auth::user()->id_empresa;
        $users = $this->funcionario->getUser($empresaUserAtual);

        return view('imobweb.funcionario.cadastra-funcionario', compact('titulo', 'cargos', 'users'));
    }

    public function postCadastraFuncionario(){

        $dadosForm = $this->request->all();

        $valida_requiredPessoaF = $this->validator->make($dadosForm, Funcionario::$rules_requiredPessoaF);
        $valida_requiredPessoaJ = $this->validator->make($dadosForm, Funcionario::$rules_requiredPessoaJ);
        $valida_cnpj = $this->validator->make($dadosForm, Funcionario::$rules_cnpj);
        $valida_cpf = $this->validator->make($dadosForm, Funcionario::$rules_cpf);
        $valida_size = $this->validator->make($dadosForm, Funcionario::$rules_size);
        $valida_type = $this->validator->make($dadosForm, Funcionario::$rules_type);
        $valida_duplicatedCpfCnpj = $this->validator->make($dadosForm, Funcionario::$rules_duplicatedCpfCnpj);
        $valida_duplicatedRG = $this->validator->make($dadosForm, Funcionario::$rules_duplicatedRG);
        $valida_duplicatedUser = $this->validator->make($dadosForm, Funcionario::$rules_duplicatedUser);

        //válida os campos obrigatórios tipo pessoa fisíca
        if ($dadosForm["tipo_pessoa"] == "F"){
            if ($valida_requiredPessoaF->fails()) {
                $messages = $valida_requiredPessoaF->messages();

                if ($messages->all()) {
                    $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!");
                }

                return $displayErrors;
            }; 
        };        
        
        //válida os campos obrigatórios tipo pessoa jurídica
        if ($dadosForm["tipo_pessoa"] == "J"){
            if ($valida_requiredPessoaJ->fails()) {
                $messages = $valida_requiredPessoaJ->messages();

                if ($messages->all()) {
                    $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!");
                }

                return $displayErrors;
            }; 
        }; 

        //válida o cpf
        if ($dadosForm["tipo_pessoa"] == "F"){
            if ($valida_cpf->fails()) {
                $messages = $valida_cpf->messages();

                if ($messages->all()) {
                    $displayErrors = array("CPF inválido! Verifique.");
                }

                return $displayErrors;
            };
        };

        //válida o cnpj
        if ($dadosForm["tipo_pessoa"] == "J"){
            if ($valida_cnpj->fails()) {
                $messages = $valida_cnpj->messages();

                if ($messages->all()) {
                    $displayErrors = array("CNPJ inválido! Verifique.");
                }

                return $displayErrors;
            };
        };

        //válida a quantidade mínima de caracteres por campo
        if ($valida_size->fails()) {
            $messages = $valida_size->messages();

            $displayErrors = array();

            foreach ($messages->all(":message") as $error) {
                array_push($displayErrors, $error);
            }

            return $displayErrors;
        };

        //válida os tipos dos campos
        if ($valida_type->fails()) {
            $messages = $valida_type->messages();

            $displayErrors = array();

            foreach ($messages->all(":message") as $error) {
                array_push($displayErrors, $error);
            }

            return $displayErrors;
        };

        //válida os cpf ou cnpj duplicados
        if ($valida_duplicatedCpfCnpj->fails()) {
            $messages = $valida_duplicatedCpfCnpj->messages();

            if ($messages->all()) {
                $displayErrors = array("CPF ou CNPJ já cadastrado no sistema! Verifique.");
            }

            return $displayErrors;
        };

        //válida os rg duplicados
        if ($valida_duplicatedRG->fails()) {
            $messages = $valida_duplicatedRG->messages();

            if ($messages->all()) {
                $displayErrors = array("RG já cadastrado no sistema! Verifique.");
            }

            return $displayErrors;
        };

        //válida os usuários duplicados
        if ($valida_duplicatedUser->fails()) {
            $messages = $valida_duplicatedUser->messages();

            if ($messages->all()) {
                $displayErrors = array("Usuário vinculado a outro funcionário! Verifique.");
            }

            return $displayErrors;
        };      

        $this->funcionario->create($dadosForm);
        return 1;       
    }

    public function getEditaFuncionario($id){

        $funcionario = $this->funcionario->all()->find($id);
        $titulo = 'ImobWeb - Edição de Funcionário';
        $cargos = Cargo::whereNotIn('id', [1])->get();

        $empresaUserAtual = Auth::user()->id_empresa;
        $users = $this->funcionario->getUser($empresaUserAtual);

        return view('imobweb.funcionario.edita-funcionario', compact('titulo', 'cargos', 'funcionario', 'users'));
    }

    public function postEditaFuncionario($id){
        $funcionario = $this->funcionario->all()->find($id);
        $dadosForm = $this->request->all();

        $rules_duplicatedCpfCnpj = [
            'cpf_cnpj'          =>'unique:funcionarios,cpf_cnpj,'.$id
        ];

        $rules_duplicatedRG = [
            'rg'                =>'unique:funcionarios,rg,'.$id
        ];

        $rules_duplicatedUser = [
            'id_user'          =>'unique:funcionarios,id_user,'.$id
        ];

        $valida_requiredPessoaF = $this->validator->make($dadosForm, Funcionario::$rules_requiredPessoaF);
        $valida_requiredPessoaJ = $this->validator->make($dadosForm, Funcionario::$rules_requiredPessoaJ);
        $valida_cnpj = $this->validator->make($dadosForm, Funcionario::$rules_cnpj);
        $valida_cpf = $this->validator->make($dadosForm, Funcionario::$rules_cpf);
        $valida_size = $this->validator->make($dadosForm, Funcionario::$rules_size);
        $valida_type = $this->validator->make($dadosForm, Funcionario::$rules_type);
        $valida_duplicatedCpfCnpj = $this->validator->make($dadosForm, $rules_duplicatedCpfCnpj);
        $valida_duplicatedRG = $this->validator->make($dadosForm, $rules_duplicatedRG);
        $valida_duplicatedUser = $this->validator->make($dadosForm, $rules_duplicatedUser);

        //válida os campos obrigatórios tipo pessoa fisíca
        if ($dadosForm["tipo_pessoa"] == "F"){
            if ($valida_requiredPessoaF->fails()) {
                $messages = $valida_requiredPessoaF->messages();

                if ($messages->all()) {
                    $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!");
                }

                return $displayErrors;
            }; 
        };        
        
        //válida os campos obrigatórios tipo pessoa jurídica
        if ($dadosForm["tipo_pessoa"] == "J"){
            if ($valida_requiredPessoaJ->fails()) {
                $messages = $valida_requiredPessoaJ->messages();

                if ($messages->all()) {
                    $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!");
                }

                return $displayErrors;
            }; 
        }; 

        //válida o cpf
        if ($dadosForm["tipo_pessoa"] == "F"){
            if ($valida_cpf->fails()) {
                $messages = $valida_cpf->messages();

                if ($messages->all()) {
                    $displayErrors = array("CPF inválido! Verifique.");
                }

                return $displayErrors;
            };
        };

        //válida o cnpj
        if ($dadosForm["tipo_pessoa"] == "J"){
            if ($valida_cnpj->fails()) {
                $messages = $valida_cnpj->messages();

                if ($messages->all()) {
                    $displayErrors = array("CNPJ inválido! Verifique.");
                }

                return $displayErrors;
            };
        };

        //válida a quantidade mínima de caracteres por campo
        if ($valida_size->fails()) {
            $messages = $valida_size->messages();

            $displayErrors = array();

            foreach ($messages->all(":message") as $error) {
                array_push($displayErrors, $error);
            }

            return $displayErrors;
        };

        //válida os tipos dos campos
        if ($valida_type->fails()) {
            $messages = $valida_type->messages();

            $displayErrors = array();

            foreach ($messages->all(":message") as $error) {
                array_push($displayErrors, $error);
            }

            return $displayErrors;
        };

        //válida os cpf ou cnpj duplicados na atualização
        if ($valida_duplicatedCpfCnpj->fails()) {
            $messages = $valida_duplicatedCpfCnpj->messages();

            if ($messages->all()) {
                $displayErrors = array("CPF ou CNPJ já cadastrado no sistema! Verifique.");
            }

            return $displayErrors;
        };

        //válida os rg duplicados na atualização
        if ($valida_duplicatedRG->fails()) {
            $messages = $valida_duplicatedRG->messages();

            if ($messages->all()) {
                $displayErrors = array("RG já cadastrado no sistema! Verifique.");
            }

            return $displayErrors;
        };

        //válida os usuários duplicados na atualização
        if ($valida_duplicatedUser->fails()) {
            $messages = $valida_duplicatedUser->messages();

            if ($messages->all()) {
                $displayErrors = array("Usuário vinculado a outro funcionário! Verifique.");
            }

            return $displayErrors;
        };

        $funcionario->fill($dadosForm);
        $funcionario->save();

        return 1;           
    }

    public function getDemiteFuncionario($id){        

        $this->funcionario->find($id)->delete();        
        return 1;
    }

    public function postPesquisar(){
       $dadosForm = $this->request->all();
       $empresaUserAtual = Auth::user()->id_empresa;
       $funcionarios = $this->funcionario->getResultadoPesquisa($dadosForm, $empresaUserAtual);

       if(count($funcionarios) == 0){
            $tituloTabela = 'Nenhum registro encontrado!';
       }else{
            $tituloTabela = "Resultados da pesquisa:";
       }
        
        $titulo = 'ImobWeb - Funcionários';              
        return view('imobweb.funcionario.index', compact('titulo', 'funcionarios', 'tituloTabela'));
    }
}
