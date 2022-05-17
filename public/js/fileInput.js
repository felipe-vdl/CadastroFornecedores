// Array com os tipos de arquivo aceitos.
const fileTypes = ['image', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xml', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'pdf'];
// Tamanho máximo de cada arquivo em bytes (1 MB = 1.000.000 bytes)
const tamanhoMaximo = 10000000; // 10 MB

/* INPUT 1: Requerimento de Inscrição. */
const dtRequerimentoInscricao = new DataTransfer(); // Allows you to manipulate the files of the input file
const requerimentoInscricaoInput = document.querySelector('#requerimento_inscricao');
const requerimentoInscricaoArea = document.querySelector('#requerimentoinscricao-area');
const requerimentoInscricaoInvalido = document.querySelector('#requerimentoinscricao-invalido');
const erroRequerimentoInscricao = document.querySelector('#erro-requerimentoinscricao');
const requerimentoInscricaoVermelho = document.querySelector('#requerimentoinscricao-vermelho');
const erroRequerimentoInscricaoGrande = document.querySelector('#erro-requerimentoinscricao-grande');
const requerimentoInscricaoGrandeSpan = document.querySelector('#requerimentoinscricao-grande');

if (requerimentoInscricaoInput) {
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
}

/* INPUT 2: Ato Constitutivo */
const dtAtoConstitutivo = new DataTransfer(); // Allows you to manipulate the files of the input file
const atoConstitutivoInput = document.querySelector('#ato_constitutivo');
const atoConstitutivoArea = document.querySelector('#atoconstitutivo-area');
const atoConstitutivoInvalido = document.querySelector('#atoconstitutivo-invalido');
const erroAtoConstitutivo = document.querySelector('#erro-atoconstitutivo');
const atoConstitutivoVermelho = document.querySelector('#atoconstitutivo-vermelho');
const erroAtoConstitutivoGrande = document.querySelector('#erro-atoconstitutivo-grande');
const atoConstitutivoGrandeSpan = document.querySelector('#atoconstitutivo-grande');

if (atoConstitutivoInput) {
    atoConstitutivoInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let atoConstitutivoInvalidos = [];
        let verifyAtoConstitutivo = null;
        atoConstitutivoInvalido.innerHTML = '';
        let atoConstitutivoGrandesArr = [];
        let verifyAtoConstitutivoGrande = null;
        atoConstitutivoGrandeSpan.innerHTML = '';
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
                atoConstitutivoInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyAtoConstitutivo = true;
                atoConstitutivoVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                atoConstitutivoGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyAtoConstitutivoGrande = true;
                atoConstitutivoVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            atoConstitutivoArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (atoConstitutivoInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroAtoConstitutivo.style.display = 'none';
            verifyAtoConstitutivo = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (atoConstitutivoGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroAtoConstitutivoGrande.style.display = 'none';
            verifyAtoConstitutivoGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtAtoConstitutivo.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyAtoConstitutivo) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let atoConstitutivo of atoConstitutivoInvalidos) {
                if (i < atoConstitutivoInvalidos.length) {
                    atoConstitutivoInvalido.append(`${atoConstitutivo}, `);
                } else {
                    atoConstitutivoInvalido.append(`${atoConstitutivo}.`)
                }
                i++;
            }
            erroAtoConstitutivo.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyAtoConstitutivoGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let atoConstitutivo of atoConstitutivoGrandesArr) {
                if (j < atoConstitutivoGrandesArr.length) {
                    atoConstitutivoGrandeSpan.append(`${atoConstitutivo}, `);
                } else {
                    atoConstitutivoGrandeSpan.append(`${atoConstitutivo}.`)
                }
                j++;
            }
            erroAtoConstitutivoGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        atoConstitutivoInput.files = dtAtoConstitutivo.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtAtoConstitutivo.items.length; i++) {
                    if (name === dtAtoConstitutivo.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtAtoConstitutivo.items.remove(i);
                    continue;
                    }
                }
                atoConstitutivoInput.files = dtAtoConstitutivo.files;
            });
        }
    });
}

/* INPUT 3: Procuração ou Carta de Credenciamento */
const dtProcuracaoCarta = new DataTransfer(); // Allows you to manipulate the files of the input file
const procuracaoCartaInput = document.querySelector('#procuracao_carta');
const procuracaoCartaArea = document.querySelector('#procuracaocarta-area');
const procuracaoCartaInvalido = document.querySelector('#procuracaocarta-invalido');
const erroProcuracaoCarta = document.querySelector('#erro-procuracaocarta');
const procuracaoCartaVermelho = document.querySelector('#procuracaocarta-vermelho');
const erroProcuracaoCartaGrande = document.querySelector('#erro-procuracaocarta-grande');
const procuracaoCartaGrandeSpan = document.querySelector('#procuracaocarta-grande');

