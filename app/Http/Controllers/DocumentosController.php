<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Cadastro;
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
            return redirect()->back()->with('success', 'Documento avaliado com sucesso.');

        } catch (\Throwable $th) {
            dd($th);
            
            DB::rollback();
            return redirect()->back()->with('error', 'Houve um erro ao avaliar o documento, tente novamente.');
        }
    }
}
