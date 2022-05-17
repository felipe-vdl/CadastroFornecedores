<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
   public function __construct(Funcionario $funcionario)
   	{
        $this->funcionario = $funcionario; 
        // todas as rotas aqui serão antes autenticadas
        //$this->middleware('auth');
    }
    
    public function index ()
    {
        $funcionarios = Funcionario::all();

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function edit ($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update (Request $request, $id)
    {
        $funcionario = Funcionario::findOrFail($id);
        
        $funcionario->name   = $request->name;
        $funcionario->email  = $request->email;
        $funcionario->nivel  = $request->nivel;
        
        if($request->resetarsenha == 1) {
            $funcionario->password = 'pmm12345';
        }

        $funcionario->update();

        return redirect('/usuarios')->with('sucesso_edicao_usuario', 'Usuário editado com sucesso.');
    }

	public function AlteraSenha()
   	{
      	$funcionario = Funcionario::find(Auth::user()->id);
    
      	return view('funcionarios.altera_senha',compact('funcionario'));
		}

	public function SalvarSenha(Request $request)
    {
        $this->validate($request, [
            'password_atual'        => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        // Obter o usuário
        $funcionario = Funcionario::find(Auth::user()->id);
        // obter a senha atual - será usada para gaurdar no log
        // $senha_atual = bcrypt($request->password_atual);
        if (Hash::check($request->password_atual, $funcionario->password))
        {  

           $funcionario->update(['password' => ($request->password)]);

            return redirect('/cadastros')->with('sucesso_alteracao_senha','Senha alterada com sucesso.');
        }else{
            return back()->withErrors('Senha atual não confere');
        }
    }
}