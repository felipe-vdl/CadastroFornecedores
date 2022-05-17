@extends('layouts.dashboard.app')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session()->get('error'))
                <div class="alert alert-danger m-0">
                    {{ session()->get('error') }}
                </div>
			@endif
            @if(session()->get('success'))
                <div class="alert alert-success m-0">
                    {{ session()->get('success') }}
                </div>
			@endif
            <div class="card">
                <form action="{{ route('cadastros.update', $cadastro->id ) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons"></i>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">Avaliação de Cadastro</h4>
                            <button id="enviador-cadastro" class="btn btn-success btn-sm" type="submit">Enviar Avaliação</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <div class="container-fluid">
                                <div class="row mt-3 justify-content-around">
                                    <div class="col-12 col-md-4 text-center">
                                        <label for="direcionamento" class="text-dark"><strong>Direcionamento</strong></label>
                                        <select class="form-control text-center" name="direcionamento" id="direcionamento" required>
                                            <option value="" selected disabled hidden>Selecione a opção</option>
                                            <option value="1">Deferido</option>
                                            <option value="3">Inválido</option>
                                        </select>
                                    </div>
                                    <div id="justificativa-div" class="col-12 mt-3 mt-md-0 col-md-4 text-center" style="display: none;">
                                        <label for="justificativa" class="text-dark"><strong>Justificativa</strong></label>
                                        <input class="form-control text-center" type="text" {{-- name="justificativa" --}} id="justificativa" placeholder="Descreva o motivo da invalidez do cadastro.">
                                    </div>
                                </div>
                </form>
                            <div class="card card-plain mb-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Situação: </strong><small>
                                                @switch($cadastro->status)
                                                @case(0)
                                                    Em Análise
                                                    @break
                                                @case(1)
                                                    Aprovado
                                                    @break
                                                @case(2)
                                                    Aguardando Documentos
                                                    @break
                                                @case(3)
                                                    Inválido
                                                    @break
                                                @endswitch
                                            </small></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Razão Social: </strong><small> {{$cadastro->razao_social}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>CNPJ: </strong><small> {{$cadastro->cnpj}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Porte da empresa: </strong><small> {{$cadastro->porte_empresa}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>CNAE: </strong><small> {{$cadastro->cnae}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Produtos e Serviços: </strong><small> {{$cadastro->produtos}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Endereço: </strong><small> {{$cadastro->endereco}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Email: </strong><small> {{$cadastro->email}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Telefone: </strong><small> {{$cadastro->telefone}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Dia do cadastro: </strong><small> {{date('d/m/Y', strtotime($cadastro->created_at))}}</></h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Chave: </strong><small> {{$cadastro->chave}}</></h4>
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- 1) Requerimento de Inscrição --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">1. Requerimento de Inscrição</h4>
                                        <div>
                                        @foreach ($cadastro->doc_requerimentoinscricao as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (1) --}}
                                    {{-- 2) Ato Constitutivo --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">2. Ato Constitutivo</h4>
                                        <div>
                                        @foreach ($cadastro->doc_atoconstitutivo as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (2) --}}
                                    {{-- 3) Procuração ou Carta de Credenciamento --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">3. Procuração ou Carta de Credenciamento</h4>
                                        <div>
                                        @foreach ($cadastro->doc_procuracaocarta as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (3) --}}
                                    {{-- 4) Cédula de Identidade --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">4. Cédula de Identidade (RG) e CPF dos Reprentantes Legais:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_cedulaidentidade as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (4) --}}
                                    {{-- 5) Registro Entidade --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">5. Registro ou Inscrição na Entidade Profissional Competente:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_registroentidade as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (5) --}}
                                    {{-- 6) Registro Entidade --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">6. Documentação de Inscrição do CNPJ, Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_inscricaocnpj as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (6) --}}
                                    {{-- 7) Balanço Patrimonial --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">7. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_balancopatrimonial as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (7) --}}
                                    {{-- 8) Regularidade Fiscal --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">8. Certidão de Regularidade Fiscal do FGTS:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_regularidadefiscal as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (8) --}}
                                    {{-- 9) Regularidade Fiscal --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">9. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</h4>
                                        <div>
                                        @foreach ($cadastro->doc_creditotributario as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (9) --}}
                                    {{-- 10) Debito Estadual --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">10. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</h4>
                                        <div>
                                        @foreach ($cadastro->doc_debitoestadual as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (10) --}}
                                    {{-- 11) Debito Municipal --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">11. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</h4>
                                        <div>
                                        @foreach ($cadastro->doc_debitomunicipal as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (11) --}}
                                    {{-- 12) Falencia Concordata --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">12. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_falenciaconcordata as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (12) --}}
                                    {{-- 13) DebitoTrabalhista --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">13. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></h4>
                                        <div>
                                        @foreach ($cadastro->doc_debitotrabalhista as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (13) --}}
                                    {{-- 14) CapacidadeTecnica --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <h4 class="font-weight-bold">14. 01 (Um) Atestado de Capacidade Técnica:</h4>
                                        <div>
                                        @foreach ($cadastro->doc_capacidadetecnica as $doc)
                                            <div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mb-3 bg-white">
                                                @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                                <figure>
                                                    <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                                    <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                                </figure>
                                                @else
                                                    <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                                @endif
                                                @if ($doc->status == 0)
                                                    <form action="{{ route('documentos.avaliar') }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <input type="hidden" name="doc_id" value="{{$doc->id}}">
                                                            <input type="hidden" name="filename" value="{{$doc->filename}}">
                                                            <div class="input-group d-inline">
                                                                <label class="label-deferido btn btn-outline-success" title="Documento deferido.">
                                                                    <input type="radio" class="deferido btn-check" name="doc_status" value="1" required>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                    </svg>
                                                                </label>
                                                                <label class="label-indeferido btn btn-outline-danger" title="Documento indeferido.">
                                                                    <input type="radio" class="indeferido btn-check" name="doc_status" value="2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                                                    </svg>
                                                                </label>
                                                            </div>
                                                            <button type="submit" class="enviador ml-2 btn btn-warning btn-sm d-inline" title="Avaliar documento.">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="justificativa-div" style="display: none;">
                                                            <input class="justificativa-input form-control" type="text" name="doc_justificativa" placeholder="Escreva a justificativa">
                                                        </div>
                                                    </form>
                                                @elseif ($doc->status == 1)
                                                    <h6 class="bg-success text-white p-1">Deferido</h6>
                                                @elseif ($doc->status == 2)
                                                    <h6 class="bg-danger text-white p-1">Indeferido</h6>
                                                    <h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    {{-- Fim (14) --}}
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
    const direcionamento = document.querySelector('#direcionamento');
    const justificativaDiv = document.querySelector('#justificativa-div');
    const justificativa = document.querySelector('#justificativa');

    direcionamento.addEventListener('change', function () {
        if (this.value == 3) {
            justificativaDiv.style.display = 'block';
            justificativa.setAttribute('required', 'required');
            justificativa.setAttribute('name', 'justificativa');
        } else {
            justificativaDiv.style.display = 'none';
            justificativa.removeAttribute('required');
            justificativa.removeAttribute('name');
        };
    });
</script>
<script>
    /* Avaliação de Documentos */
        const allDeferidoBtns = document.querySelectorAll('.label-deferido');
        const allIndeferidoBtns = document.querySelectorAll('.label-indeferido');
        const allSubmitBtns = document.querySelectorAll('.enviador');
        const submitCadastro = document.querySelector('#enviador-cadastro');

        for (let btn of allDeferidoBtns) {
            btn.addEventListener('click', function() {
                this.parentElement.parentElement.nextElementSibling.style.display = 'none';
                this.parentElement.parentElement.nextElementSibling.firstElementChild.firstElementChild.removeAttribute('required');
                this.parentElement.parentElement.nextElementSibling.firstElementChild.firstElementChild.removeAttribute('name');
                this.classList.replace('btn-outline-success', 'btn-success');
                this.nextElementSibling.classList.replace('btn-danger', 'btn-outline-danger');
            });
        }

        for (let btn of allIndeferidoBtns) {
            btn.addEventListener('click', function() {
                this.parentElement.parentElement.nextElementSibling.style.display = 'block';
                this.parentElement.parentElement.nextElementSibling.firstElementChild.firstElementChild.setAttribute('required', 'required');
                this.parentElement.parentElement.nextElementSibling.firstElementChild.firstElementChild.setAttribute('name', 'doc_justificativa');
                this.classList.replace('btn-outline-danger', 'btn-danger');
                this.previousElementSibling.classList.replace('btn-success', 'btn-outline-success');
            });
        }

        for (let btn of allSubmitBtns) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let formulario = this.form;
                if(formulario.checkValidity()) {
                    swal({
                        title: "Atenção!",
                        text: `Você está prestes enviar uma avaliação de documento.`,
                        icon: "warning",
                        buttons: {
                            cancel: {
                                text: "Cancelar",
                                value: "cancelar",
                                visible: true,
                                closeModal: true
                            },
                            ok: {
                                text: "Confirmar",
                                value: 'ok',
                                visible: true,
                                closeModal: true
                            }
                        }
                    }).then(function(resultado){
                        if(resultado === 'ok'){
                            formulario.submit();
                        }
                    });
                } else {
                    formulario.reportValidity();
                }
            });
        }

    /* Avaliação do Cadastro */
        submitCadastro.addEventListener('click', function(e) {
            e.preventDefault();
            let formulario = this.form;
            if(formulario.checkValidity()) {
                swal({
                    title: "Atenção!",
                    text: `Você está prestes enviar a avaliação do cadastro.`,
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancelar",
                            value: "cancelar",
                            visible: true,
                            closeModal: true
                        },
                        ok: {
                            text: "Confirmar",
                            value: 'ok',
                            visible: true,
                            closeModal: true
                        }
                    }
                }).then(function(resultado){
                    if(resultado === 'ok'){
                        formulario.submit();
                    }
                });
            } else {
                formulario.reportValidity();
            }
        });

    /* Loading após submit de qualquer form. */
        const allForms = document.querySelectorAll('form');
        for (let form of allForms) {
            form.addEventListener('submit', (e) => {
                $("#modaleventclick").modal("show");
            });
        }
</script>
<script>
    
</script>
@endpush