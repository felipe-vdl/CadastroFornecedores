@extends('layouts.dashboard.app')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons"></i>
                        </div>
                        <h4 class="card-title">Dados da Empresa</h4>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <div class="container-fluid">
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
                                        <h4 class="text-uppercase"><strong>Razão Social: </strong><small> {{$cadastro->razao_social}}</small></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>CNPJ: </strong><small> {{$cadastro->cnpj}}</small></h4>
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
                                        <h4 class="text-uppercase"><strong>Porte da empresa: </strong><small> {{$cadastro->porte_empresa}}</small></h4>
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
                                        <h4 class="text-uppercase"><strong>Produtos e Serviços : </strong><small> {{$cadastro->produtos}}</small></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>Endereço: </strong><small> {{$cadastro->endereco}}</small></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>Email: </strong><small> {{$cadastro->email}}</small></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>Telefone:</strong><small> {{$cadastro->telefone}}</small></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>Data do Cadastro:</strong><small> {{ date('d/m/Y', strtotime($cadastro->created_at))}}</small></h4>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">1. Requerimento de Inscrição</h4>
                                        @if ($cadastro->doc_categorias->status_requerimento_inscricao == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_requerimento_inscricao)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_requerimento_inscricao }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">2. Ato Constitutivo</h4>
                                        @if ($cadastro->doc_categorias->status_ato_constitutivo == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_ato_constitutivo)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_ato_constitutivo }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">3. Procuração ou Carta de Credenciamento</h4>
                                        @if ($cadastro->doc_categorias->status_procuracao_carta == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_procuracao_carta)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_procuracao_carta }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">4. Cédula de Identidade (RG) e CPF dos Reprentantes Legais:</h4>
                                        @if ($cadastro->doc_categorias->status_cedula_identidade == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_cedula_identidade)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_cedula_identidade }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">5. Registro ou Inscrição na Entidade Profissional Competente:</h4>
                                        @if ($cadastro->doc_categorias->status_registro_entidade == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_registro_entidade)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_registro_entidade }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">6. Documentação de Inscrição do CNPJ:</h4>
                                        @if ($cadastro->doc_categorias->status_inscricao_cnpj == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_inscricao_cnpj)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_inscricao_cnpj }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">7. Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal:</h4>
                                        @if ($cadastro->doc_categorias->status_cadastro_contribuinte == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_cadastro_contribuinte)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_cadastro_contribuinte }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">8. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</h4>
                                        @if ($cadastro->doc_categorias->status_balanco_patrimonial == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_balanco_patrimonial)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_balanco_patrimonial }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">9. Certidão de Regularidade Fiscal do FGTS:</h4>
                                        @if ($cadastro->doc_categorias->status_regularidade_fiscal == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_regularidade_fiscal)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_regularidade_fiscal }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                  <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">10. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</h4>
                                        @if ($cadastro->doc_categorias->status_credito_tributario == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_credito_tributario)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_credito_tributario }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">11. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</h4>
                                        @if ($cadastro->doc_categorias->status_debito_estadual == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_debito_estadual)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_debito_estadual }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">12. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</h4>
                                        @if ($cadastro->doc_categorias->status_debito_municipal == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_debito_municipal)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_debito_municipal }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">13. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</h4>
                                        @if ($cadastro->doc_categorias->status_falencia_concordata == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_falencia_concordata)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_falencia_concordata }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                  <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">14. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></h4>
                                        @if ($cadastro->doc_categorias->status_debito_trabalhista == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_debito_trabalhista)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_debito_trabalhista }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
                                    <div class="d-flex align-items-center mb-2 justify-content-between">
                                        <h4 class="font-weight-bold">15. 01 (Um) Atestado de Capacidade Técnica:</h4>
                                        @if ($cadastro->doc_categorias->status_capacidade_tecnica == 2)
                                            <h6 class="bg-danger text-white p-1 m-0">Aguardando Documentos</h6>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($cadastro->doc_categorias->justificativa_capacidade_tecnica)
                                            <h6 class="m-0">Justificativa da Solicitação Adicional: {{ $cadastro->doc_categorias->justificativa_capacidade_tecnica }}</h6>
                                        @endif
                                    </div>
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
                                            <h6 class="bg-secondary text-white p-1">Em Análise</h6>
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
    document.querySelector('footer').style.display = 'none';
</script>
@endpush