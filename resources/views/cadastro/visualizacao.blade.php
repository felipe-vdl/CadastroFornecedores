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
					@if ($cadastro->status != 0)
						<div class="row">
							<div class="form-group col-12 m-0">
								<p class="m-0"><span class="font-weight-bold">Data da Avaliação:</span> {{ date('d/m/Y', strtotime($cadastro->data_avaliacao)) }}</p>
							</div>
						</div>
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
					@if ($cadastro->inscricao_municipal OR $cadastro->inscricao_estadual)
						<div class="row">
							@if ($cadastro->inscricao_municipal)
							<div class="form-group col-12 m-0">
								<p class="m-0"><span class="font-weight-bold">Inscrição Municipal:</span> {{ $cadastro->inscricao_municipal }}</p>
							</div>
							@endif
							@if ($cadastro->inscricao_estadual)
							<div class="form-group col-12 m-0">
								<p class="m-0"><span class="font-weight-bold">Inscrição Estadual:</span> {{ $cadastro->inscricao_estadual }}</p>
							</div>
							@endif
						</div>
					@endif
					<div class="row">
						<div class="form-group col-12 m-0">
							<p class="m-0"><span class="font-weight-bold">Porte da Empresa:</span> {{ $cadastro->porte_empresa }}</p>
						</div>
						@if ($cadastro->cnae)
							<div class="form-group col-12 m-0">
								<p class="m-0"><span class="font-weight-bold">CNAE (Atividade Econômica):</span> {{$cadastro->cnae}}</p>
							</div>
						@endif
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
					@if ($cadastro->status == 1)
					<div class="mt-3">
						<h4 class="card-title mb-0 mt-3 text-center">Certificado</h4>
						<div>
							<h5><strong>Data da Certificação:</strong> {{ date('d/m/Y', strtotime($cadastro->data_certificado)) }}</h5>
							<h5><strong>Validade do Certificado:</strong> {{ date('d/m/Y', strtotime($cadastro->validade_certificado)) }}</h5>
						</div>
						<form method="POST" action="{{ route('cadastros.certificado') }}">
							@csrf
							<input type="hidden" name="cadastro_id" value="{{ $cadastro->id }}">
							<input type="hidden" name="chave" value="{{ $cadastro->chave }}">
							<button type="submit" class="btn btn-success">Visualizar Certificado</button>
						</form>
					</div>
					@endif
					@if ($cadastro->status == 2)
						<div class="mt-3">
							<h4 class="card-title mb-0 mt-3 text-center">Documentos Necessários:</h4>
							<p style="font-size: 14px;" class="text-danger font-weight-bold mb-0">Atenção:</p>
							<ul class="text-danger">
								{{-- <li><span class="font-weight-bold">Tipos de arquivo aceitos:</span> Imagem ou documento.</li>
								<li><span class="font-weight-bold">Tamanho limite por arquivo:</span> 10MB.</li>
								<li><span class="font-weight-bold">Certifique-se de que as fotos/documentos são legíveis.</span></li>
								<li><span class="font-weight-bold">Insira os documentos de acordo com a categoria.</span></li> --}}
								<li><span class="font-weight-bold">Para dar seguimento ao processo, os documentos sinalizados como indeferidos devem ser reenviados ou substituídos, conforme a necessidade da justificativa.</span></li>
								<li><span class="font-weight-bold">As categorias de documento sinalizadas com "Aguardando Documentos" devem ser munidas com documentos adicionais, conforme a justificativa/solicitação.</span></li>
							</ul>
						</div>
						{{-- 1) Requerimento de Inscrição --}}
						
							@if($cadastro->doc_categorias->status_requerimento_inscricao == 2)
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
										@if($cadastro->doc_categorias->status_requerimento_inscricao == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_requerimento_inscricao }}</p>
										@endif
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
							@endif
						{{-- Fim 1 --}}
						{{-- 2) Ato Constitutivo (Contrato Social, Estatuto, Ata de Reunião) --}}
							@if($cadastro->doc_categorias->status_ato_constitutivo == 2)
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
										@if($cadastro->doc_categorias->status_ato_constitutivo == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_ato_constitutivo }}</p>
										@endif
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
							@endif
						{{-- Fim 2 --}}
						{{-- 3) Procuração ou Carta de Credenciamento--}}
							@if($cadastro->doc_categorias->status_procuracao_carta == 2)
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
										@if($cadastro->doc_categorias->status_procuracao_carta == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_procuracao_carta }}</p>
										@endif
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
							@endif
						{{-- Fim 3 --}}
						{{-- 4) Cédula de Identidade (RG) e CPF dos Reprentantes Legais --}}
							@if($cadastro->doc_categorias->status_cedula_identidade == 2)
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
										@if($cadastro->doc_categorias->status_cedula_identidade == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_cedula_identidade }}</p>
										@endif
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
							@endif
						{{-- Fim 4 --}}
						{{-- 5) Registro ou Inscrição na Entidade Profissional Competente: --}}
							@if($cadastro->doc_categorias->status_registro_entidade == 2)
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
										@if($cadastro->doc_categorias->status_registro_entidade == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_registro_entidade }}</p>
										@endif
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
							@endif
						{{-- Fim 5 --}}
						{{-- 6) Inscrição CNPJ --}}
							@if($cadastro->doc_categorias->status_inscricao_cnpj == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">6. Documentação de Inscrição do CNPJ: <a target="_blank" href="https://www.receita.fazenda.gov.br">* www.receita.fazenda.gov.br</a></label>
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
										@if($cadastro->doc_categorias->status_inscricao_cnpj == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_inscricao_cnpj }}</p>
										@endif
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
							@endif
						{{-- Fim 6 --}}
						{{-- 7) Cadastro Contribuinte --}}
							@if($cadastro->doc_categorias->status_cadastro_contribuinte == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">7. Inscrição no Cadastro de Contribuinte Estadual e/ou Municipal:</label>
									<p class="mb-2">
										<label for="cadastro_contribuinte">
											<a class="btn btn-primary text-light" type="button" role="button" aria-disabled="false">Adicionar Arquivo</a>
										</label>
										<input id="cadastro_contribuinte" class="form-control" name="cadastro_contribuinte[]" type="file" required multiple="multiple" style="visibility: hidden; position: absolute;" accept=".png, .jpg, .jpeg,image/*,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.pdf">
									</p>
									<div id="erro-cadastrocontribuinte" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Tipo de arquivo inválido, insira apenas imagem ou documento: <span id="cadastrocontribuinte-invalido"></span></p>
									</div>
									<div id="erro-cadastrocontribuinte-grande" class="alert alert-danger mb-2" style="display: none;">
										<p class="m-0">Arquivo ultrapassa o limite de tamanho permitido: <span id="cadastrocontribuinte-grande"></span></p>
									</div>
									<p id="cadastrocontribuinte-vermelho" style="font-size: 13px; color: red; display: none;" class="mb-2">* Atenção: Os arquivos destacados em vermelho não serão enviados.</p>
									<p id="cadastrocontribuinte-area">
										<span id="cadastrocontribuinte-list">
											<span id="cadastrocontribuinte-names"></span>
										</span>
									</p>
									{{-- Imagens/Documentos 7 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										@if($cadastro->doc_categorias->status_cadastro_contribuinte == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_cadastro_contribuinte }}</p>
										@endif
										<div style="display: flex; justify-content: start; align-items: start;">
										@foreach ($cadastro->doc_cadastrocontribuinte as $doc)
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
							@endif
						{{-- Fim 7 --}}
						{{-- 8) Balanço Patrimonial: --}}
							@if($cadastro->doc_categorias->status_balanco_patrimonial == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">8. Balanço Patrimonial e Demonstrativo do Último Exercício Social, Registrado na Forma Lei e Demonstrativo de Índice de Liquidez:</label>
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
									{{-- Imagens/Documentos 8 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										@if($cadastro->doc_categorias->status_balanco_patrimonial == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_balanco_patrimonial }}</p>
										@endif
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
							@endif
						{{-- Fim 8 --}}
						{{-- 9) Regularidade Fiscal: --}}
							@if($cadastro->doc_categorias->status_regularidade_fiscal == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">9. Certidão de Regularidade Fiscal do FGTS: <a target="_blank" href="https://www.caixa.gov.br">* www.caixa.gov.br</a></label>
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
									{{-- Imagens/Documentos 9 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										@if($cadastro->doc_categorias->status_regularidade_fiscal == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_regularidade_fiscal }}</p>
										@endif
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
							@endif
						{{-- Fim 9 --}}
						{{-- 10) Crédito Tributário: --}}
							@if($cadastro->doc_categorias->status_credito_tributario == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">10. Certidão de Débitos Relativos a Créditos Tributários Federais e a Dívida Ativa da União (Incluindo contribuições previdenciárias):</label>
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
									{{-- Imagens/Documentos 10 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										@if($cadastro->doc_categorias->status_credito_tributario == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_credito_tributario }}</p>
										@endif
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
							@endif
						{{-- Fim 10 --}}
						{{-- 11) Debito Estadual: --}}
							@if($cadastro->doc_categorias->status_debito_estadual == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">11. Certidão Negativa de Débito com a Fazenda Estadual (ICMS) em conjunto com a Certidão de Dívida Ativa da Procuradoria Geral do Estado (PGE):</label>
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
									{{-- Imagens/Documentos 11 --}}
									<div class="container mb-3 pt-2 bg-light">
										<h6 class="text-center border-bottom border-dark pb-2 mb-3">Documentos Indeferidos</h6>
										@if($cadastro->doc_categorias->status_debito_estadual == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_debito_estadual }}</p>
										@endif
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
							@endif
						{{-- Fim 11 --}}
						{{-- 12) Debito Municipal: --}}
							@if($cadastro->doc_categorias->status_debito_municipal == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">12. Certidão Negativa de Débito com a Fazenda Municipal (ISSQN):</label>
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
										@if($cadastro->doc_categorias->status_debito_municipal == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_debito_municipal }}</p>
										@endif
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
							@endif
						{{-- Fim 12 --}}
						{{-- 13) Falência Concordatas: --}}
							@if($cadastro->doc_categorias->status_falencia_concordata == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">13. Certidão Negativa de Falência e Concordatas e dos Distribuidores de Cartório:</label>
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
										@if($cadastro->doc_categorias->status_falencia_concordata == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_falencia_concordata }}</p>
										@endif
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
							@endif
						{{-- Fim 13 --}}
						{{-- 14) Debito Trabalhista: --}}
							@if($cadastro->doc_categorias->status_debito_trabalhista == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">14. Certidão Negativa de Débitos Trabalhistas (CNDT): <a target="_blank" href="http://www.tst.just.br">* www.tst.jus.br</a></label>
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
										@if($cadastro->doc_categorias->status_debito_trabalhista == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_debito_trabalhista }}</p>
										@endif
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
							@endif
						{{-- Fim 14 --}}
						{{-- 15) Capacidade Técnica: --}}
							@if($cadastro->doc_categorias->status_capacidade_tecnica == 2)
								<div class="col-12 mt-3 border border-secondary pt-2">
									<label class="form-label font-weight-bold">15. 01 (Um) Atestado de Capacidade Ténica:</label>
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
										@if($cadastro->doc_categorias->status_capacidade_tecnica == 2)
										<h6 class="d-inline p-1 bg-danger text-white">Aguardando Documentos</h6>
										<p class="ml-2 d-inline m-0"><strong>Justificativa/Solicitação:</strong> {{ $cadastro->doc_categorias->justificativa_capacidade_tecnica }}</p>
										@endif
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
							@endif
						{{-- Fim 15 --}}
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