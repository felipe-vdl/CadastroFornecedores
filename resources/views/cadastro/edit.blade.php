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
                            <button id="enviador-cadastro" class="btn btn-success btn-sm" type="submit">Salvar Avaliação</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <div class="container-fluid">
                                <div class="row mt-3 justify-content-around">
                                    <div class="col-12 col-md-4 text-center">
                                        <label for="dados" class="text-dark"><strong>Validação dos Dados:</strong></label>
                                        <select class="form-control text-center" name="dados" id="dados" required>
                                            <option value="" @if($cadastro->status == 0) selected @endif disabled hidden>Selecione uma opção</option>
                                            <option value="1" @if($cadastro->status == 1 OR $cadastro->status == 2) selected @endif>Dados Válidos</option>
                                            <option value="3" @if($cadastro->status == 3) selected @endif>Dados Inválidos</option>
                                        </select>
                                    </div>
                                    <div id="justificativa-div" class="col-12 mt-3 mt-md-0 col-md-4 text-center" @if($cadastro->status != 3) style="display: none;" @endif>
                                        <label for="justificativa" class="text-dark"><strong>Justificativa:</strong></label>
                                        <input class="form-control text-center" type="text" {{-- name="justificativa" --}} id="justificativa" placeholder="Descreva o motivo da invalidez dos dados." @if($cadastro->status == 3) value="{{$cadastro->justificativa}}" @endif>
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
                                                    Dados Inválidos
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
                                    @if ($cadastro->inscricao_municipal)
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-12">
                                                <h4 class="text-uppercase"><strong>Inscrição Municipal: </strong><small> {{$cadastro->inscricao_municipal}}</></h4>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($cadastro->inscricao_estadual)
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-12">
                                                <h4 class="text-uppercase"><strong>Inscrição Estadual: </strong><small> {{$cadastro->inscricao_estadual}}</></h4>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-12">
                                            <h4 class="text-uppercase"><strong>Porte da empresa: </strong><small> {{$cadastro->porte_empresa}}</></h4>
                                        </div>
                                    </div>
                                    @if ($cadastro->cnae)
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-12">
                                                <h4 class="text-uppercase"><strong>CNAE: </strong><small> {{$cadastro->cnae}}</></h4>
                                            </div>
                                        </div>
                                    @endif
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
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">1. Requerimento de Inscrição</h4>
                                            @if ($cadastro->doc_categorias->status_requerimento_inscricao == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_requerimento_inscricao == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" value="requerimento_inscricao" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="requerimento_inscricao">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_requerimento_inscricao)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_requerimento_inscricao }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">2. Ato Constitutivo</h4>
                                            @if ($cadastro->doc_categorias->status_ato_constitutivo == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_ato_constitutivo == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="ato_constitutivo">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_ato_constitutivo)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_ato_constitutivo }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">3. Procuração ou Carta de Credenciamento</h4>
                                            @if ($cadastro->doc_categorias->status_procuracao_carta == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_procuracao_carta == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="procuracao_carta">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_procuracao_carta)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_procuracao_carta }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">4. Cédula de Identidade (RG) e CPF dos Reprentantes Legais:</h4>
                                            @if ($cadastro->doc_categorias->status_cedula_identidade == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_cedula_identidade == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="cedula_identidade">
                                                    <div class="my-2 text-center">
                                                        <label  class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_cedula_identidade)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_cedula_identidade }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">5. Registro ou Inscrição na Entidade Profissional Competente:</h4>
                                            @if ($cadastro->doc_categorias->status_registro_entidade == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_registro_entidade == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="registro_entidade">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_registro_entidade)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_registro_entidade }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- 6) Inscrição CNPJ --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">6. Documentação de Inscrição do CNPJ:</h4>
                                            @if ($cadastro->doc_categorias->status_inscricao_cnpj == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_inscricao_cnpj == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="inscricao_cnpj">
                                                    <div class="my-2 text-center">
                                                        <label " class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_inscricao_cnpj)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_inscricao_cnpj }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- 7) Cadastro Contribuinte --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">7. Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal:</h4>
                                            @if ($cadastro->doc_categorias->status_cadastro_contribuinte == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_cadastro_contribuinte == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="inscricao_cnpj">
                                                    <div class="my-2 text-center">
                                                        <label " class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_cadastro_contribuinte)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_cadastro_contribuinte }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
                                        <div>
                                        @foreach ($cadastro->doc_cadastrocontribuinte as $doc)
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
                                    {{-- 8) Balanço Patrimonial --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">8. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</h4>
                                            @if ($cadastro->doc_categorias->status_balanco_patrimonial == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_balanco_patrimonial == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="balanco_patrimonial">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_balanco_patrimonial)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_balanco_patrimonial }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (8) --}}
                                    {{-- 9) Regularidade Fiscal --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">9. Certidão de Regularidade Fiscal do FGTS:</h4>
                                            @if ($cadastro->doc_categorias->status_regularidade_fiscal == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_regularidade_fiscal == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="regularidade_fiscal">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_regularidade_fiscal)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_regularidade_fiscal }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (9) --}}
                                    {{-- 10) Regularidade Fiscal --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">10. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</h4>
                                            @if ($cadastro->doc_categorias->status_credito_tributario == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_credito_tributario == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="credito_tributario">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_credito_tributario)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_credito_tributario }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (10) --}}
                                    {{-- 11) Debito Estadual --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">11. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</h4>
                                            @if ($cadastro->doc_categorias->status_debito_estadual == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_debito_estadual == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="debito_estadual">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_debito_estadual)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_debito_estadual }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (11) --}}
                                    {{-- 12) Debito Municipal --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">12. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</h4>
                                            @if ($cadastro->doc_categorias->status_debito_municipal == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_debito_municipal == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="debito_municipal">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_debito_municipal)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_debito_municipal }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (12) --}}
                                    {{-- 13) Falencia Concordata --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">13. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</h4>
                                            @if ($cadastro->doc_categorias->status_falencia_concordata == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_falencia_concordata == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="falencia_concordata">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_falencia_concordata)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_falencia_concordata }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (13) --}}
                                    {{-- 14) DebitoTrabalhista --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">14. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></h4>
                                            @if ($cadastro->doc_categorias->status_debito_trabalhista == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_debito_trabalhista == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="debito_trabalhista">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_debito_trabalhista)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_debito_trabalhista }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (14) --}}
                                    {{-- 15) CapacidadeTecnica --}}
                                    <div class="container mb-3 border border-secondary pt-2 bg-light">
                                        <div class="d-flex align-items-center mb-1 justify-content-between">
                                            <h4 class="font-weight-bold d-inline mr-2 m-0">15. 01 (Um) Atestado de Capacidade Técnica:</h4>
                                            @if ($cadastro->doc_categorias->status_capacidade_tecnica == 2)
                                                <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                            @endif
                                            <button @if ($cadastro->doc_categorias->status_capacidade_tecnica == 2) style="display: none;" @endif class="solicitar btn btn-warning btn-sm" title="Solicitar mais documentos.">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                                    <path d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z"/>
                                                    <path d="M13.5 10a.5.5 0 0 1 .5.5V12h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V13h-1.5a.5.5 0 0 1 0-1H13v-1.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        {{-- Solicitação de Documentos --}}
                                        <div class="solicitacao-div row justify-content-center mb-3" style="display: none;">
                                            <div class="col-12 mt-3 mt-md-0 col-md-5 justify-content-center">
                                                <form method="POST" action="{{ route('documentos.solicitar') }}">
                                                    @csrf
                                                    <input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
                                                    <input type="hidden" name="categoria" value="capacidade_tecnica">
                                                    <div class="my-2 text-center">
                                                        <label class="mb-0 form-label text-dark"><strong>Justificativa para solicitação:</strong></label>
                                                        <input {{-- name="justificativa" --}} class="mt-1 form-control text-center" type="text" placeholder="Descreva a justificativa e documentos solicitados." {{-- required --}}>
                                                        <button class="enviador-solicitar btn btn-success btn-sm">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Justificativa --}}
                                        <div>
                                            @if ($cadastro->doc_categorias->justificativa_capacidade_tecnica)
                                                <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_capacidade_tecnica }}</h6>
                                            @endif
                                        </div>
                                        {{-- Documentos --}}
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
                                    {{-- Fim (15) --}}
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
    /* Loading após submit de qualquer form. */
    const allForms = document.querySelectorAll('form');
    if(allForms) {
        for (let form of allForms) {
            form.addEventListener('submit', (e) => {
                $("#modaleventclick").modal("show");
            });
        }
    }
