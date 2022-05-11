<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use App\Models\Cadastro;
use DB;
use Illuminate\Support\Facades\Storage;
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
    public function create()
    {
        return view('cadastro.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Formulário de Cadastro
            $this->validate($request,[
                'razao_social' => 'required',
                'cnpj' => 'required',
                'porte_empresa' => 'required',
                'cnae' => 'nullable',
                'produtos' => 'required',
                'endereco' => 'required',
                'email' => 'required',
                'telefone' => 'required',
            ]);
            $cadastro = new Cadastro($request->all());
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
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 2) Ato Constitutivo
            foreach ($request->ato_constitutivo as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocAtoConstitutivo::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 3) Procuração ou Carta de Credenciamento
            foreach ($request->procuracao_carta as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocProcuracaoCarta::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 4) Cédula de Identidade (RG) e CPF dos Representantes Legais
            foreach ($request->cedula_identidade as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocCedulaIdentidade::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 5) Registro Entidade
            foreach ($request->registro_entidade as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocRegistroEntidade::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 6) Inscrição Cnpj
            foreach ($request->inscricao_cnpj as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocInscricaoCnpj::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 7) Balanço Patrimonial
            foreach ($request->balanco_patrimonial as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocBalancoPatrimonial::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }
            // 8) Regularidade Fiscal
            foreach ($request->regularidade_fiscal as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocRegularidadeFiscal::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            // 9) Crédito Tributário
            foreach ($request->credito_tributario as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocCreditoTributario::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            // 10) Débito Estadual
            foreach ($request->debito_estadual as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocDebitoEstadual::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            // 11) Débito Municipal
            foreach ($request->debito_municipal as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocDebitoMunicipal::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            // 12) Falência Concordata
            foreach ($request->falencia_concordata as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocFalenciaConcordata::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            // 13) Débito Trabalhista
            foreach ($request->debito_trabalhista as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocDebitoTrabalhista::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            // 14) Capacidade Técnica
            foreach ($request->capacidade_tecnica as $arquivo) {
                $filename = $arquivo->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                DocCapacidadeTecnica::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $arquivo->extension()
                ]);
            }

            DB::commit();
            return redirect()->action('CadastroController@sucesso');

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

    public function sucesso()
    {
        return view('cadastro.sucesso');
    }

}
