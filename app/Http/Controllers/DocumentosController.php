<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use DB;
use App\Models\Funcionario;
use App\Models\Cadastro;
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

class DocumentosController extends Controller
{
    public function avaliar(Request $request)
    {   
        DB::beginTransaction();
        try {
            if (DocRequerimentoInscricao::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocRequerimentoInscricao::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocAtoConstitutivo::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocAtoConstitutivo::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocProcuracaoCarta::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocProcuracaoCarta::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocCedulaIdentidade::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocCedulaIdentidade::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocRegistroEntidade::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocRegistroEntidade::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocInscricaoCnpj::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocInscricaoCnpj::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocCadastroContribuinte::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocCadastroContribuinte::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocBalancoPatrimonial::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocBalancoPatrimonial::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocRegularidadeFiscal::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocRegularidadeFiscal::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocCreditoTributario::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocCreditoTributario::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocDebitoEstadual::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocDebitoEstadual::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocDebitoMunicipal::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocDebitoMunicipal::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocFalenciaConcordata::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocFalenciaConcordata::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocDebitoTrabalhista::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocDebitoTrabalhista::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            } else if (DocCapacidadeTecnica::where([ ['id', '=', $request->doc_id], ['filename', '=', $request->filename] ])->count() > 0) {
                $doc = DocCapacidadeTecnica::where([['id','=', $request->doc_id], ['filename','=', $request->filename]])->first();
            }

            if ($request->doc_justificativa) {
                $doc->justificativa = $request->doc_justificativa;
            }

            $doc->status = $request->doc_status;
            $doc->save();
            DB::commit();
            /* return redirect()->back()->with('success', 'Documento avaliado com sucesso.'); */
            return redirect()->to(URL::previous() . $request->ancora)->with('success', 'Documento avaliado com sucesso.');

        } catch (\Throwable $th) {            
            DB::rollback();
            return redirect()->back()->with('error', 'Houve um erro ao avaliar o documento, tente novamente.');
        }
    }

    public function solicitar(Request $request)
    {
        DB::beginTransaction();
        try {
            $categorias = DocCategoria::where([['cadastro_id', '=', $request->cadastro_id]])->first();

            if ($request->categoria == 'ato_constitutivo') {
                $categorias->status_ato_constitutivo = 2;
                $categorias->justificativa_ato_constitutivo = $request->justificativa;

            } else if ($request->categoria == 'balanco_patrimonial') {
                $categorias->status_balanco_patrimonial = 2;
                $categorias->justificativa_balanco_patrimonial = $request->justificativa;

            } else if ($request->categoria == 'capacidade_tecnica') {
                $categorias->status_capacidade_tecnica = 2;
                $categorias->justificativa_capacidade_tecnica = $request->justificativa;

            } else if ($request->categoria == 'cedula_identidade') {
                $categorias->status_cedula_identidade = 2;
                $categorias->justificativa_cedula_identidade = $request->justificativa;

            } else if ($request->categoria == 'credito_tributario') {
                $categorias->status_credito_tributario = 2;
                $categorias->justificativa_credito_tributario = $request->justificativa;

            } else if ($request->categoria == 'debito_estadual') {
                $categorias->status_debito_estadual = 2;
                $categorias->justificativa_debito_estadual = $request->justificativa;

            } else if ($request->categoria == 'debito_municipal') {
                $categorias->status_debito_municipal = 2;
                $categorias->justificativa_debito_municipal = $request->justificativa;

            } else if ($request->categoria == 'debito_trabalhista') {
                $categorias->status_debito_trabalhista = 2;
                $categorias->justificativa_debito_trabalhista = $request->justificativa;

            } else if ($request->categoria == 'falencia_concordata') {
                $categorias->status_falencia_concordata = 2;
                $categorias->justificativa_falencia_concordata = $request->justificativa;

            } else if ($request->categoria == 'inscricao_cnpj') {
                $categorias->status_inscricao_cnpj = 2;
                $categorias->justificativa_inscricao_cnpj = $request->justificativa;

            } else if ($request->categoria == 'cadastro_contribuinte') {
                $categorias->status_cadastro_contribuinte = 2;
                $categorias->justificativa_cadastro_contribuinte = $request->justificativa;

            } else if ($request->categoria == 'procuracao_carta') {
                $categorias->status_procuracao_carta = 2;
                $categorias->justificativa_procuracao_carta = $request->justificativa;

            } else if ($request->categoria == 'registro_entidade') {
                $categorias->status_registro_entidade = 2;
                $categorias->justificativa_registro_entidade = $request->justificativa;

            } else if ($request->categoria == 'regularidade_fiscal') {
                $categorias->status_regularidade_fiscal = 2;
                $categorias->justificativa_regularidade_fiscal = $request->justificativa;

            } else if ($request->categoria == 'requerimento_inscricao') {
                $categorias->status_requerimento_inscricao = 2;
                $categorias->justificativa_requerimento_inscricao = $request->justificativa;

            }

            $categorias->update();
            DB::commit();
            return redirect()->to(URL::previous() . $request->ancora)->with('success', 'Solicitação marcada com sucesso.');

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Houve um erro ao marcar a solicitação, tente novamente.');
        }
    }
}
