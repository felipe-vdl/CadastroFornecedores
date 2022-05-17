<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\Models\Cadastro;
use DB;
use Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Carbon\Carbon;
use App\Models\DocRequerimentoInscricao;
use App\Models\DocAtoConstitutivo;
use App\Models\DocProcuracaoCarta;
use App\Models\DocCedulaIdentidade;
use App\Models\DocRegistroEntidade;
use App\Models\DocInscricaoCnpj;
use App\Models\DocBalancoPatrimonial;
use App\Models\DocRegularidadeFiscal;
use App\Models\DocCreditoTributario;
use App\Models\DocDebitoEstadual;
use App\Models\DocDebitoMunicipal;
use App\Models\DocFalenciaConcordata;
use App\Models\DocDebitoTrabalhista;
use App\Models\DocCapacidadeTecnica;

class CadastroController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $cadastros = Cadastro::all();
        return view('cadastro.index', compact('cadastros'));
    }

    public function create()
    {
        return view('cadastro.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Dados do Formulário
                $this->validate($request,[
                    'razao_social' => 'required',
                    'cnpj' => 'required',
                    'porte_empresa' => 'required',
                    'cnae' => 'nullable',
                    'produtos' => 'required',
                    'endereco' => 'required',
                    'email' => 'required',
                    'telefone' => 'required'
                ]);
                $cadastro = new Cadastro($request->all());

            // Chave Secreta
                $data_atual = Carbon::now('America/Sao_Paulo')->format('dis');
                $nova_chave = substr($request->cnpj,0,2).rand(100,999).$data_atual.substr($request->cnpj,-2);
            // Prevenir repetição da chave secreta.
                $chave_existe = Cadastro::where('chave','=',$nova_chave)->get();
                while (!$chave_existe->isEmpty()) {
                    $data_atual = Carbon::now('America/Sao_Paulo')->format('dis');
                    $nova_chave = substr($request->cnpj,0,2).rand(100,999).$data_atual.substr($request->cnpj,-2);
                    $chave_existe = RequerimentoPericia::where('chave','=',$nova_chave)->get();
                }
                $cadastro->chave    = $nova_chave;

            // Status: Em análise.
                $cadastro->status   = 0;

                $cadastro->save();

            // Documentos Necessários:
                $documentosEnviados = [];
                // 1) Requerimento de Inscrição
                foreach ($request->requerimento_inscricao as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocRequerimentoInscricao::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 2) Ato Constitutivo
                foreach ($request->ato_constitutivo as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocAtoConstitutivo::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 3) Procuração ou Carta de Credenciamento
                foreach ($request->procuracao_carta as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocProcuracaoCarta::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 4) Cédula de Identidade (RG) e CPF dos Representantes Legais
                foreach ($request->cedula_identidade as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocCedulaIdentidade::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 5) Registro Entidade
                foreach ($request->registro_entidade as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocRegistroEntidade::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 6) Inscrição Cnpj
                foreach ($request->inscricao_cnpj as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocInscricaoCnpj::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 7) Balanço Patrimonial
                foreach ($request->balanco_patrimonial as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocBalancoPatrimonial::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 8) Regularidade Fiscal
                foreach ($request->regularidade_fiscal as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocRegularidadeFiscal::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

                // 9) Crédito Tributário
                foreach ($request->credito_tributario as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocCreditoTributario::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

                // 10) Débito Estadual
                foreach ($request->debito_estadual as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocDebitoEstadual::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

                // 11) Débito Municipal
                foreach ($request->debito_municipal as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocDebitoMunicipal::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

                // 12) Falência Concordata
                foreach ($request->falencia_concordata as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocFalenciaConcordata::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

                // 13) Débito Trabalhista
                foreach ($request->debito_trabalhista as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocDebitoTrabalhista::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

                // 14) Capacidade Técnica
                foreach ($request->capacidade_tecnica as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocCapacidadeTecnica::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }

            // Envio de E-mail:
                try {
                    $mail = env('MAIL_FROM_ADDRESS', '');

                    Mail::send('mail.novo', ['cadastro' => $cadastro], function($m) use ($cadastro, $mail) {
                        $m->from($mail, 'Cadastro de Fornecedores');
                        $m->subject('Novo Cadastro');
                        $m->to($cadastro->email);
                    });

                    $cadastro->envio_create = 1;

                } catch (\Throwable $th) {
                    $cadastro->envio_create = 0;
                }

            $cadastro->update();
            DB::commit();
            return redirect()->route('cadastros.sucesso', ['chave' => $cadastro->chave]);

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            // Deletar arquivos.
            foreach($documentosEnviados as $documento) {
                unlink(storage_path('app/public/documentos/'.$documento));
            }

            return redirect('/')->with('error', 'Houve um erro ao criar o cadastro, tente novamente.');
        }
    }

    /* Tela de Sucesso após cadastro. */
    public function sucesso ($chave) {
        $cadastro = Cadastro::where('chave', '=', $chave)->first();
        return view('cadastro.sucesso', compact('cadastro'));
    }
    
    public function show(Request $request, $id)
    { 
    
        $cadastro = Cadastro::with('doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($id);
        return view ('cadastro.show',compact('cadastro'));
    }

    public function edit(Request $request, $id)
    { 
        $cadastro = Cadastro::with('doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($id);
        return view ('cadastro.edit',compact('cadastro'));
    }

    /* TODO: Avaliação */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $cadastro = Cadastro::with('doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($id);
            
            /* Status 3: Cadastro Inválido */
            if($request->direcionamento == 3) {
                $cadastro->status         = $request->direcionamento;
                $cadastro->justificativa  = $request->justificativa;
            } else {
                /* Status 2: Presença de documento indeferido */
                if (DocRequerimentoInscricao::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocAtoConstitutivo::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocProcuracaoCarta::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocCedulaIdentidade::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocRegistroEntidade::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocInscricaoCnpj::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocBalancoPatrimonial::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocRegularidadeFiscal::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocCreditoTributario::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocDebitoEstadual::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocDebitoMunicipal::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocFalenciaConcordata::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocDebitoTrabalhista::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    $cadastro->status = 2;
                } else if (DocCapacidadeTecnica::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->orWhere([['cadastro_id','=',$cadastro->id],['status','=',0]])->count() > 0) {
                    
                } else {
                    /* Status 1: Cadastro Válido com documentos deferidos. */
                    $cadastro->status   = $request->direcionamento;
                }
            }

            $cadastro->update();

            DB::commit();
            return redirect('/cadastros')->with('success', 'Cadastro avaliado com sucesso.');

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return back()->with('error', 'Houve um erro ao tentar avaliar o cadastro, tente novamente.');
        }
    }

    public function consultar()
    { 
        return view ('cadastro.consultar');
    }

    public function visualizacao(Request $request)
    {
        if (Cadastro::where('chave', '=', $request->chave)->count() === 0) {
            return redirect('/confirmar')->with('error', 'Certifique-se de que a chave inserida esteja correta.');
        }

        $query = Cadastro::where('chave', $request->chave)->get();
        $cadastro = Cadastro::with('doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($query[0]->id);
        return view ('cadastro.visualizacao',compact('cadastro'));
    }

    /* TODO: Reenvio de Arquivos Indeferidos */
    public function corrigir(Request $request, $id)
    {
        
    }

}