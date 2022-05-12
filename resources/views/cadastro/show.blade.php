@extends('layouts.dashboard.app')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card ">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons"></i>
                </div>
                <h4 class="card-title">Dados da Empresa</h4>
              </div>
              <div class="card-body ">
                <div class="content">
                    <div class="container-fluid">
                      <div class="card card-plain mb-0">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-6 col-lg-12">
                              <h4><strong>Criado em:</strong>{{$cadastro->created_at}}</h4>
                            </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Razão Social:</strong>{{$cadastro->razao_social}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>CNPJ:</strong>{{$cadastro->cnpj}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Porte da Empresa:</strong>{{$cadastro->porte_empresa}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>CNAE</strong>{{$cadastro->cnae}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Produtos e Serviços:</strong>{{$cadastro->produtos}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Endereço:</strong>{{$cadastro->endereco}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Email:</strong>{{$cadastro->email}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Telefone:</strong>{{$cadastro->telefone}}</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Status:</strong>
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
                                        Recusado
                                        @break
                                    @endswitch
                                </h4>
                              </div>
                          </div>
                          @if ($cadastro->justificativa)
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Justificativa:</strong>{{$cadastro->justificativa}}</h4>
                              </div>
                          </div>
                          @endif
                          @if ($cadastro->avaliador)
                          <div class="row">
                              <div class="col-sm-6 col-lg-12">
                                <h4><strong>Avaliador:</strong>{{$cadastro->avaliador}}</h4>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6 col-lg-12">
                              <h4><strong>Avaliado em:</strong>{{$cadastro->data_avaliacao}}</h4>
                            </div>
                          </div>
                          @endif
                          <hr>
                          {{-- 1) Requerimento de Inscrição --}}
                          <h4 class="font-weight-bold">1. Requerimento de Inscrição</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">2. Ato Constitutivo</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">3. Procuração ou Carta de Credenciamento</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">3. Cédula de Identidade (RG) e CPF dos Reprentantes Legais:</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">5. Registro ou Inscrição na Entidade Profissional Competente:</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">6. Documentação de Inscrição do CNPJ, Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal:</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">7. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">8. Certidão de Regularidade Fiscal do FGTS:</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">9. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">10. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">11. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">12. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">13. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></h4>
                          <div class="container mb-3">
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
                          <h4 class="font-weight-bold">14. 01 (Um) Atestado de Capacidade Técnica:</h4>
                          <div class="container mb-3">
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
@endpush