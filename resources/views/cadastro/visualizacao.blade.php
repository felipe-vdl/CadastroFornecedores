@extends('layouts.app')

@section('content')
	<div class="container" style="padding-bottom: 150px;">
		<form method="POST" action="{{ route('cadastros.corrigir') }}" enctype="multipart/form-data" id="form_cadastro">
            @method('patch')
			{{ csrf_field() }}
			<input type="hidden" name="id" value="{{$cadastro->id}}">
			@if(session()->get('error'))
			<div class="alert alert-danger m-0">
				{{ session()->get('error') }}
			</div><br/>
			@endif
			@if(session()->get('success'))
			<div class="alert alert-success m-0">
				{{ session()->get('success') }}
			</div><br/>
			@endif
			<div class="card bg-light">
				<div class="card-header">
                    <h3 class="card-title mt-1 m-0">Situação:
                        @switch($cadastro->status)
                            @case(0)
                              <span class="text-secondary">Em Análise</span>
                              @break
                            @case(1)
							  <span class="text-success">Aprovado</span>
                              @break
                            @case(2)
							<span class="text-primary">Aguardando Documentos</span>
                              @break
                            @case(3)
							<span class="text-danger">Dados Inválidos</span>
                              @break
                        @endswitch
                    </h3>
				</div>
				<div class="card-body">
					@if(session()->get('error'))
					<div class="alert alert-danger m-0">
						<h5 class="alert-heading">Erro ao corrigir o cadastro.</h5>
						{{ session()->get('error') }}
					</div><br/>
					@endif
					<div class="row">
						<div class="form-group col-12 mb-3">
							<p class="m-0"><span class="font-weight-bold">Chave do Cadastro:</span> {{ $cadastro->chave }}</p>
							@if($cadastro->status == 3)
								<p class="m-0"><span class="font-weight-bold text-danger">Motivo de Invalidez:</span> {{ $cadastro->justificativa }}</p>
							@endif
						</div>
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">Razão Social:</span> {{ $cadastro->razao_social }}</p>
						</div>
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">CNPJ:</span> {{$cadastro->cnpj}}</p>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">Porte da Empresa:</span> {{ $cadastro->porte_empresa }}</p>
						</div>
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">CNAE (Atividade Econômica):</span> {{$cadastro->cnae}}</p>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">Produtos e Serviços Ofertados: </span>{{ $cadastro->produtos }}</p>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">Endereço:</span> {{ $cadastro->endereco }}</p>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">E-mail: </span>{{ $cadastro->email }}</p>
						</div>
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">Telefone: </span>{{ $cadastro->telefone }}</p>
						</div>
					</div>
					@if ($cadastro->status == 2)
						<div class="mt-3">
							<h4 class="card-title mb-0 mt-3 text-center">Documentos Necessários:</h4>
							<p style="font-size: 14px;" class="text-danger font-weight-bold mb-0">Atenção:</p>
							<ul class="text-danger">
								{{-- <li><span class="font-weight-bold">Tipos de arquivo aceitos:</span> Imagem ou documento.</li>
								<li><span class="font-weight-bold">Tamanho limite por arquivo:</span> 10MB.</li>
								<li><span class="font-weight-bold">Certifique-se de que as fotos/documentos são legíveis.</span></li>
								<li><span class="font-weight-bold">Insira os documentos de acordo com a categoria.</span></li> --}}
								<li><span class="font-weight-bold">Para dar seguimento ao processo, os documentos sinalizados como indeferidos devem ser reenviados ou substituídos, conforme a necessidade.</span></li>
								<li><span class="font-weight-bold">As categorias de documento sinalizadas com "Ausência de Documentos" devem ser munidas com documentos adicionais, conforme a solicitação.</span></li>
							</ul>
						</div>
						{{-- 1) Requerimento de Inscrição --}}
						@foreach ($cadastro->doc_requerimentoinscricao as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">1. Requerimento de Inscrição:</label>
									<p class="mb-2">
										<label for="requerimento_inscricao">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="requerimento_inscricao" class="form-control" name="requerimento_inscricao[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-requerimentoinscricao" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="requerimentoinscricao-invalido"></span></p>
									</div>
									<div id="erro-requerimentoinscricao-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="requerimentoinscricao-grande"></span></p>
									</div>
									<p id="requerimentoinscricao-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="requerimentoinscricao-area">
										<span id="requerimentoinscricao-list">
											<span id="requerimentoinscricao-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 1 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_requerimentoinscricao as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
														</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 1 --}}
						{{-- 2) Ato Constitutivo (Contrato Social, Estatuto, Ata de Reunião) --}}
						@foreach ($cadastro->doc_atoconstitutivo as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">2. Ato Constitutivo (Contrato Social, Estatuto, Ata de Reunião):</label>
									<p class="mb-2">
										<label for="ato_constitutivo">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="ato_constitutivo" class="form-control" name="ato_constitutivo[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-atoconstitutivo" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="atoconstitutivo-invalido"></span></p>
									</div>
									<div id="erro-atoconstitutivo-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="atoconstitutivo-grande"></span></p>
									</div>
									<p id="atoconstitutivo-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="atoconstitutivo-area">
										<span id="atoconstitutivo-list">
											<span id="atoconstitutivo-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 2 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_atoconstitutivo as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 2 --}}
						{{-- 3) Procuração ou Carta de Credenciamento--}}
						@foreach ($cadastro->doc_procuracaocarta as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">3. Procuração ou Carta de Credenciamento:</label>
									<p class="mb-2">
										<label for="procuracao_carta">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="procuracao_carta" class="form-control" name="procuracao_carta[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-procuracaocarta" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="procuracaocarta-invalido"></span></p>
									</div>
									<div id="erro-procuracaocarta-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="procuracaocarta-grande"></span></p>
									</div>
									<p id="procuracaocarta-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="procuracaocarta-area">
										<span id="procuracaocarta-list">
											<span id="procuracaocarta-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 3 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_procuracaocarta as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 3 --}}
						{{-- 4) Cédula de Identidade (RG) e CPF dos Reprentantes Legais --}}
						@foreach ($cadastro->doc_cedulaidentidade as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">4. Cédula de Identidade (RG) e CPF dos Reprentantes Legais:</label>
									<p class="mb-2">
										<label for="cedula_identidade">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="cedula_identidade" class="form-control" name="cedula_identidade[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-cedulaidentidade" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="cedulaidentidade-invalido"></span></p>
									</div>
									<div id="erro-cedulaidentidade-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="cedulaidentidade-grande"></span></p>
									</div>
									<p id="cedulaidentidade-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="cedulaidentidade-area">
										<span id="cedulaidentidade-list">
											<span id="cedulaidentidade-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 4 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_cedulaidentidade as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 4 --}}
						{{-- 5) Registro ou Inscrição na Entidade Profissional Competente: --}}
						@foreach ($cadastro->doc_registroentidade as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">5. Registro ou Inscrição na Entidade Profissional Competente:</label>
									<p class="mb-2">
										<label for="registro_entidade">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="registro_entidade" class="form-control" name="registro_entidade[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-registroentidade" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="registroentidade-invalido"></span></p>
									</div>
									<div id="erro-registroentidade-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="registroentidade-grande"></span></p>
									</div>
									<p id="registroentidade-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="registroentidade-area">
										<span id="registroentidade-list">
											<span id="registroentidade-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 5 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_registroentidade as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 5 --}}
						{{-- 6) Registro ou Inscrição na Entidade Profissional Competente: --}}
						@foreach ($cadastro->doc_inscricaocnpj as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">6. Documentação de Inscrição do CNPJ, Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal: <a target="_blank" href="https://www.receita.fazenda.gov.br">* www.receita.fazenda.gov.br</a></label>
									<p class="mb-2">
										<label for="inscricao_cnpj">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="inscricao_cnpj" class="form-control" name="inscricao_cnpj[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-inscricaocnpj" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="inscricaocnpj-invalido"></span></p>
									</div>
									<div id="erro-inscricaocnpj-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="inscricaocnpj-grande"></span></p>
									</div>
									<p id="inscricaocnpj-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="inscricaocnpj-area">
										<span id="inscricaocnpj-list">
											<span id="inscricaocnpj-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 6 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_inscricaocnpj as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 6 --}}
						{{-- 7) Balanço Patrimonial: --}}
						@foreach ($cadastro->doc_balancopatrimonial as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">7. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</label>
									<p class="mb-2">
										<label for="balanco_patrimonial">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="balanco_patrimonial" class="form-control" name="balanco_patrimonial[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-balancopatrimonial" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="balancopatrimonial-invalido"></span></p>
									</div>
									<div id="erro-balancopatrimonial-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="balancopatrimonial-grande"></span></p>
									</div>
									<p id="balancopatrimonial-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="balancopatrimonial-area">
										<span id="balancopatrimonial-list">
											<span id="balancopatrimonial-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 7 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_balancopatrimonial as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 7 --}}
						{{-- 8) Regularidade Fiscal: --}}
						@foreach ($cadastro->doc_regularidadefiscal as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">8. Certidão de Regularidade Fiscal do FGTS: <a target="_blank" href="https://www.caixa.gov.br">* www.caixa.gov.br</a></label>
									<p class="mb-2">
										<label for="regularidade_fiscal">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="regularidade_fiscal" class="form-control" name="regularidade_fiscal[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-regularidadefiscal" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="regularidadefiscal-invalido"></span></p>
									</div>
									<div id="erro-regularidadefiscal-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="regularidadefiscal-grande"></span></p>
									</div>
									<p id="regularidadefiscal-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="regularidadefiscal-area">
										<span id="regularidadefiscal-list">
											<span id="regularidadefiscal-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 8 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_regularidadefiscal as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 8 --}}
						{{-- 9) Crédito Tributário: --}}
						@foreach ($cadastro->doc_creditotributario as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">9. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</label>
									<p class="mb-2">
										<label for="credito_tributario">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="credito_tributario" class="form-control" name="credito_tributario[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-creditotributario" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="creditotributario-invalido"></span></p>
									</div>
									<div id="erro-creditotributario-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="creditotributario-grande"></span></p>
									</div>
									<p id="creditotributario-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="creditotributario-area">
										<span id="creditotributario-list">
											<span id="creditotributario-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 9 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_creditotributario as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 9 --}}
						{{-- 10) Debito Estadual: --}}
						@foreach ($cadastro->doc_debitoestadual as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">10. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</label>
									<p class="mb-2">
										<label for="debito_estadual">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="debito_estadual" class="form-control" name="debito_estadual[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-debitoestadual" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="debitoestadual-invalido"></span></p>
									</div>
									<div id="erro-debitoestadual-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="debitoestadual-grande"></span></p>
									</div>
									<p id="debitoestadual-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="debitoestadual-area">
										<span id="debitoestadual-list">
											<span id="debitoestadual-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 10 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_debitoestadual as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 10 --}}
						{{-- 11) Debito Municipal: --}}
						@foreach ($cadastro->doc_debitomunicipal as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">11. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</label>
									<p class="mb-2">
										<label for="debito_municipal">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="debito_municipal" class="form-control" name="debito_municipal[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-debitomunicipal" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="debitomunicipal-invalido"></span></p>
									</div>
									<div id="erro-debitomunicipal-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="debitomunicipal-grande"></span></p>
									</div>
									<p id="debitomunicipal-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="debitomunicipal-area">
										<span id="debitomunicipal-list">
											<span id="debitomunicipal-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 11 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_debitomunicipal as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 11 --}}
						{{-- 12) Falência Concordatas: --}}
						@foreach ($cadastro->doc_falenciaconcordata as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">12. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</label>
									<p class="mb-2">
										<label for="falencia_concordata">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="falencia_concordata" class="form-control" name="falencia_concordata[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-falenciaconcordata" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="falenciaconcordata-invalido"></span></p>
									</div>
									<div id="erro-falenciaconcordata-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="falenciaconcordata-grande"></span></p>
									</div>
									<p id="falenciaconcordata-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="falenciaconcordata-area">
										<span id="falenciaconcordata-list">
											<span id="falenciaconcordata-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 12 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_falenciaconcordata as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 12 --}}
						{{-- 13) Debito Trabalhista: --}}
						@foreach ($cadastro->doc_debitotrabalhista as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">13. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></label>
									<p class="mb-2">
										<label for="debito_trabalhista">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="debito_trabalhista" class="form-control" name="debito_trabalhista[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-debitotrabalhista" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="debitotrabalhista-invalido"></span></p>
									</div>
									<div id="erro-debitotrabalhista-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="debitotrabalhista-grande"></span></p>
									</div>
									<p id="debitotrabalhista-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="debitotrabalhista-area">
										<span id="debitotrabalhista-list">
											<span id="debitotrabalhista-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 13 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_debitotrabalhista as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 13 --}}
						{{-- 14) Capacidade Técnica: --}}
						@foreach ($cadastro->doc_capacidadetecnica as $doc)
							@if($doc->status == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">14. 01 (Um) Atestado de Capacidade Ténica:</label>
									<p class="mb-2">
										<label for="capacidade_tecnica">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="capacidade_tecnica" class="form-control" name="capacidade_tecnica[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-capacidadetecnica" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="capacidadetecnica-invalido"></span></p>
									</div>
									<div id="erro-capacidadetecnica-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="capacidadetecnica-grande"></span></p>
									</div>
									<p id="capacidadetecnica-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="capacidadetecnica-area">
										<span id="capacidadetecnica-list">
											<span id="capacidadetecnica-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 14 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_capacidadetecnica as $doc)
											@if ($doc->status == 2)
												<div style="padding-bottom: 0.7rem; display: flex; flex-direction: column; justify-content: start; align-items: center;" class="border border-dark p-2 mx-2 my-1 bg-white">
													@if ($doc->extensao === 'png' || $doc->extensao === 'jpg' || $doc->extensao === 'jpeg' || $doc->extensao === 'bmp' || $doc->extensao === 'gif' || $doc->extensao === 'jfif')
													<figure class="m-2 text-center">
														<figcaption style="text-align: center; padding-bottom: 0.7rem;"><a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Imagem</a></figcaption>
														<img style="max-width: 100px;" src="{{ asset('storage/documentos/'.$doc->filename) }}" alt="">
													</figure>
													@else
													<div class="m-2">
														<a class="btn btn-sm btn-info" href="{{ asset('storage/documentos/'.$doc->filename) }}" target="_blank" rel="noopener noreferrer">Visualizar Documento</a>
													</div>
													@endif
													<h6 class="bg-danger text-white p-1">Indeferido</h6>
													<h6><strong>Motivo:</strong> {{$doc->justificativa}}</h6>
												</div>
											@endif
										@endforeach
										</div>
									</div>
								</div>
								@break
							@else
								@continue
							@endif
						@endforeach
						{{-- Fim 14 --}}
					@endif
				</div>
				<div class="card-footer">
					@if ($cadastro->status == 2)
						<center>
							<div>
								<button type="submit" id="form_cadastro" class="botoes-acao btn btn-round btn-success enviar-relatorio">
									<span class="icone-botoes-acao mdi mdi-send"></span>
									<span class="texto-botoes-acao">Salvar Cadastro</span>
									<div class="ripple-container"></div>
								</button>
							</div> 
						</center>
					@endif
				</div>
			</div>
		</form>
	</div>
	<div class="container" style="padding-top: 30px">
		@include('layouts.footer')
	</div>
@endsection

@push('scripts')
	<script>
		$(function(){
			$('body').submit(function(event){
			if ($(this).hasClass('enviar-relatorio')) {
				event.preventDefault();
			}
			else {
				$(this).find(':submit').html('<i class="fa fa-spinner fa-spin"></i>');
				$(this).addClass('enviar-relatorio');
			}
		});
		});
	</script>
	<script src="{{ asset('js/fileInput.js') }}" defer></script>
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
@endpush