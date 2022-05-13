@extends('layouts.app')

@section('content')
   <div class="container">
    <div class="card">
      <div class="card-header">
        <h4 class="align-middle mb-0">Cadastro realizado com sucesso</h4>
      </div>
      <div class="card-body">
        <p>Os dados da sua empresa agora constam na base de dados da prefeitura.</p>
        <p>O cadastro será analisado pelo nosso departamento, aguarde a resposta por e-mail, poderá se dar em até X horas úteis.</p>
        <p class="mb-0">Você pode consultar o processo do cadastro em nossa página de consulta.</p>
        <p class="mb-0"><b>Chave de Acesso do Cadastro:</b> {{ $cadastro->chave }}</p>
      </div>
      <div class="card-footer text-center">
        <a href="{{ url('/') }}" class="btn btn-primary">Voltar para o Formulário</a>
        <form method="POST" class="d-inline" action="{{ route('cadastros.visualizacao') }}">
          {{ csrf_field() }}
          <input type="hidden" name="chave" value="{{ $cadastro->chave }}">
          <button type="submit" class="btn btn-success">Consultar Cadastro</button>
        </form>
      </div>
    </div>
   </div>
	<div class="container" style="padding-top: 30px">
		@include('layouts.footer')
	</div>
@endsection