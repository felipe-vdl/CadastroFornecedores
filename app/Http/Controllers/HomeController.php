<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\Arquivo;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('cadastro.home');
    }

    public function show(Request $request, $id)
    { 
    
        $dados = Cadastro::with('doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($id);
        return view ('cadastro.show',compact('dados'));
    }

    public function dados()
    {
        $arr = Cadastro::all();
        //dd($arr);
        $colecao = collect();

        foreach($arr as $dados)
        {
            $acoes = "";

            $acoes .= "<td style='width: 16%;'>
                        <a  href='".url("/home/$dados->id")."' 
                            class='btn btn-info btn-sm'
                            title='Detalhar cadastro.'>
                            <i class='material-icons'>search</i>
                        </a>
                    </td>";

                $colecao->push([
                    'razao_social' => $dados->razao_social ,
                    'cnpj' => $dados->cnpj ,
                    'produtos' => $dados->produtos,
                    'porte_empresa' => $dados->porte_empresa ,
                    'acoes' => $acoes
                ]);
        }
        return DataTables::of($colecao)
                ->rawColumns(['acoes'])
                ->make(true);
    }
    
}
