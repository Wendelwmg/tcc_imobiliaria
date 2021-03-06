<?php

namespace App\Http\Controllers\ImobWeb;

use App\Models\Empresa;
use App\Models\Imovel;
use App\Models\TipoImovel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Factory;
use Auth;
use DB;

class ImovelController extends Controller
{
    private $request;
    private $imovel;
    private $validator;

    public function __construct(Request $request, Imovel $imovel, Factory $validator)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->imovel = $imovel;
        $this->validator = $validator;
    }

    public function getIndex(){
        $titulo = 'ImobWeb - Imoveis';
        $empresaUserAtual = Auth::user()->id_empresa;
        $imoveis = $this->imovel->getImovel($empresaUserAtual);
        $tiposImoveis = TipoImovel::orderBy('descricao')->get();

        if(count($imoveis) == 0){
            $tituloTabela = 'Resultados da Pesquisa: Nenhum registro encontrado!';
        }

        return view('imobweb.imovel.index', compact('titulo', 'imoveis', 'tituloTabela', 'tiposImoveis'));
    }

    public function getCadastraImovel(){
        $titulo = 'ImobWeb - Cadastro de Imóvel';
        $tiposImoveis = TipoImovel::orderBy('descricao')->get();
        $empresaUserAtual = Auth::user()->id_empresa;
        $vendedores = $this->imovel->getVendedor($empresaUserAtual);
        return view('imobweb.imovel.cadastra-imovel', compact('titulo', 'tiposImoveis', 'vendedores'));
    }

    public function postCadastraImovel(){
        $dadosForm = $this->request->all();

        $valida_required = $this->validator->make($dadosForm, Imovel::$rules_required);
        $valida_cnpj = $this->validator->make($dadosForm, Imovel::$rules_cnpj);
        $valida_cpf = $this->validator->make($dadosForm, Imovel::$rules_cpf);
        $valida_size = $this->validator->make($dadosForm, Imovel::$rules_size);
        $valida_type = $this->validator->make($dadosForm, Imovel::$rules_type);
        $valida_duplicatedCode = $this->validator->make($dadosForm, Imovel::$rules_duplicatedCode);


        //valida os campos obrigatórios
        if ($valida_required->fails()) {
            $messages = $valida_required->messages();

            if ($messages->all()) {
                $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!");
            }

            return $displayErrors;
        };

        //válida o cpf
        if (strlen($dadosForm["cpf_cnpj"]) == 11){
            if ($valida_cpf->fails()) {
                $messages = $valida_cpf->messages();

                if ($messages->all()) {
                    $displayErrors = array("CPF inválido! Verifique.");
                }

                return $displayErrors;
            };
        };

        //válida o cnpj
        if (strlen($dadosForm["cpf_cnpj"]) == 14){
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

        //válida os código duplicado
        if ($valida_duplicatedCode->fails()) {
            $messages = $valida_duplicatedCode->messages();

            if ($messages->all()) {
                $displayErrors = array("Código já cadastrado no sistema! Verifique.");
            }

            return $displayErrors;
        };

        $this->imovel->create($dadosForm);
        return 1;
    }

    public function getEditaImovel($id){
        $imovel = $this->imovel->all()->find($id);
        $titulo = 'ImobWeb - Edição de Imóvel';
        $tiposImoveis = TipoImovel::orderBy('descricao')->get();

        $empresaUserAtual = Auth::user()->id_empresa;
        $vendedores = $this->imovel->getVendedor($empresaUserAtual);

        return view('imobweb.imovel.edita-imovel', compact('titulo', 'imovel', 'tiposImoveis', 'vendedores'));
    }

    public function postEditaImovel($id){
        $imovel = $this->imovel->all()->find($id);
        $dadosForm = $this->request->all();

        $rules_duplicatedCode = [
            'codigo'          =>'unique:imoveis,codigo,'.$id
        ];

        $valida_required = $this->validator->make($dadosForm, Imovel::$rules_required);
        $valida_cnpj = $this->validator->make($dadosForm, Imovel::$rules_cnpj);
        $valida_cpf = $this->validator->make($dadosForm, Imovel::$rules_cpf);
        $valida_size = $this->validator->make($dadosForm, Imovel::$rules_size);
        $valida_type = $this->validator->make($dadosForm, Imovel::$rules_type);
        $valida_duplicatedCode = $this->validator->make($dadosForm, $rules_duplicatedCode);


        //valida os campos obrigatórios
        if ($valida_required->fails()) {
            $messages = $valida_required->messages();

            if ($messages->all()) {
                $displayErrors = array("É necessário informar todos os campos com ' * ' para prosseguir!");
            }

            return $displayErrors;
        };

        //válida o cpf
        if (strlen($dadosForm["cpf_cnpj"]) == 11){
            if ($valida_cpf->fails()) {
                $messages = $valida_cpf->messages();

                if ($messages->all()) {
                    $displayErrors = array("CPF inválido! Verifique.");
                }

                return $displayErrors;
            };
        };

        //válida o cnpj
        if (strlen($dadosForm["cpf_cnpj"]) == 14){
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

        //válida os código duplicado na atualização
        if ($valida_duplicatedCode->fails()) {
            $messages = $valida_duplicatedCode->messages();

            if ($messages->all()) {
                $displayErrors = array("Código já cadastrado no sistema! Verifique.");
            }

            return $displayErrors;
        };

        $imovel->fill($dadosForm);
        $imovel->save();

        return 1;
    }

    public function getDeletaImovel($id){
        $this->imovel->find($id)->delete();
        return 1;
    }

    public function postPesquisar(){
        $dadosForm = $this->request->all();
        $empresaUserAtual = Auth::user()->id_empresa;
        $imoveis = $this->imovel->getResultadoPesquisa($dadosForm, $empresaUserAtual);
        $tiposImoveis = TipoImovel::orderBy('descricao')->get();

        if(count($imoveis) == 0){
            $tituloTabela = 'Nenhum registro encontrado!';
        }else{
            $tituloTabela = 'Resultados da Pesquisa:';
        }

        $titulo = 'ImobWeb - Imoveis';
        return view('imobweb.imovel.index', compact('titulo', 'imoveis', 'tituloTabela', 'tiposImoveis'));
    }

    public function getUploadImagem($id){

        $dadosImovel = $this->imovel->all()->find($id);
        $imovel = $this->imovel->with('imagens')->find($id);


        $empresaUserAtual = Auth::user()->id_empresa;
        $imobiliaria = Empresa::all()->find($empresaUserAtual);


        $titulo = 'ImobWeb - Cadastro de Imagem';
        return view('imobweb.imovel.upload-imagem', compact('titulo', 'dadosImovel', 'imovel', 'imobiliaria'));
    }

    public function postUploadImagem(){
        /**
         * Recebendo imagem do formulário
         */
        $item = \Request::file('imagem');
        $nomeImobiliaria = \Request::get('nomeImobiliaria');
        $idImovel = \Request::get('idImovel');
        $codigoImovel = \Request::get('codigoImovel');

        /**
         * Criando local de armazenamento da imagem
         */
        $storagePath = public_path().'/documentos/'.$nomeImobiliaria.'/imagens/'."imóvel - $codigoImovel";
        $itemName = $item->getClientOriginalName();

        /**
         * Salvando imagens no banco com relacionamento a imóvel
         */
        $itemModel = new \App\Models\ItemImovel();
        $itemModel->titulo = $itemName;
        $itemModel->caminho = public_path().'/documentos/'.$nomeImobiliaria.'/imagens/'."imóvel - $codigoImovel";

        $imovel = \App\Models\Imovel::find($idImovel);
        $imovel->imagens()->save($itemModel);

        return $item->move($storagePath, $itemName);
    }

    public function getDownloadImagem($idItem, $codigoImovel){
        $empresaUserAtual = Auth::user()->id_empresa;
        $imobiliaria = Empresa::all()->find($empresaUserAtual);

        $item = \App\Models\ItemImovel::find($idItem);
        $storagePath = public_path().'/documentos/'.$imobiliaria->razao_social.'/imagens/'."imóvel - $codigoImovel";

        return \Response::download($storagePath.'/'.$item->titulo);
    }

    public function getDeletaImagem($idItem, $codigoImovel){
        $empresaUserAtual = Auth::user()->id_empresa;
        $imobiliaria = Empresa::all()->find($empresaUserAtual);

        $item = \App\Models\ItemImovel::find($idItem);
        $storagePath = public_path().'/documentos/'.$imobiliaria->razao_social.'/imagens/'."imóvel - $codigoImovel";

        $item->delete();
        unlink($storagePath.'/'.$item->titulo);

        return redirect()->back();
    }

    public function getVisualizaImagem($idItem, $codigoImovel){
        $empresaUserAtual = Auth::user()->id_empresa;
        $imobiliaria = Empresa::all()->find($empresaUserAtual);

        $item = \App\Models\ItemImovel::find($idItem);

        return view('imobweb.imovel.visualiza-imagem', compact('imobiliaria', 'item', 'codigoImovel'));
    }

}