if (procuracaoCartaInput) {
    procuracaoCartaInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let procuracaoCartaInvalidos = [];
        let verifyProcuracaoCarta = null;
        procuracaoCartaInvalido.innerHTML = '';
        let procuracaoCartaGrandesArr = [];
        let verifyProcuracaoCartaGrande = null;
        procuracaoCartaGrandeSpan.innerHTML = '';
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
                procuracaoCartaInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyProcuracaoCarta = true;
                procuracaoCartaVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                procuracaoCartaGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyProcuracaoCartaGrande = true;
                procuracaoCartaVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            procuracaoCartaArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (procuracaoCartaInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroProcuracaoCarta.style.display = 'none';
            verifyProcuracaoCarta = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (procuracaoCartaGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroProcuracaoCartaGrande.style.display = 'none';
            verifyProcuracaoCartaGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtProcuracaoCarta.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyProcuracaoCarta) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let procuracaoCarta of procuracaoCartaInvalidos) {
                if (i < procuracaoCartaInvalidos.length) {
                    procuracaoCartaInvalido.append(`${procuracaoCarta}, `);
                } else {
                    procuracaoCartaInvalido.append(`${procuracaoCarta}.`)
                }
                i++;
            }
            erroProcuracaoCarta.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyProcuracaoCartaGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let procuracaoCarta of procuracaoCartaGrandesArr) {
                if (j < procuracaoCartaGrandesArr.length) {
                    procuracaoCartaGrandeSpan.append(`${procuracaoCarta}, `);
                } else {
                    procuracaoCartaGrandeSpan.append(`${procuracaoCarta}.`)
                }
                j++;
            }
            erroProcuracaoCartaGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        procuracaoCartaInput.files = dtProcuracaoCarta.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtProcuracaoCarta.items.length; i++) {
                    if (name === dtProcuracaoCarta.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtProcuracaoCarta.items.remove(i);
                    continue;
                    }
                }
                procuracaoCartaInput.files = dtProcuracaoCarta.files;
            });
        }
    });
}

/* INPUT 4: Cédula de Identidade (RG) e CPF dos Representantes Legais */
const dtCedulaIdentidade = new DataTransfer(); // Allows you to manipulate the files of the input file
const cedulaIdentidadeInput = document.querySelector('#cedula_identidade');
const cedulaIdentidadeArea = document.querySelector('#cedulaidentidade-area');
const cedulaIdentidadeInvalido = document.querySelector('#cedulaidentidade-invalido');
const erroCedulaIdentidade = document.querySelector('#erro-cedulaidentidade');
const cedulaIdentidadeVermelho = document.querySelector('#cedulaidentidade-vermelho');
const erroCedulaIdentidadeGrande = document.querySelector('#erro-cedulaidentidade-grande');
const cedulaIdentidadeGrandeSpan = document.querySelector('#cedulaidentidade-grande');

if (cedulaIdentidadeInput) {
    cedulaIdentidadeInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let cedulaIdentidadeInvalidos = [];
        let verifyCedulaIdentidade = null;
        cedulaIdentidadeInvalido.innerHTML = '';
        let cedulaIdentidadeGrandesArr = [];
        let verifyCedulaIdentidadeGrande = null;
        cedulaIdentidadeGrandeSpan.innerHTML = '';
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
                cedulaIdentidadeInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyCedulaIdentidade = true;
                cedulaIdentidadeVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                cedulaIdentidadeGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyCedulaIdentidadeGrande = true;
                cedulaIdentidadeVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            cedulaIdentidadeArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (cedulaIdentidadeInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroCedulaIdentidade.style.display = 'none';
            verifyCedulaIdentidade = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (cedulaIdentidadeGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroCedulaIdentidadeGrande.style.display = 'none';
            verifyCedulaIdentidadeGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtCedulaIdentidade.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyCedulaIdentidade) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let cedulaIdentidade of cedulaIdentidadeInvalidos) {
                if (i < cedulaIdentidadeInvalidos.length) {
                    cedulaIdentidadeInvalido.append(`${cedulaIdentidade}, `);
                } else {
                    cedulaIdentidadeInvalido.append(`${cedulaIdentidade}.`)
                }
                i++;
            }
            erroCedulaIdentidade.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyCedulaIdentidadeGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let cedulaIdentidade of cedulaIdentidadeGrandesArr) {
                if (j < cedulaIdentidadeGrandesArr.length) {
                    cedulaIdentidadeGrandeSpan.append(`${cedulaIdentidade}, `);
                } else {
                    cedulaIdentidadeGrandeSpan.append(`${cedulaIdentidade}.`)
                }
                j++;
            }
            erroCedulaIdentidadeGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        cedulaIdentidadeInput.files = dtCedulaIdentidade.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtCedulaIdentidade.items.length; i++) {
                    if (name === dtCedulaIdentidade.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtCedulaIdentidade.items.remove(i);
                    continue;
                    }
                }
                cedulaIdentidadeInput.files = dtCedulaIdentidade.files;
            });
        }
    });
}

