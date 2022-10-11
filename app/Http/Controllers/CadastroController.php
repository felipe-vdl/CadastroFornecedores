<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\Models\Cadastro;
use Auth;
use DB;
use PDF;
use Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Carbon\Carbon;
use App\Models\Funcionario;
use App\Models\DocRequerimentoInscricao;
use App\Models\DocAtoConstitutivo;
use App\Models\DocProcuracaoCarta;
use App\Models\DocCedulaIdentidade;
use App\Models\DocRegistroEntidade;
use App\Models\DocInscricaoCnpj;
use App\Models\DocCadastroContribuinte;
use App\Models\DocBalancoPatrimonial;
use App\Models\DocRegularidadeFiscal;
use App\Models\DocCreditoTributario;
use App\Models\DocDebitoEstadual;
use App\Models\DocDebitoMunicipal;
use App\Models\DocFalenciaConcordata;
use App\Models\DocDebitoTrabalhista;
use App\Models\DocCapacidadeTecnica;
use App\Models\DocCategoria;

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
                    'inscricao_municipal' => 'nullable',
                    'inscricao_estadual' => 'nullable',
                    'produtos' => 'required',
                    'cep' => 'required',
                    'rua' => 'required',
                    'numero_rua' => 'required',
                    'bairro' => 'required',
                    'municipio' => 'required',
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
                $cadastro->dados   = 0;

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
                // 7) CadastroContribuinte
                foreach ($request->cadastro_contribuinte as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocCadastroContribuinte::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                // 8) Balanço Patrimonial
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
                // 9) Regularidade Fiscal
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
                // 10) Crédito Tributário
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
                // 11) Débito Estadual
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

                // 12) Débito Municipal
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

                // 13) Falência Concordata
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

                // 14) Débito Trabalhista
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

                // 15) Capacidade Técnica
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
            
            // Status/Justificativas de cada categoria de documento:
                $categorias = DocCategoria::create([
                    'cadastro_id' => $cadastro->id
                ]);

            $cadastro->update();
            DB::commit();
            return redirect()->route('cadastros.sucesso', ['chave' => $cadastro->chave]);

        } catch (\Throwable $th) {
            DB::rollback();
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
    
        $cadastro = Cadastro::with('funcionario', 'doc_categorias', 'doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_cadastrocontribuinte', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($id);
        return view ('cadastro.show',compact('cadastro'));
    }

    public function edit(Request $request, $id)
    { 
        $cadastro = Cadastro::with('funcionario', 'doc_categorias', 'doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_cadastrocontribuinte', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($id);
        
        return view ('cadastro.edit',compact('cadastro'));
    }

    /* TODO: Avaliação */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $cadastro = Cadastro::find($id);
            $categorias = DocCategoria::where('cadastro_id', '=', $id)->first();
            $data_atual = Carbon::now('America/Sao_Paulo')->format('Y-m-d H:i:s');

            $cadastro->dados          = $request->dados;
            /* Status 3: Cadastro Inválido */
            if($cadastro->dados == 3) {
                $cadastro->status         = 3;
                $cadastro->justificativa  = $request->justificativa;
            } else {
                /* Status 2: Presença de documento indeferido */
                if (DocRequerimentoInscricao::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_requerimento_inscricao = 2;
                }

                if (DocAtoConstitutivo::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_ato_constitutivo = 2;
                }

                if (DocProcuracaoCarta::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_procuracao_carta = 2;
                }

                if (DocCedulaIdentidade::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_cedula_identidade = 2;
                }

                if (DocRegistroEntidade::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_registro_entidade = 2;
                }

                if (DocInscricaoCnpj::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_inscricao_cnpj = 2;
                }

                if (DocCadastroContribuinte::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_cadastro_contribuinte = 2;
                }

                if (DocBalancoPatrimonial::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_balanco_patrimonial = 2;
                }

                if (DocRegularidadeFiscal::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_regularidade_fiscal = 2;
                }

                if (DocCreditoTributario::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_credito_tributario = 2;
                }

                if (DocDebitoEstadual::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_debito_estadual = 2;
                }

                if (DocDebitoMunicipal::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_debito_municipal = 2;
                }

                if (DocFalenciaConcordata::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_falencia_concordata = 2;
                }

                if (DocDebitoTrabalhista::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_debito_trabalhista = 2;
                }

                if (DocCapacidadeTecnica::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 2] ])->count() > 0) {
                    $categorias->status_capacidade_tecnica = 2;
                }
                
                if (
                    $categorias->status_ato_constitutivo == 2
                    OR $categorias->status_balanco_patrimonial == 2
                    OR $categorias->status_capacidade_tecnica == 2
                    OR $categorias->status_cedula_identidade == 2
                    OR $categorias->status_credito_tributario == 2
                    OR $categorias->status_debito_estadual == 2
                    OR $categorias->status_debito_municipal == 2
                    OR $categorias->status_debito_trabalhista == 2
                    OR $categorias->status_falencia_concordata == 2
                    OR $categorias->status_inscricao_cnpj == 2
                    OR $categorias->status_cadastro_contribuinte == 2
                    OR $categorias->status_procuracao_carta == 2
                    OR $categorias->status_registro_entidade == 2
                    OR $categorias->status_regularidade_fiscal == 2
                    OR $categorias->status_requerimento_inscricao == 2
                ) {
                    $cadastro->status = 2;
                } else if (
                    DocRequerimentoInscricao::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocAtoConstitutivo::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocProcuracaoCarta::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocCedulaIdentidade::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocRegistroEntidade::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocInscricaoCnpj::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocCadastroContribuinte::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocBalancoPatrimonial::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocRegularidadeFiscal::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocCreditoTributario::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocDebitoEstadual::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocDebitoMunicipal::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocFalenciaConcordata::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocDebitoTrabalhista::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                    OR DocCapacidadeTecnica::where([ ['cadastro_id', '=', $cadastro->id], ['status', '=', 0] ])->count() > 0
                ) {
                    $cadastro->status = 0;
                } else {
                    /* Status 1: Cadastro Válido com documentos deferidos. */
                    $cadastro->status   = 1;
                    $cadastro->data_certificado = $data_atual;
                    $cadastro->validade_certificado = Carbon::now('America/Sao_Paulo')->addDays(90)->format('Y-m-d H:i:s');
                }
            }

            // Envio de E-mail:
            if ($cadastro->status != 0) {
                try {
                    $mail = env('MAIL_FROM_ADDRESS', '');
                    $emailView = null;
                    $emailSubject = null;

                    if($cadastro->status == 1) {
                        $emailView = 'mail.valido';
                        $emailSubject = 'Cadastro aprovado';

                    } else if ($cadastro->status == 2) {
                        $emailView = 'mail.aguardando';
                        $emailSubject = 'Aguardando envio de documentos';

                    } else if ($cadastro->status == 3) {
                        $emailView = 'mail.invalido';
                        $emailSubject = 'Cadastro invalidado';
                    }

                    Mail::send($emailView, ['cadastro' => $cadastro], function($m) use ($cadastro, $mail, $emailSubject) {
                        $m->from($mail, 'Cadastro de Fornecedores');
                        $m->subject($emailSubject);
                        $m->to($cadastro->email);
                    });

                    $cadastro->envio_avaliacao = 1;

                } catch (\Throwable $th) {
                    $cadastro->envio_avaliacao = 0;
                }
            }

            $cadastro->avaliador_id = Auth::user()->id;
            $cadastro->data_avaliacao = $data_atual;
            
            /* TODO: Enviar E-mail informando a atualização da avaliação do cadastro. */
            $categorias->update();
            $cadastro->update();
            DB::commit();
            return redirect('/cadastros')->with('success', 'Cadastro avaliado com sucesso.');

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Houve um erro ao tentar avaliar o cadastro, tente novamente.');
        }
    }

    public function consultar()
    { 
        return view ('cadastro.consultar');
    }

    public function visualizacao(Request $request)
    {
        if (Cadastro::where('chave', '=', $request->chave)->count() < 1) {
            return back()->with('error', 'Certifique-se de que a chave inserida esteja correta.');
        }

        $query = Cadastro::where('chave', $request->chave)->get();
        $cadastro = Cadastro::with('doc_categorias', 'doc_requerimentoinscricao', 'doc_atoconstitutivo', 'doc_procuracaocarta', 'doc_registroentidade', 'doc_inscricaocnpj', 'doc_cadastrocontribuinte', 'doc_balancopatrimonial', 'doc_regularidadefiscal', 'doc_creditotributario', 'doc_debitoestadual', 'doc_debitomunicipal', 'doc_falenciaconcordata', 'doc_debitotrabalhista', 'doc_capacidadetecnica')->find($query[0]->id);
        return view ('cadastro.visualizacao',compact('cadastro'));
    }

    /* TODO: Reenvio de Arquivos Indeferidos */
    public function corrigir(Request $request)
    {
        DB::beginTransaction();
        try {
            $cadastro = Cadastro::where('id', '=', $request->id)->first();
            $categorias = DocCategoria::where('cadastro_id', '=', $cadastro->id)->first();

            // Array de Controle:
            $documentosEnviados = [];

            // 1) Requerimento de Inscrição
            if (isset($request->requerimento_inscricao)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocRequerimentoInscricao::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 2) Ato Constitutivo
            if (isset($request->ato_constitutivo)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocAtoConstitutivo::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 3) Procuração ou Carta de Credenciamento
            if (isset($request->procuracao_carta)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocProcuracaoCarta::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 4) Cédula de Identidade (RG) e CPF dos Representantes Legais
            if (isset($request->cedula_identidade)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocCedulaIdentidade::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 5) Registro Entidade
            if (isset($request->registro_entidade)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocRegistroEntidade::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 6) Inscrição Cnpj
            if (isset($request->inscricao_cnpj)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocInscricaoCnpj::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }

            // 7) CadastroContribuinte
            if (isset($request->cadastro_contribuinte)) {
                foreach ($request->cadastro_contribuinte as $arquivo) {
                    $filename = $arquivo->store('public/documentos');
                    array_push($documentosEnviados, substr($filename, 18));
                    DocCadastroContribuinte::create([
                        'cadastro_id' => $cadastro->id,
                        'filename' => substr($filename, 18),
                        'extensao' => $arquivo->extension(),
                        'status' => 0
                    ]);
                }
                /* Deletar indeferidos */
                $docs_indeferidos = DocCadastroContribuinte::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 8) Balanço Patrimonial
            if (isset($request->balanco_patrimonial)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocBalancoPatrimonial::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            
            // 9) Regularidade Fiscal
            if (isset($request->regularidade_fiscal)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocRegularidadeFiscal::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            

            // 10) Crédito Tributário
            if (isset($request->credito_tributario)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocCreditoTributario::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            

            // 11) Débito Estadual
            if (isset($request->debito_estadual)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocDebitoEstadual::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            

            // 12) Débito Municipal
            if (isset($request->debito_municipal)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocDebitoMunicipal::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            

            // 13) Falência Concordata
            if (isset($request->falencia_concordata)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocFalenciaConcordata::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            

            // 14) Débito Trabalhista
            if (isset($request->debito_trabalhista)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocDebitoTrabalhista::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }
            

            // 15) Capacidade Técnica
            if (isset($request->capacidade_tecnica)) {
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
                /* Deletar indeferidos */
                $docs_indeferidos = DocCapacidadeTecnica::where([['cadastro_id','=',$request->id], ['status', '=', 2]])->get();
                foreach ($docs_indeferidos as $doc) {
                    unlink(storage_path('app/public/documentos/'.$doc->filename));
                    $doc->delete();
                }
            }

            $categorias->status_ato_constitutivo = 0;
            $categorias->status_balanco_patrimonial = 0;
            $categorias->status_capacidade_tecnica = 0;
            $categorias->status_cedula_identidade = 0;
            $categorias->status_credito_tributario = 0;
            $categorias->status_debito_estadual = 0;
            $categorias->status_debito_municipal = 0;
            $categorias->status_debito_trabalhista = 0;
            $categorias->status_falencia_concordata = 0;
            $categorias->status_inscricao_cnpj = 0;
            $categorias->status_cadastro_contribuinte = 0;
            $categorias->status_procuracao_carta = 0;
            $categorias->status_registro_entidade = 0;
            $categorias->status_regularidade_fiscal = 0;
            $categorias->status_requerimento_inscricao = 0;
            $categorias->update();

            $cadastro->status = 0;
            $cadastro->update();
            DB::commit();
            return back()->with('success', 'Cadastro atualizado com sucesso.');

        } catch (\Throwable $th) {
            dd($th);
            foreach($documentosEnviados as $documento) {
                unlink(storage_path('app/public/documentos/'.$documento));
            }
            
            DB::rollback();
            return back()->with('error', 'Houve um erro ao atualizar o cadastro.');
        }
    }

    public function certificado(Request $request) {
        $cadastro = Cadastro::where([['id', '=', $request->cadastro_id], ['chave', '=', $request->chave]])->first();
        $pdf = PDF::loadView('pdf.certificado', compact('cadastro'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}