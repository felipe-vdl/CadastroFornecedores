@extends('layouts.app')

@section('content')
	<div class="container" style="padding-bottom: 150px;">
		<form method="POST" action="{{url('/')}}" enctype="multipart/form-data" id="form_cadastro">
			{{ csrf_field() }}
			<div class="card bg-light">
				<div class="card-header">
					<h2 class="card-title m-0 text-center">Cadastro de Fornecedores</h2>
				</div>
				<div class="card-body">
					@if(session()->get('error'))
					<div class="alert alert-danger m-0">
						<h5 class="alert-heading">Erro ao criar o cadastro.</h5>
						{{ session()->get('error') }}
					</div><br/>
					@endif
					<h3 class="card-title mb-1 text-center" title="Campos obrigatórios.">Dados da Empresa</h3>
					<div class="row">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Razão Social: *</label>
							<input id="razao_social" name="razao_social" class="form-control form-control-sm" type="text" placeholder="Nome Comercial, Firma Empresarial ou Denominação Social" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">CNPJ: *</label>
							<input id="cnpj" name="cnpj" class="form-control form-control-sm" type="text" placeholder="11.111.111/1111-11" minlength="18" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo opcional.">Inscrição Municipal:</label>
							<input id="inscricao_municipal" name="inscricao_municipal" class="form-control form-control-sm" type="text" placeholder="N° da Inscrição Municipal">
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo opcional.">Inscrição Estadual:</label>
							<input id="inscricao_estadual" name="inscricao_estadual" class="form-control form-control-sm" type="text" placeholder="N° da Inscrição Estadual">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Porte da Empresa: *</label>
							<input id="porte_empresa" name="porte_empresa" class="form-control form-control-sm" type="text" placeholder="MEI, ME, EPP, etc." required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo opcional.">CNAE (Atividade Econômica):</label>
							<input id="cnae" name="cnae" class="form-control form-control-sm" type="text" placeholder="Código ou Atividade">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Produtos e Serviços Ofertados: *</label>
							<input id="produtos" name="produtos" class="form-control form-control-sm" type="text" placeholder="Produtos e Serviços Ofertados pelo Fornecedor." required>
						</div>
					</div>
					<h3 class="card-title mb-1 mt-4 text-center" title="Campos obrigatórios.">Endereço</h3>
					<div class="row mt-3">
						<div class="form-group col-12 col-md-2">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">CEP: *</label>
							<input id="cep" name="cep" onblur="pesquisacep(this.value);" class="form-control form-control-sm" type="text" placeholder="CEP" maxlength="9" required>
						</div>
						<div class="form-group col-12 col-md-3">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Logradouro: *</label>
							<input id="rua" name="rua" class="form-control form-control-sm" type="text" placeholder="Rua/Avenida" required>
						</div>
						<div class="form-group col-12 col-md-2">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Nº: *</label>
							<input id="numero_rua" name="numero_rua" class="form-control form-control-sm" type="text" placeholder="Número" required>
						</div>
						<div class="form-group col-12 col-md-3">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Bairro: *</label>
							<input id="bairro" name="bairro" class="form-control form-control-sm" type="text" placeholder="Bairro" required>
						</div>
						<div class="form-group col-12 col-md-2">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Município: *</label>
							<input id="municipio" name="municipio" class="form-control form-control-sm" type="text" placeholder="Município" required>
						</div>
					</div>
					<h3 class="card-title mb-1 mt-4 text-center" title="Campos obrigatórios.">Contato</h3>
					<div class="row mt-2">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">E-mail: *</label>
							<input id="email" name="email" class="form-control form-control-sm" type="text" placeholder="E-mail para Contato" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold" title="Campo obrigatório.">Telefone: *</label>
							<input id="telefone" name="telefone" class="form-control form-control-sm" type="text" placeholder="Telefone para Contato" required>
						</div>
					</div>
					<div class="mt-4">
						<h3 class="card-title mb-0 mt-3 text-center" title="Campos obrigatórios.">Documentos Necessários</h3>
						<p style="font-size: 14px;" class="text-danger font-weight-bold mb-0">Atenção:</p>
						<ul class="text-danger">
							<li><span class="font-weight-bold">Tipos de arquivo aceitos:</span> Imagem ou documento.</li>
							<li><span class="font-weight-bold">Tamanho limite por arquivo:</span> 10MB.</li>
							<li><span class="font-weight-bold">Certifique-se de que as fotos/documentos são legíveis.</span></li>
							<li><span class="font-weight-bold">Insira os documentos de acordo com a categoria.</span></li>
							<li><span class="font-weight-bold">Todos os documentos devem estar devidamente autenticados em cartório, ou ainda, caso necessário, conferidos na própria CPL, por servidor habilitado.</span></li>
						</ul>
					</div>
					{{-- 1) Requerimento de Inscrição --}}
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
					</div>
					{{-- Fim 1 --}}
					{{-- 2) Ato Constitutivo (Contrato Social, Estatuto, Ata de Reunião) --}}
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
					</div>
					{{-- Fim 2 --}}
					{{-- 3) Procuração ou Carta de Credenciamento--}}
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
					</div>
					{{-- Fim 3 --}}
					{{-- 4) Cédula de Identidade (RG) e CPF dos Reprentantes Legais --}}
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
					</div>
					{{-- Fim 4 --}}
					{{-- 5) Registro ou Inscrição na Entidade Profissional Competente: --}}
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
					</div>
					{{-- Fim 5 --}}
					{{-- 6) Registro ou Inscrição na Entidade Profissional Competente: --}}
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
					</div>
					{{-- Fim 6 --}}
					{{-- 7) Cadastro Contribuinte: --}}
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
					</div>
					{{-- Fim 7 --}}
					{{-- 8) Balanço Patrimonial: --}}
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
					</div>
					{{-- Fim 8 --}}
					{{-- 9) Regularidade Fiscal: --}}
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
					</div>
					{{-- Fim 9 --}}
					{{-- 10) Crédito Tributário: --}}
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
					</div>
					{{-- Fim 10 --}}
					{{-- 11) Debito Estadual: --}}
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
					</div>
					{{-- Fim 11 --}}
					{{-- 12) Debito Municipal: --}}
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
					</div>
					{{-- Fim 12 --}}
					{{-- 13) Debito Municipal: --}}
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
					</div>
					{{-- Fim 13 --}}
					{{-- 14) Debito Trabalhista: --}}
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
					</div>
					{{-- Fim 14 --}}
					{{-- 15) Capacidade Técnica: --}}
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
					</div>
					{{-- Fim 15 --}}
				</div>
				<div class="card-footer">
					<center>
						<div>
							<button type="submit" id="form_cadastro" class="botoes-acao btn btn-round btn-success enviar-relatorio">
								<span class="icone-botoes-acao mdi mdi-send"></span>
								<span class="texto-botoes-acao">Enviar Cadastro</span>
								<div class="ripple-container"></div>
							</button>
						</div> 
					</center>
				</div>
			</div>
		</form>
	</div>
	<div class="container" style="padding-top: 30px">
		@include('layouts.footer')
	</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			VMasker ($("#cnpj")).maskPattern("99.999.999/9999-99");
			VMasker ($("#telefone")).maskPattern("(99)9999-99999");
			VMasker ($("#cep")).maskPattern("99999-999");
		});
	</script>
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
	<!-- Via CEP -->
    <script>
		function limpa_formulário_cep() {
			//Limpa valores do formulário de cep.
			document.getElementById('rua').value=("");
			document.getElementById('bairro').value=("");
			document.getElementById('municipio').value=("");
		}
	
		function meu_callback(conteudo) {
			if (!("erro" in conteudo)) {
				//Atualiza os campos com os valores.
				document.getElementById('rua').value=(conteudo.logradouro);
				document.getElementById('bairro').value=(conteudo.bairro);
				document.getElementById('municipio').value=(conteudo.localidade);
			} //end if.
			else {
				//CEP não Encontrado.
			}
		}
			
		function pesquisacep(valor) {
	
			//Nova variável "cep" somente com dígitos.
			let cep = valor.replace(/\D/g, '');
	
			//Verifica se campo cep possui valor informado.
			if (cep != "") {
	
				//Expressão regular para validar o CEP.
				var validacep = /^[0-9]{8}$/;
	
				//Valida o formato do CEP.
				if(validacep.test(cep)) {
	
					//Preenche os campos com "..." enquanto consulta webservice.
					document.getElementById('rua').value="...";
					document.getElementById('bairro').value="...";
					document.getElementById('municipio').value="...";

					//Cria um elemento javascript.
					let script = document.createElement('script');
	
					//Sincroniza com o callback.
					script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
	
					//Insere script no documento e carrega o conteúdo.
					document.body.appendChild(script);
	
				} //end if.
				else {
					//cep é inválido.
					limpa_formulário_cep();
					alert("Formato de CEP inválido.");
				}
			} //end if.
			else {
				//cep sem valor, limpa formulário.
				limpa_formulário_cep();
			}
		};
	
		</script>
	<script src="{{ asset('js/fileInput.js') }}" defer></script>
@endpush