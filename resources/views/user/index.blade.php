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
		
	</script>

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

	<script type="text/javascript">
		// Array com os tipos de arquivo aceitos.
        const fileTypes = ['image', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'pdf'];
        // Tamanho máximo de cada arquivo em bytes (1 MB = 1.000.000 bytes)
        const tamanhoMaximo = 10000000; // 10 MB

		// Input 1: Requerimento de Inscrição.
        const dtRequerimentoInscricao = new DataTransfer(); // Allows you to manipulate the files of the input file
        const requerimentoInscricaoInput = document.querySelector('#requerimento_inscricao');
        const requerimentoInscricaoArea = document.querySelector('#requerimentoinscricao-area');
        const requerimentoInscricaoInvalido = document.querySelector('#requerimentoinscricao-invalido');
        const erroRequerimentoInscricao = document.querySelector('#erro-requerimentoinscricao');
        const requerimentoInscricaoVermelho = document.querySelector('#requerimentoinscricao-vermelho');
        const erroRequerimentoInscricaoGrande = document.querySelector('#erro-requerimentoinscricao-grande');
        const requerimentoInscricaoGrandeSpan = document.querySelector('#requerimentoinscricao-grande');
		
        requerimentoInscricaoInput.addEventListener('change', function(e) {
            // Limpa os nomes de arquivo do último input feito pelo usuário.
            let requerimentoInscricaoInvalidos = [];
            let verifyRequerimentoInscricao = null;
            requerimentoInscricaoInvalido.innerHTML = '';
            let requerimentoInscricaoGrandesArr = [];
            let verifyRequerimentoInscricaoGrande = null;
            requerimentoInscricaoGrandeSpan.innerHTML = '';
            // Nome do arquivo e botão de deletar.
            for(let i = 0; i < this.files.length; i++) {
                let fileBlock = document.createElement('span');
                fileBlock.classList.add('file-block');
                
                let fileName = document.createElement('span');
                fileName.classList.add('name');
                fileName.innerHTML = `${this.files.item(i).name}`;
                
                let fileDelete = document.createElement('span');
                fileDelete.classList.add('file-delete');
                fileDelete.innerHTML = '<span>X</span>';
                // Checa a validez do tipo do arquivo inserido.
                if (!fileTypes.some(el => this.files[i].type.includes(el))) {
                    // Caso exista um arquivo inválido, insere nome dos arquivos inválidos na array e atribui true para a presença de atestados inválidos.
                    requerimentoInscricaoInvalidos.push(this.files[i].name);
                    fileName.classList.add('text-danger');
                    fileDelete.classList.add('text-danger');
                    verifyRequerimentoInscricao = true;
                    requerimentoInscricaoVermelho.style.display = 'block';
                } else if (this.files[i].size > tamanhoMaximo) {
                    requerimentoInscricaoGrandesArr.push(this.files[i].name);
                    fileName.classList.add('text-danger');
                    fileDelete.classList.add('text-danger');
                    verifyRequerimentoInscricaoGrande = true;
                    requerimentoInscricaoVermelho.style.display = 'block';
                }
                fileBlock.append(fileDelete, fileName);
                requerimentoInscricaoArea.append(fileBlock);
            }
            // Checa a existência de atestados inválidos.
            if (requerimentoInscricaoInvalidos.length === 0) {
                // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
                erroRequerimentoInscricao.style.display = 'none';
                verifyRequerimentoInscricao = false;
            }
            // Checa a existência de atestados com tamanho maior que o permitido.
            if (requerimentoInscricaoGrandesArr.length === 0) {
                // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
                erroRequerimentoInscricaoGrande.style.display = 'none';
                verifyRequerimentoInscricaoGrande = false;
            }
            // Guarda os arquivos no objeto de DataTransfer.
            for (let file of this.files) {
                // Checa validez do tipo de arquivo antes de inserir.
                if (fileTypes.some(el => file.type.includes(el))) {
                    if (file.size < tamanhoMaximo) {
                        dtRequerimentoInscricao.items.add(file);
                    }
                }
            }
            // Checa o status de presença de arquivos inválidos.
            let i = 1; // Variável de controle da formatação.
            if (verifyRequerimentoInscricao) {
                // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
                for (let requerimentoInscricao of requerimentoInscricaoInvalidos) {
                    if (i < requerimentoInscricaoInvalidos.length) {
                        requerimentoInscricaoInvalido.append(`${requerimentoInscricao}, `);
                    } else {
                        requerimentoInscricaoInvalido.append(`${requerimentoInscricao}.`)
                    }
                    i++;
                }
                erroRequerimentoInscricao.style.display = 'block';
                this.value = '';
            }
            // Checa o status de presença de arquivos maiores que o tamanho máximo.
            let j = 1; // Variável de controle da formatação.
            if (verifyRequerimentoInscricaoGrande) {
                // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
                for (let requerimentoInscricao of requerimentoInscricaoGrandesArr) {
                    if (j < requerimentoInscricaoGrandesArr.length) {
                        requerimentoInscricaoGrandeSpan.append(`${requerimentoInscricao}, `);
                    } else {
                        requerimentoInscricaoGrandeSpan.append(`${requerimentoInscricao}.`)
                    }
                    j++;
                }
                erroRequerimentoInscricaoGrande.style.display = 'block';
                this.value = '';
            }
            // Atualiza os arquivos do input.
            requerimentoInscricaoInput.files = dtRequerimentoInscricao.files;
            // Atribui evento no botão de deletar arquivo.
            let deleteButtons = document.querySelectorAll('.file-delete');
            for (let button of deleteButtons) {
                button.addEventListener('click', function (e) {
                    let name = this.nextElementSibling.innerHTML;
                    // Remove o nome do arquivo da página.
                    this.parentElement.remove();
                    
                    for(let i = 0; i < dtRequerimentoInscricao.items.length; i++) {
                        if (name === dtRequerimentoInscricao.items[i].getAsFile().name) {
                            // Delete file on DataTransfer Object.
                            dtRequerimentoInscricao.items.remove(i);
                            continue;
                        }
                    }
                    requerimentoInscricaoInput.files = dtRequerimentoInscricao.files;
                });
            }
        });
	</script>
@endpush