/* INPUT 5: Registro Entidade */
const dtRegistroEntidade = new DataTransfer(); // Allows you to manipulate the files of the input file
const registroEntidadeInput = document.querySelector('#registro_entidade');
const registroEntidadeArea = document.querySelector('#registroentidade-area');
const registroEntidadeInvalido = document.querySelector('#registroentidade-invalido');
const erroRegistroEntidade = document.querySelector('#erro-registroentidade');
const registroEntidadeVermelho = document.querySelector('#registroentidade-vermelho');
const erroRegistroEntidadeGrande = document.querySelector('#erro-registroentidade-grande');
const registroEntidadeGrandeSpan = document.querySelector('#registroentidade-grande');

if (registroEntidadeInput) {
    registroEntidadeInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let registroEntidadeInvalidos = [];
        let verifyRegistroEntidade = null;
        registroEntidadeInvalido.innerHTML = '';
        let registroEntidadeGrandesArr = [];
        let verifyRegistroEntidadeGrande = null;
        registroEntidadeGrandeSpan.innerHTML = '';
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
                registroEntidadeInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyRegistroEntidade = true;
                registroEntidadeVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                registroEntidadeGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyRegistroEntidadeGrande = true;
                registroEntidadeVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            registroEntidadeArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (registroEntidadeInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroRegistroEntidade.style.display = 'none';
            verifyRegistroEntidade = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (registroEntidadeGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroRegistroEntidadeGrande.style.display = 'none';
            verifyRegistroEntidadeGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtRegistroEntidade.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyRegistroEntidade) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let registroEntidade of registroEntidadeInvalidos) {
                if (i < registroEntidadeInvalidos.length) {
                    registroEntidadeInvalido.append(`${registroEntidade}, `);
                } else {
                    registroEntidadeInvalido.append(`${registroEntidade}.`)
                }
                i++;
            }
            erroRegistroEntidade.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyRegistroEntidadeGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let registroEntidade of registroEntidadeGrandesArr) {
                if (j < registroEntidadeGrandesArr.length) {
                    registroEntidadeGrandeSpan.append(`${registroEntidade}, `);
                } else {
                    registroEntidadeGrandeSpan.append(`${registroEntidade}.`)
                }
                j++;
            }
            erroRegistroEntidadeGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        registroEntidadeInput.files = dtRegistroEntidade.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtRegistroEntidade.items.length; i++) {
                    if (name === dtRegistroEntidade.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtRegistroEntidade.items.remove(i);
                    continue;
                    }
                }
                registroEntidadeInput.files = dtRegistroEntidade.files;
            });
        }
    });
}

/* INPUT 6: InscricaoCnpj */
const dtInscricaoCnpj = new DataTransfer(); // Allows you to manipulate the files of the input file
const inscricaoCnpjInput = document.querySelector('#inscricao_cnpj');
const inscricaoCnpjArea = document.querySelector('#inscricaocnpj-area');
const inscricaoCnpjInvalido = document.querySelector('#inscricaocnpj-invalido');
const erroInscricaoCnpj = document.querySelector('#erro-inscricaocnpj');
const inscricaoCnpjVermelho = document.querySelector('#inscricaocnpj-vermelho');
const erroInscricaoCnpjGrande = document.querySelector('#erro-inscricaocnpj-grande');
const inscricaoCnpjGrandeSpan = document.querySelector('#inscricaocnpj-grande');

if (inscricaoCnpjInput) {
    inscricaoCnpjInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let inscricaoCnpjInvalidos = [];
        let verifyInscricaoCnpj = null;
        inscricaoCnpjInvalido.innerHTML = '';
        let inscricaoCnpjGrandesArr = [];
        let verifyInscricaoCnpjGrande = null;
        inscricaoCnpjGrandeSpan.innerHTML = '';
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
                inscricaoCnpjInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyInscricaoCnpj = true;
                inscricaoCnpjVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                inscricaoCnpjGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyInscricaoCnpjGrande = true;
                inscricaoCnpjVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            inscricaoCnpjArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (inscricaoCnpjInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroInscricaoCnpj.style.display = 'none';
            verifyInscricaoCnpj = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (inscricaoCnpjGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroInscricaoCnpjGrande.style.display = 'none';
            verifyInscricaoCnpjGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtInscricaoCnpj.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyInscricaoCnpj) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let inscricaoCnpj of inscricaoCnpjInvalidos) {
                if (i < inscricaoCnpjInvalidos.length) {
                    inscricaoCnpjInvalido.append(`${inscricaoCnpj}, `);
                } else {
                    inscricaoCnpjInvalido.append(`${inscricaoCnpj}.`)
                }
                i++;
            }
            erroInscricaoCnpj.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyInscricaoCnpjGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let inscricaoCnpj of inscricaoCnpjGrandesArr) {
                if (j < inscricaoCnpjGrandesArr.length) {
                    inscricaoCnpjGrandeSpan.append(`${inscricaoCnpj}, `);
                } else {
                    inscricaoCnpjGrandeSpan.append(`${inscricaoCnpj}.`)
                }
                j++;
            }
            erroInscricaoCnpjGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        inscricaoCnpjInput.files = dtInscricaoCnpj.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtInscricaoCnpj.items.length; i++) {
                    if (name === dtInscricaoCnpj.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtInscricaoCnpj.items.remove(i);
                    continue;
                    }
                }
                inscricaoCnpjInput.files = dtInscricaoCnpj.files;
            });
        }
    });
}

