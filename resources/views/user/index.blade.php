@extends('layouts.app')

@section('content')
	<div class="container">
		<form method="POST" action="{{url('/cadastro')}}" enctype="multipart/form-data" id="form_cadastro">
			{{ csrf_field() }}
			<div class="card bg-light">
				<div class="card-header">
					<h2 class="card-title m-0 text-center">Cadastro de Fornecedores</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold">Razão Social:</label>
							<input id="razao_social" name="razao_social" class="form-control form-control-sm" type="text" placeholder="Nome Comercial, Firma Empresarial ou Denominação Social" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold">CNPJ:</label>
							<input id="cnpj" name="cnpj" class="form-control form-control-sm" type="text" placeholder="11.111.111/1111-11" minlength="18" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold">Porte da Empresa:</label>
							<input id="porte_empresa" name="porte_empresa" class="form-control form-control-sm" type="text" placeholder="MEI, ME, EPP, etc." required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold">CNAE (Atividade Econômica):</label>
							<input id="cnae" name="cnae" class="form-control form-control-sm" type="text" placeholder="1111-1/11" minlength="9" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12">
							<label class="form-label font-weight-bold">Produtos e Serviços Ofertados:</label>
							<input id="produtos" name="produtos" class="form-control form-control-sm" type="text" placeholder="Produtos e Serviços Ofertados pelo Fornecedor." required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12">
							<label class="form-label font-weight-bold">Endereço:</label>
							<input id="endereco" name="endereco" class="form-control form-control-sm" type="text" placeholder="Ex.: R. Arthur Oliveira Vechi, 120 - Centro, Mesquita - RJ, 26553-080" required>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold">E-mail:</label>
							<input id="email" name="email" class="form-control form-control-sm" type="text" placeholder="E-mail para Contato" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label class="form-label font-weight-bold">Telefone:</label>
							<input id="telefone" name="telefone" class="form-control form-control-sm" type="text" placeholder="Telefone para Contato" required>
						</div>
					</div>
					<div class="mt-3">
						<h4 class="card-title mb-0 mt-3 text-center">Documentos Necessários:</h4>
						<p style="font-size: 14px;" class="text-danger font-weight-bold mb-0">Atenção:</p>
						<ul class="text-danger">
							<li><span class="font-weight-bold">Tipos de arquivo aceitos:</span> Imagem ou documento.</li>
							<li><span class="font-weight-bold">Tamanho limite por arquivo:</span> 10MB.</li>
							<li><span class="font-weight-bold">Certifique-se de que as fotos/documentos são legíveis.</span></li>
							<li><span class="font-weight-bold">Insira os documentos de acordo com a categoria.</span></li>
						</ul>
					</div>
					{{-- 1) Requerimento de Inscrição --}}
					<div class="col-12 mt-3">
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
					{{-- 2) Ato Constitutivo (Contrato Social, Estatuto, Ata de Reunião) --}}
					{{-- Em Construção --}}
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
			VMasker ($("#cnae")).maskPattern("9999-9/99");
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
	<script src="{{ asset('js/fileInput.js') }}" defer></script>
@endpush