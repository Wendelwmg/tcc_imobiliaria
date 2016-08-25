<?php

namespace App\Http\Controllers\ImobWeb;

use App\Models\Empresa;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Plano;

class ImobiliariaController extends Controller
{
    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->middleware('auth');
        $this->empresa = $empresa;
    }

    public function getIndex(){

        $user = Auth::user()->id_empresa;

        $imobiliaria = $this->empresa->all()->find($user);

        $plano = Plano::all()->find($imobiliaria->id_plano);

        $titulo = 'ImobWeb - Imobiliaria';

        return view('imobweb.imobiliaria', compact('titulo', 'imobiliaria', 'plano'));
    }

}