/* INPUT 7: BalancoPatrimonial */
const dtBalancoPatrimonial = new DataTransfer(); // Allows you to manipulate the files of the input file
const balancoPatrimonialInput = document.querySelector('#balanco_patrimonial');
const balancoPatrimonialArea = document.querySelector('#balancopatrimonial-area');
const balancoPatrimonialInvalido = document.querySelector('#balancopatrimonial-invalido');
const erroBalancoPatrimonial = document.querySelector('#erro-balancopatrimonial');
const balancoPatrimonialVermelho = document.querySelector('#balancopatrimonial-vermelho');
const erroBalancoPatrimonialGrande = document.querySelector('#erro-balancopatrimonial-grande');
const balancoPatrimonialGrandeSpan = document.querySelector('#balancopatrimonial-grande');

if (balancoPatrimonialInput) {
    balancoPatrimonialInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let balancoPatrimonialInvalidos = [];
        let verifyBalancoPatrimonial = null;
        balancoPatrimonialInvalido.innerHTML = '';
        let balancoPatrimonialGrandesArr = [];
        let verifyBalancoPatrimonialGrande = null;
        balancoPatrimonialGrandeSpan.innerHTML = '';
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
                balancoPatrimonialInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyBalancoPatrimonial = true;
                balancoPatrimonialVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                balancoPatrimonialGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyBalancoPatrimonialGrande = true;
                balancoPatrimonialVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            balancoPatrimonialArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (balancoPatrimonialInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroBalancoPatrimonial.style.display = 'none';
            verifyBalancoPatrimonial = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (balancoPatrimonialGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroBalancoPatrimonialGrande.style.display = 'none';
            verifyBalancoPatrimonialGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtBalancoPatrimonial.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyBalancoPatrimonial) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let balancoPatrimonial of balancoPatrimonialInvalidos) {
                if (i < balancoPatrimonialInvalidos.length) {
                    balancoPatrimonialInvalido.append(`${balancoPatrimonial}, `);
                } else {
                    balancoPatrimonialInvalido.append(`${balancoPatrimonial}.`)
                }
                i++;
            }
            erroBalancoPatrimonial.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyBalancoPatrimonialGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let balancoPatrimonial of balancoPatrimonialGrandesArr) {
                if (j < balancoPatrimonialGrandesArr.length) {
                    balancoPatrimonialGrandeSpan.append(`${balancoPatrimonial}, `);
                } else {
                    balancoPatrimonialGrandeSpan.append(`${balancoPatrimonial}.`)
                }
                j++;
            }
            erroBalancoPatrimonialGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        balancoPatrimonialInput.files = dtBalancoPatrimonial.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtBalancoPatrimonial.items.length; i++) {
                    if (name === dtBalancoPatrimonial.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtBalancoPatrimonial.items.remove(i);
                    continue;
                    }
                }
                balancoPatrimonialInput.files = dtBalancoPatrimonial.files;
            });
        }
    });
}

/* INPUT 8: RegularidadeFiscal */
const dtRegularidadeFiscal = new DataTransfer(); // Allows you to manipulate the files of the input file
const regularidadeFiscalInput = document.querySelector('#regularidade_fiscal');
const regularidadeFiscalArea = document.querySelector('#regularidadefiscal-area');
const regularidadeFiscalInvalido = document.querySelector('#regularidadefiscal-invalido');
const erroRegularidadeFiscal = document.querySelector('#erro-regularidadefiscal');
const regularidadeFiscalVermelho = document.querySelector('#regularidadefiscal-vermelho');
const erroRegularidadeFiscalGrande = document.querySelector('#erro-regularidadefiscal-grande');
const regularidadeFiscalGrandeSpan = document.querySelector('#regularidadefiscal-grande');

