<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\RequerimentoInscricao;
use DB;
use Illuminate\Support\Facades\Storage;

class CadastroController extends Controller
{
    public function index()
    {
        /* $passw = bcrypt('pmm12345');
        dd($passw); */
        return view('user.index');
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
            foreach ($request->requerimento_inscricao as $requerimento) {
                $filename = $requerimento->store('public/documentos');
                array_push($documentosEnviados, substr($filename, 18));
                RequerimentoInscricao::create([
                    'cadastro_id' => $cadastro->id,
                    'filename' => substr($filename, 18),
                    'extensao' => $requerimento->extension()
                ]);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            // Deletar arquivos.
            foreach($documentosEnviados as $documento) {
                unlink(storage_path('app/public/documentos/'.$documento));
            }
        }

        DB::commit();
        return redirect()->action('CadastroController@sucesso');
    }

    public function sucesso()
    {
        return view('user.sucesso');
    }

}