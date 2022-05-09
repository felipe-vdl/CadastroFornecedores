<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();


Route::get('/', 'CadastroController@index')->name('index');

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/entrar', 'AuthController@entrar');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('home/datatables', 'HomeController@dados');

Route::resource('/cadastro' , 'CadastroController');
Route::resource('/home' ,     'HomeController');


Route::post('upload', 'CadastroController@upload')->name('upload');

Route::get('/sucesso', 'CadastroController@sucesso');


Route::get 	('/alterasenha',			'FuncionarioController@AlteraSenha');
Route::post	('/salvasenha',   		'FuncionarioController@SalvarSenha');