<?php

Route::get('/', 'CadastroController@create')->name('create');
Route::post('upload', 'CadastroController@upload')->name('upload');
Route::get('/sucesso', 'CadastroController@sucesso');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('home/datatables', 'HomeController@dados');

Route::resource('/cadastro' , 'CadastroController');
Route::resource('/home' ,     'HomeController');

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/entrar', 'AuthController@entrar');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/register', 'Auth\RegisterController@create')->name('register');

Route::get 	('/usuarios',			'FuncionarioController@index');
Route::get 	('/usuarios/{id}/edit',			'FuncionarioController@edit');
Route::post ('/usuarios/{id}/update',			'FuncionarioController@update');

Route::get 	('/alterasenha',			'FuncionarioController@AlteraSenha');
Route::post	('/salvasenha',   		'FuncionarioController@SalvarSenha');