</script>
<script>
    const dados = document.querySelector('#dados');
    const justificativaDiv = document.querySelector('#justificativa-div');
    const justificativa = document.querySelector('#justificativa');

    dados.addEventListener('change', function () {
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
</script>
<script>
    const solicitarBtns = document.querySelectorAll('.solicitar');
    const enviadorSolicitarBtns = document.querySelectorAll('.enviador-solicitar')

    for (let btn of solicitarBtns) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            if(this.parentElement.nextElementSibling.style.display == 'none') {
                this.parentElement.nextElementSibling.style.display = 'flex';
                this.parentElement.nextElementSibling.firstElementChild.firstElementChild[3].setAttribute('required', 'required')
                this.parentElement.nextElementSibling.firstElementChild.firstElementChild[3].setAttribute('name', 'justificativa')
            } else {
                this.parentElement.nextElementSibling.style.display = 'none';
                this.parentElement.nextElementSibling.firstElementChild.firstElementChild[3].removeAttribute('required');
                this.parentElement.nextElementSibling.firstElementChild.firstElementChild[3].removeAttribute('name');
            }
        })
    }

    for (let btn of enviadorSolicitarBtns) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            let formulario = this.form;
            if(formulario.checkValidity()) {
                swal({
                    title: "Atenção!",
                    text: `Você está prestes enviar a solicitação de mais documentos.`,
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
</script>
@endpush