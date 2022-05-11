@extends('layouts.dashboard.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card">
                    <center><img src="{{ asset('img/loading.gif')}}" class="card-img-top w-50 pt-3"></center>
                    <div class="card-header">
                        <h4>Edição de Usuário</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{url('/usuarios/'.$funcionario->id.'/update')}}">
                            @csrf
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div><label for="name">Nome:</label></div>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $funcionario->name }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div><label for="email">E-mail:</label></div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $funcionario->email }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div><label for="nivel">Nível de Usuário:</label></div>
                                        <select name="nivel" id="nivel" class="form-control">
                                            @if($funcionario->nivel == 'Super-Admin')
                                                <option value="Super-Admin" selected>Super-Administrador</option>
                                                <option value="Admin">Administrador</option>
                                            @elseif ($funcionario->nivel == 'Admin')
                                                <option value="Admin" selected>Administrador</option>
                                                <option value="Super-Admin">Super-Administrador</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Deseja aplicar a senha padrão?</label>
                                        <div>
                                        <input id="nao" type="radio" name="resetarsenha" value="0">
                                        <label for="nao">Não</label>
                                    </div>
                                        <div>
                                            <input id="sim" type="radio" name="resetarsenha" value="1" required>
                                            <label for="sim">Sim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-round btn-success">Salvar</button>
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