if (regularidadeFiscalInput) {
    regularidadeFiscalInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let regularidadeFiscalInvalidos = [];
        let verifyRegularidadeFiscal = null;
        regularidadeFiscalInvalido.innerHTML = '';
        let regularidadeFiscalGrandesArr = [];
        let verifyRegularidadeFiscalGrande = null;
        regularidadeFiscalGrandeSpan.innerHTML = '';
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
                regularidadeFiscalInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyRegularidadeFiscal = true;
                regularidadeFiscalVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                regularidadeFiscalGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyRegularidadeFiscalGrande = true;
                regularidadeFiscalVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            regularidadeFiscalArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (regularidadeFiscalInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroRegularidadeFiscal.style.display = 'none';
            verifyRegularidadeFiscal = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (regularidadeFiscalGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroRegularidadeFiscalGrande.style.display = 'none';
            verifyRegularidadeFiscalGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtRegularidadeFiscal.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyRegularidadeFiscal) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let regularidadeFiscal of regularidadeFiscalInvalidos) {
                if (i < regularidadeFiscalInvalidos.length) {
                    regularidadeFiscalInvalido.append(`${regularidadeFiscal}, `);
                } else {
                    regularidadeFiscalInvalido.append(`${regularidadeFiscal}.`)
                }
                i++;
            }
            erroRegularidadeFiscal.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyRegularidadeFiscalGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let regularidadeFiscal of regularidadeFiscalGrandesArr) {
                if (j < regularidadeFiscalGrandesArr.length) {
                    regularidadeFiscalGrandeSpan.append(`${regularidadeFiscal}, `);
                } else {
                    regularidadeFiscalGrandeSpan.append(`${regularidadeFiscal}.`)
                }
                j++;
            }
            erroRegularidadeFiscalGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        regularidadeFiscalInput.files = dtRegularidadeFiscal.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtRegularidadeFiscal.items.length; i++) {
                    if (name === dtRegularidadeFiscal.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtRegularidadeFiscal.items.remove(i);
                    continue;
                    }
                }
                regularidadeFiscalInput.files = dtRegularidadeFiscal.files;
            });
        }
    });
}

/* INPUT 9: CreditoTributario */
const dtCreditoTributario = new DataTransfer(); // Allows you to manipulate the files of the input file
const creditoTributarioInput = document.querySelector('#credito_tributario');
const creditoTributarioArea = document.querySelector('#creditotributario-area');
const creditoTributarioInvalido = document.querySelector('#creditotributario-invalido');
const erroCreditoTributario = document.querySelector('#erro-creditotributario');
const creditoTributarioVermelho = document.querySelector('#creditotributario-vermelho');
const erroCreditoTributarioGrande = document.querySelector('#erro-creditotributario-grande');
const creditoTributarioGrandeSpan = document.querySelector('#creditotributario-grande');

if (creditoTributarioInput) {
    creditoTributarioInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let creditoTributarioInvalidos = [];
        let verifyCreditoTributario = null;
        creditoTributarioInvalido.innerHTML = '';
        let creditoTributarioGrandesArr = [];
        let verifyCreditoTributarioGrande = null;
        creditoTributarioGrandeSpan.innerHTML = '';
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
                creditoTributarioInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyCreditoTributario = true;
                creditoTributarioVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                creditoTributarioGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyCreditoTributarioGrande = true;
                creditoTributarioVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            creditoTributarioArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (creditoTributarioInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroCreditoTributario.style.display = 'none';
            verifyCreditoTributario = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (creditoTributarioGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroCreditoTributarioGrande.style.display = 'none';
            verifyCreditoTributarioGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtCreditoTributario.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyCreditoTributario) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let creditoTributario of creditoTributarioInvalidos) {
                if (i < creditoTributarioInvalidos.length) {
                    creditoTributarioInvalido.append(`${creditoTributario}, `);
                } else {
                    creditoTributarioInvalido.append(`${creditoTributario}.`)
                }
                i++;
            }
            erroCreditoTributario.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyCreditoTributarioGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let creditoTributario of creditoTributarioGrandesArr) {
                if (j < creditoTributarioGrandesArr.length) {
                    creditoTributarioGrandeSpan.append(`${creditoTributario}, `);
                } else {
                    creditoTributarioGrandeSpan.append(`${creditoTributario}.`)
                }
                j++;
            }
            erroCreditoTributarioGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        creditoTributarioInput.files = dtCreditoTributario.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtCreditoTributario.items.length; i++) {
                    if (name === dtCreditoTributario.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtCreditoTributario.items.remove(i);
                    continue;
                    }
                }
                creditoTributarioInput.files = dtCreditoTributario.files;
            });
        }
    });
}

/* INPUT 10: DebitoEstadual */
const dtDebitoEstadual = new DataTransfer(); // Allows you to manipulate the files of the input file
const debitoEstadualInput = document.querySelector('#debito_estadual');
const debitoEstadualArea = document.querySelector('#debitoestadual-area');
const debitoEstadualInvalido = document.querySelector('#debitoestadual-invalido');
const erroDebitoEstadual = document.querySelector('#erro-debitoestadual');
const debitoEstadualVermelho = document.querySelector('#debitoestadual-vermelho');
const erroDebitoEstadualGrande = document.querySelector('#erro-debitoestadual-grande');
const debitoEstadualGrandeSpan = document.querySelector('#debitoestadual-grande');

