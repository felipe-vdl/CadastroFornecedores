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