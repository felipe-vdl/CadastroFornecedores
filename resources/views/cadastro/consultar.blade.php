@extends('layouts.app')

@section('content')
<form action="{{ route('cadastros.visualizacao') }}" method="POST">
    {{ csrf_field() }}
    <div class="container">
        @if(session()->get('error'))
            <div class="alert alert-danger m-0">
                {{ session()->get('error') }}
            </div>
            <br/>
        @endif
        @if(session()->get('success'))
            <div class="alert alert-success m-0">
                <h5 class="alert-heading">{{ session()->get('success') }}</h5>
                <hr>
                O cadastro será analisado pelo nosso departamento, aguarde a resposta por e-mail, poderá se dar em até 48 horas úteis.
            </div>
            <br/>
        @endif
        <div class="row justify-content-center">
            <div class="card col-10 col-md-7 col-lg-6 p-0">
                <div class="card-header">
                    <h4 class="align-middle mb-0">Consultar Cadastro</h4>
                </div>
                <div class="card-body">
                    <label for="chave" class="form-label">Digite a chave do cadastro:</label>
                    <input id="chave" type="text" name="chave" class="form-control" minlength="13" maxlength="13" required placeholder="Total de 13 dígitos">
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success">Buscar</button>
                    <a href="/" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="container" style="padding-top: 30px">
    @include('layouts.footer')
</div>
@endsection