if (debitoEstadualInput) {
    debitoEstadualInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let debitoEstadualInvalidos = [];
        let verifyDebitoEstadual = null;
        debitoEstadualInvalido.innerHTML = '';
        let debitoEstadualGrandesArr = [];
        let verifyDebitoEstadualGrande = null;
        debitoEstadualGrandeSpan.innerHTML = '';
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
                debitoEstadualInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyDebitoEstadual = true;
                debitoEstadualVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                debitoEstadualGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyDebitoEstadualGrande = true;
                debitoEstadualVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            debitoEstadualArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (debitoEstadualInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroDebitoEstadual.style.display = 'none';
            verifyDebitoEstadual = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (debitoEstadualGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroDebitoEstadualGrande.style.display = 'none';
            verifyDebitoEstadualGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtDebitoEstadual.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyDebitoEstadual) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let debitoEstadual of debitoEstadualInvalidos) {
                if (i < debitoEstadualInvalidos.length) {
                    debitoEstadualInvalido.append(`${debitoEstadual}, `);
                } else {
                    debitoEstadualInvalido.append(`${debitoEstadual}.`)
                }
                i++;
            }
            erroDebitoEstadual.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyDebitoEstadualGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let debitoEstadual of debitoEstadualGrandesArr) {
                if (j < debitoEstadualGrandesArr.length) {
                    debitoEstadualGrandeSpan.append(`${debitoEstadual}, `);
                } else {
                    debitoEstadualGrandeSpan.append(`${debitoEstadual}.`)
                }
                j++;
            }
            erroDebitoEstadualGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        debitoEstadualInput.files = dtDebitoEstadual.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtDebitoEstadual.items.length; i++) {
                    if (name === dtDebitoEstadual.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtDebitoEstadual.items.remove(i);
                    continue;
                    }
                }
                debitoEstadualInput.files = dtDebitoEstadual.files;
            });
        }
    });
}

/* INPUT 11: DebitoMunicipal */
const dtDebitoMunicipal = new DataTransfer(); // Allows you to manipulate the files of the input file
const debitoMunicipalInput = document.querySelector('#debito_municipal');
const debitoMunicipalArea = document.querySelector('#debitomunicipal-area');
const debitoMunicipalInvalido = document.querySelector('#debitomunicipal-invalido');
const erroDebitoMunicipal = document.querySelector('#erro-debitomunicipal');
const debitoMunicipalVermelho = document.querySelector('#debitomunicipal-vermelho');
const erroDebitoMunicipalGrande = document.querySelector('#erro-debitomunicipal-grande');
const debitoMunicipalGrandeSpan = document.querySelector('#debitomunicipal-grande');

if (debitoMunicipalInput) {
    debitoMunicipalInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let debitoMunicipalInvalidos = [];
        let verifyDebitoMunicipal = null;
        debitoMunicipalInvalido.innerHTML = '';
        let debitoMunicipalGrandesArr = [];
        let verifyDebitoMunicipalGrande = null;
        debitoMunicipalGrandeSpan.innerHTML = '';
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
                debitoMunicipalInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyDebitoMunicipal = true;
                debitoMunicipalVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                debitoMunicipalGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyDebitoMunicipalGrande = true;
                debitoMunicipalVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            debitoMunicipalArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (debitoMunicipalInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroDebitoMunicipal.style.display = 'none';
            verifyDebitoMunicipal = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (debitoMunicipalGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroDebitoMunicipalGrande.style.display = 'none';
            verifyDebitoMunicipalGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtDebitoMunicipal.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyDebitoMunicipal) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let debitoMunicipal of debitoMunicipalInvalidos) {
                if (i < debitoMunicipalInvalidos.length) {
                    debitoMunicipalInvalido.append(`${debitoMunicipal}, `);
                } else {
                    debitoMunicipalInvalido.append(`${debitoMunicipal}.`)
                }
                i++;
            }
            erroDebitoMunicipal.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyDebitoMunicipalGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let debitoMunicipal of debitoMunicipalGrandesArr) {
                if (j < debitoMunicipalGrandesArr.length) {
                    debitoMunicipalGrandeSpan.append(`${debitoMunicipal}, `);
                } else {
                    debitoMunicipalGrandeSpan.append(`${debitoMunicipal}.`)
                }
                j++;
            }
            erroDebitoMunicipalGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        debitoMunicipalInput.files = dtDebitoMunicipal.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtDebitoMunicipal.items.length; i++) {
                    if (name === dtDebitoMunicipal.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtDebitoMunicipal.items.remove(i);
                    continue;
                    }
                }
                debitoMunicipalInput.files = dtDebitoMunicipal.files;
            });
        }
    });
}

/* INPUT 12: FalenciaConcordata */
const dtFalenciaConcordata = new DataTransfer(); // Allows you to manipulate the files of the input file
const falenciaConcordataInput = document.querySelector('#falencia_concordata');
const falenciaConcordataArea = document.querySelector('#falenciaconcordata-area');
const falenciaConcordataInvalido = document.querySelector('#falenciaconcordata-invalido');
const erroFalenciaConcordata = document.querySelector('#erro-falenciaconcordata');
const falenciaConcordataVermelho = document.querySelector('#falenciaconcordata-vermelho');
const erroFalenciaConcordataGrande = document.querySelector('#erro-falenciaconcordata-grande');
const falenciaConcordataGrandeSpan = document.querySelector('#falenciaconcordata-grande');

