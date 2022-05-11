@extends('layouts.dashboard.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <center><img src="{{ asset('img/loading.gif')}}" class="card-img-top w-50 pt-3"></center>
                    <div class="card-header">
                        <h4>Registro de Usuário</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div><label for="name">Nome:</label></div>
                                        <input id="name" type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div><label for="email">E-mail:</label></div>
                                        <input id="email" type="email" class="form-control" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div><label for="nivel">Nível de Usuário:</label></div>
                                        <select name="nivel" id="nivel" class="form-control">
                                            <option value="Admin">Administrador</option>
                                            <option value="Super-Admin">Super-Administrador</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-round btn-success">Registrar</button>
                            <a class="btn btn-round btn-default" href="{{ url('/usuarios') }}">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush