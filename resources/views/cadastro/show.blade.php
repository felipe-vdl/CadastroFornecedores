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
                                              Inválido
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
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>Porte da empresa: </strong><small> {{$cadastro->porte_empresa}}</small></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-12">
                                        <h4 class="text-uppercase"><strong>CNAE: </strong><small> {{$cadastro->cnae}}</small></h4>
                                    </div>
                                </div>
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
                                <hr>
                                {{-- 1) Requerimento de Inscrição --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">1. Requerimento de Inscrição</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_requerimentoinscricao as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (1) --}}
                                {{-- 2) Ato Constitutivo --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">2. Ato Constitutivo</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_atoconstitutivo as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (2) --}}
                                {{-- 3) Procuração ou Carta de Credenciamento --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">3. Procuração ou Carta de Credenciamento</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_procuracaocarta as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (3) --}}
                                {{-- 4) Cédula de Identidade --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">3. Cédula de Identidade (RG) e CPF dos Reprentantes Legais:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_cedulaidentidade as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (4) --}}
                                {{-- 5) Registro Entidade --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">5. Registro ou Inscrição na Entidade Profissional Competente:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_registroentidade as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (5) --}}
                                {{-- 6) Registro Entidade --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">6. Documentação de Inscrição do CNPJ, Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_inscricaocnpj as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (6) --}}
                                {{-- 7) Balanço Patrimonial --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">7. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_balancopatrimonial as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (7) --}}
                                {{-- 8) Regularidade Fiscal --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">8. Certidão de Regularidade Fiscal do FGTS:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_regularidadefiscal as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (8) --}}
                                {{-- 9) Regularidade Fiscal --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                  <h4 class="font-weight-bold">9. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_creditotributario as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (9) --}}
                                {{-- 10) Debito Estadual --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">10. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_debitoestadual as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (10) --}}
                                {{-- 11) Debito Municipal --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">11. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_debitomunicipal as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (11) --}}
                                {{-- 12) Falencia Concordata --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">12. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_falenciaconcordata as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (12) --}}
                                {{-- 13) DebitoTrabalhista --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                  <h4 class="font-weight-bold">13. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_debitotrabalhista as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                                {{-- Fim (13) --}}
                                {{-- 14) CapacidadeTecnica --}}
                                <div class="container mb-3 border border-secondary pt-2">
                                    <h4 class="font-weight-bold">14. 01 (Um) Atestado de Capacidade Técnica:</h4>
                                    <div style="display: flex; justify-content: start; align-items: start;">
                                    @foreach ($cadastro->doc_capacidadetecnica as $doc)
                                        @if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
                                        <figure>
                                            <figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
                                            <img style="max-width: 25vw;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
                                        </figure>
                                        @else
                                            <a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
                                        @endif
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
    document.querySelector('footer').style.display = 'none';
</script>
@endpush