if (falenciaConcordataInput) {
    falenciaConcordataInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let falenciaConcordataInvalidos = [];
        let verifyFalenciaConcordata = null;
        falenciaConcordataInvalido.innerHTML = '';
        let falenciaConcordataGrandesArr = [];
        let verifyFalenciaConcordataGrande = null;
        falenciaConcordataGrandeSpan.innerHTML = '';
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
                falenciaConcordataInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyFalenciaConcordata = true;
                falenciaConcordataVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                falenciaConcordataGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyFalenciaConcordataGrande = true;
                falenciaConcordataVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            falenciaConcordataArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (falenciaConcordataInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroFalenciaConcordata.style.display = 'none';
            verifyFalenciaConcordata = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (falenciaConcordataGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroFalenciaConcordataGrande.style.display = 'none';
            verifyFalenciaConcordataGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtFalenciaConcordata.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyFalenciaConcordata) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let falenciaConcordata of falenciaConcordataInvalidos) {
                if (i < falenciaConcordataInvalidos.length) {
                    falenciaConcordataInvalido.append(`${falenciaConcordata}, `);
                } else {
                    falenciaConcordataInvalido.append(`${falenciaConcordata}.`)
                }
                i++;
            }
            erroFalenciaConcordata.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyFalenciaConcordataGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let falenciaConcordata of falenciaConcordataGrandesArr) {
                if (j < falenciaConcordataGrandesArr.length) {
                    falenciaConcordataGrandeSpan.append(`${falenciaConcordata}, `);
                } else {
                    falenciaConcordataGrandeSpan.append(`${falenciaConcordata}.`)
                }
                j++;
            }
            erroFalenciaConcordataGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        falenciaConcordataInput.files = dtFalenciaConcordata.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtFalenciaConcordata.items.length; i++) {
                    if (name === dtFalenciaConcordata.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtFalenciaConcordata.items.remove(i);
                    continue;
                    }
                }
                falenciaConcordataInput.files = dtFalenciaConcordata.files;
            });
        }
    });
}

/* INPUT 13: DebitoTrabalhista */
const dtDebitoTrabalhista = new DataTransfer(); // Allows you to manipulate the files of the input file
const debitoTrabalhistaInput = document.querySelector('#debito_trabalhista');
const debitoTrabalhistaArea = document.querySelector('#debitotrabalhista-area');
const debitoTrabalhistaInvalido = document.querySelector('#debitotrabalhista-invalido');
const erroDebitoTrabalhista = document.querySelector('#erro-debitotrabalhista');
const debitoTrabalhistaVermelho = document.querySelector('#debitotrabalhista-vermelho');
const erroDebitoTrabalhistaGrande = document.querySelector('#erro-debitotrabalhista-grande');
const debitoTrabalhistaGrandeSpan = document.querySelector('#debitotrabalhista-grande');

if (debitoTrabalhistaInput) {
    debitoTrabalhistaInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let debitoTrabalhistaInvalidos = [];
        let verifyDebitoTrabalhista = null;
        debitoTrabalhistaInvalido.innerHTML = '';
        let debitoTrabalhistaGrandesArr = [];
        let verifyDebitoTrabalhistaGrande = null;
        debitoTrabalhistaGrandeSpan.innerHTML = '';
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
                debitoTrabalhistaInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyDebitoTrabalhista = true;
                debitoTrabalhistaVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                debitoTrabalhistaGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyDebitoTrabalhistaGrande = true;
                debitoTrabalhistaVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            debitoTrabalhistaArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (debitoTrabalhistaInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroDebitoTrabalhista.style.display = 'none';
            verifyDebitoTrabalhista = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (debitoTrabalhistaGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroDebitoTrabalhistaGrande.style.display = 'none';
            verifyDebitoTrabalhistaGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtDebitoTrabalhista.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyDebitoTrabalhista) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let debitoTrabalhista of debitoTrabalhistaInvalidos) {
                if (i < debitoTrabalhistaInvalidos.length) {
                    debitoTrabalhistaInvalido.append(`${debitoTrabalhista}, `);
                } else {
                    debitoTrabalhistaInvalido.append(`${debitoTrabalhista}.`)
                }
                i++;
            }
            erroDebitoTrabalhista.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyDebitoTrabalhistaGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let debitoTrabalhista of debitoTrabalhistaGrandesArr) {
                if (j < debitoTrabalhistaGrandesArr.length) {
                    debitoTrabalhistaGrandeSpan.append(`${debitoTrabalhista}, `);
                } else {
                    debitoTrabalhistaGrandeSpan.append(`${debitoTrabalhista}.`)
                }
                j++;
            }
            erroDebitoTrabalhistaGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        debitoTrabalhistaInput.files = dtDebitoTrabalhista.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtDebitoTrabalhista.items.length; i++) {
                    if (name === dtDebitoTrabalhista.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtDebitoTrabalhista.items.remove(i);
                    continue;
                    }
                }
                debitoTrabalhistaInput.files = dtDebitoTrabalhista.files;
            });
        }
    });
}

