<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Funcionario;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function entrar(Request $request)
    {
        $credentials = ['email'=>$request->email,'password'=>$request->password];
        
        if(Auth::attempt($credentials)){
            $usuario_logado = Auth::user();
            return redirect()->intended('home');
        } else {
            return redirect()->back()->with('msg','Acesso Negado, Email ou senha invalida');
        }
    }
}