/* INPUT 13: CapacidadeTecnica */
const dtCapacidadeTecnica = new DataTransfer(); // Allows you to manipulate the files of the input file
const capacidadeTecnicaInput = document.querySelector('#capacidade_tecnica');
const capacidadeTecnicaArea = document.querySelector('#capacidadetecnica-area');
const capacidadeTecnicaInvalido = document.querySelector('#capacidadetecnica-invalido');
const erroCapacidadeTecnica = document.querySelector('#erro-capacidadetecnica');
const capacidadeTecnicaVermelho = document.querySelector('#capacidadetecnica-vermelho');
const erroCapacidadeTecnicaGrande = document.querySelector('#erro-capacidadetecnica-grande');
const capacidadeTecnicaGrandeSpan = document.querySelector('#capacidadetecnica-grande');

if(capacidadeTecnicaInput) {
    capacidadeTecnicaInput.addEventListener('change', function(e) {
        // Limpa os nomes de arquivo do último input feito pelo usuário.
        let capacidadeTecnicaInvalidos = [];
        let verifyCapacidadeTecnica = null;
        capacidadeTecnicaInvalido.innerHTML = '';
        let capacidadeTecnicaGrandesArr = [];
        let verifyCapacidadeTecnicaGrande = null;
        capacidadeTecnicaGrandeSpan.innerHTML = '';
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
                capacidadeTecnicaInvalidos.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyCapacidadeTecnica = true;
                capacidadeTecnicaVermelho.style.display = 'block';
            } else if (this.files[i].size > tamanhoMaximo) {
                capacidadeTecnicaGrandesArr.push(this.files[i].name);
                fileName.classList.add('text-danger');
                fileDelete.classList.add('text-danger');
                verifyCapacidadeTecnicaGrande = true;
                capacidadeTecnicaVermelho.style.display = 'block';
            }
            fileBlock.append(fileDelete, fileName);
            capacidadeTecnicaArea.append(fileBlock);
        }
        // Checa a existência de atestados inválidos.
        if (capacidadeTecnicaInvalidos.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroCapacidadeTecnica.style.display = 'none';
            verifyCapacidadeTecnica = false;
        }
        // Checa a existência de atestados com tamanho maior que o permitido.
        if (capacidadeTecnicaGrandesArr.length === 0) {
            // Caso todos os arquivos sejam válidos, esconde a mensagem de erro e atribui false para presença de atestados inválidos.
            erroCapacidadeTecnicaGrande.style.display = 'none';
            verifyCapacidadeTecnicaGrande = false;
        }
        // Guarda os arquivos no objeto de DataTransfer.
        for (let file of this.files) {
            // Checa validez do tipo de arquivo antes de inserir.
            if (fileTypes.some(el => file.type.includes(el))) {
                if (file.size < tamanhoMaximo) {
                    dtCapacidadeTecnica.items.add(file);
                }
            }
        }
        // Checa o status de presença de arquivos inválidos.
        let i = 1; // Variável de controle da formatação.
        if (verifyCapacidadeTecnica) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let capacidadeTecnica of capacidadeTecnicaInvalidos) {
                if (i < capacidadeTecnicaInvalidos.length) {
                    capacidadeTecnicaInvalido.append(`${capacidadeTecnica}, `);
                } else {
                    capacidadeTecnicaInvalido.append(`${capacidadeTecnica}.`)
                }
                i++;
            }
            erroCapacidadeTecnica.style.display = 'block';
            this.value = '';
        }
        // Checa o status de presença de arquivos maiores que o tamanho máximo.
        let j = 1; // Variável de controle da formatação.
        if (verifyCapacidadeTecnicaGrande) {
            // Caso existam arquivos inválidos, insere o nome de cada arquivo inválido no alerta de erro da view.
            for (let capacidadeTecnica of capacidadeTecnicaGrandesArr) {
                if (j < capacidadeTecnicaGrandesArr.length) {
                    capacidadeTecnicaGrandeSpan.append(`${capacidadeTecnica}, `);
                } else {
                    capacidadeTecnicaGrandeSpan.append(`${capacidadeTecnica}.`)
                }
                j++;
            }
            erroCapacidadeTecnicaGrande.style.display = 'block';
            this.value = '';
        }
        // Atualiza os arquivos do input.
        capacidadeTecnicaInput.files = dtCapacidadeTecnica.files;
        // Atribui evento no botão de deletar arquivo.
        let deleteButtons = document.querySelectorAll('.file-delete');
        for (let button of deleteButtons) {
            button.addEventListener('click', function (e) {
                let name = this.nextElementSibling.innerHTML;
                // Remove o nome do arquivo da página.
                this.parentElement.remove();
                
                for(let i = 0; i < dtCapacidadeTecnica.items.length; i++) {
                    if (name === dtCapacidadeTecnica.items[i].getAsFile().name) {
                    // Delete file on DataTransfer Object.
                    dtCapacidadeTecnica.items.remove(i);
                    continue;
                    }
                }
                capacidadeTecnicaInput.files = dtCapacidadeTecnica.files;
            });
        }
    });
}