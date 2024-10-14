import {
    criandoHtmlmensagemCarregamento,
    Toasty
} from "../../base/jsGeral.js";
////////////////////////////////////////////////////////////////////////////
//parte de pesquisa
var dataInicio, dataFim, statusPesquisa, DepartamentoPesquisa;
function recuperaDadosDePesquisa() {
    dataInicio = $('#dataInicio').val();
    dataFim = $('#datafim').val();
    statusPesquisa = $('#statusPesquisa').val();
    DepartamentoPesquisa = $('#departamentoPesquisa').val();
    if (!statusPesquisa) {
        statusPesquisa = 'NOVO';
    }

    console.log("Data Início:", dataInicio);
    console.log("Data Fim:", dataFim);
    console.log("Status:", statusPesquisa);
    console.log("DepartamentoPesquisa:", DepartamentoPesquisa);
}
function chamaTelaDePesquisa(dataInicio, dataFim, statusPesquisa,DepartamentoPesquisa, idPesquisaDireta) {
    let dadosDeQuemEstaLogadoCENTROCUSTO = $('#dadosDeQuemEstaLogadoCENTROCUSTO').val();

    $.ajax({
        url: "config/PesquisarGerenciamentoCotacao.php",
        method: 'POST',
        data: {
            dataInicio: dataInicio,
            dataFim: dataFim,
            statusPesquisa: statusPesquisa,
            dadosDeQuemEstaLogadoCENTROCUSTO: dadosDeQuemEstaLogadoCENTROCUSTO,
            DepartamentoPesquisa: DepartamentoPesquisa,
            idPesquisaDireta : idPesquisaDireta
        },
        success: function (tabelaAtualizada) {
            $('.TabelaAcompanhamentoGerenciamentoCotacao').empty().html(tabelaAtualizada);
            // Recalcula as colunas
            $('#TabelaAcompanhamentoGerenciamentoCotacao').DataTable().columns.adjust();
            criandoHtmlmensagemCarregamento("ocultar");

        }
    });
}
////////////////////////////////////////////////////////////////////////////-
function DefineCorStatus(status) {
    switch (status) {
        case 'NOVO':
            return '#007bff'; // Azul
        case 'APROVADO':
            return '#28a745'; // Verde
        case 'REPROVADO':
            return '#dc3545'; // Vermelho
        default:
            return '#6c757d'; // Cinza
    }
}
// Função para mapear a classificação para as cores
function DefineCorClassificacao(classificacao) {
    switch (classificacao) {
        case 'BAIXA':
            return '#6c757d'; // Cinza
        case 'NORMAL':
            return '#007bff'; // Azul
        case 'URGENTE':
            return '#dc3545'; // Vermelho
        default:
            return '#6c757d'; // Cinza
    }
}
// Função para retornar "Não informado" se o valor for nulo, indefinido ou vazio
function verificarInformacao(valor) {
    return valor ? valor : 'Não informado';
}
/////////////////////////////////////////////////////////
//modal de confirmação de escolha
function confirmaEscolha(Texto, btnSetor) {
    var escondeCampoJustiticativa = (btnSetor === 'SuprimentosReprova' || btnSetor === 'GerenteReprova') ? '' : 'style="display:none"';
    var modal = `
    <div id="confirmaEscolha" class="confirmaEscolha">
        <div class="form-label statusDoPedidoPosPesquisa">
            <span><strong>Tem certeza que deseja ${Texto} a cotação?</strong></span>
                    <div ${escondeCampoJustiticativa}>
            <label for="JustificativaReprova">Justificativa de Cancelamento:</label>
            <textarea class="form-control" id="JustificativaReprova" name="JustificativaReprova"
            placeholder="Digite aqui a justificativa para reprovar a cotação"></textarea>
        </div>
            <button type="button" class="btn btn-secondary ${btnSetor}" id="${btnSetor}">SIM</button>
            <button type="button" class="btn btn-secondary FECHA-MODAL">Fechar</button>
        </div>
         </div>

    `;
    $('body').append(modal);

    // Fecha o modal quando clicar
    $('.FECHA-MODAL').on('click', function () {
        $('#confirmaEscolha').remove();
    });

    $('#confirmaEscolha').on('click', function (e) {
        if (e.target === this) {
            $(this).remove();
        }
    });

    // Foca no textarea quando o modal é aberto
    $('#JustificativaReprova').focus();
}

///////////////////////////////////////////////////////////////////////////////////////
// Função para limpar eventos de clique
function limparEventos() {
    const botoes = [
        '#btnSuprimentosAprova',
        '#btnSuprimentosReprova',
        '#SuprimentosReprova',
        '#AprovadoSuprimentos',
        '#btnGerenteAprova',
        '#AprovadoGerente',
        '#btnGerenteReprova',
        '#GerenteReprova'
    ];

    botoes.forEach(botao => {
        $(document).off('click', botao);
    });
}

///////////////////////////////////////////////////////////////////////////////////////
$('#PesquisarGerenciamentoCotacao').on('click', function (a) {
    a.preventDefault();
    recuperaDadosDePesquisa()
    // console.log(dataInicio);
    // console.log(dataFim);
    // console.log(LojaFiltro);
    if (!dataInicio || !dataFim || !statusPesquisa || !DepartamentoPesquisa) {
        Toasty("Atenção", "Preencha todos os campos para a pesquisa", "#E20914");
    } else {
        criandoHtmlmensagemCarregamento("exibir");
        chamaTelaDePesquisa(dataInicio, dataFim, statusPesquisa, DepartamentoPesquisa, null,)
    }
});

$('#btnPesquisaDireta').on('click', function (a) {
    a.preventDefault();
   let idPesquisaDireta = $('#PesquisaDireta').val();
    // console.log(dataInicio);
    // console.log(dataFim);
    // console.log(LojaFiltro);
    if (!idPesquisaDireta) {
        Toasty("Atenção", "Adicione um ID para realizar a busca direta", "#E20914");
    } else {
        criandoHtmlmensagemCarregamento("exibir");
        chamaTelaDePesquisa(null, null, null, null, idPesquisaDireta)
    }
});


$(document).ready(function () {
    $('#TabelaAcompanhamentoGerenciamentoCotacao').DataTable({
        dom: 'Bfrtip',
        scrollY: "350px",
        scrollX: true,
        // fixedColumns: {
        //     left: 2
        // },
        "lengthMenu": [
            [15],
        ],
        language: {
            sEmptyTable: "Nenhum registro encontrado",
            sInfo: " _START_ até _END_ de _TOTAL_ registros...",
            sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
            sInfoFiltered: "(Filtrados de _MAX_ registros)",
            sInfoPostFix: "",
            sInfoThousands: ".",
            sLengthMenu: "_MENU_ resultados por página",
            sLoadingRecords: "Carregando...",
            sProcessing: "Processando...",
            sZeroRecords: "Nenhum registro encontrado",
            sSearch: "Pesquisar",
            oPaginate: {
                sNext: "Próximo",
                sPrevious: "Anterior",
                sFirst: "Primeiro",
                sLast: "Último"
            }
        },
        order: [[8, 'desc'], [3, 'asc']]
    });
});
$(document).ready(function () {
    $(document).on('click', '.open-modal', function () {
        criandoHtmlmensagemCarregamento("exibir");
        var tr = $(this).closest('tr');
        console.log(tr.html()); // Loga o HTML da linha para inspeção
        var cotacaoId = $(this).closest('tr').data('id');
        var StatusDaCotacao = tr.find('td.statusDaCotacao').text().trim(); // Corrigir para minúsculas
        // alert(StatusDaCotacao);
        console.log('ID da Cotação:', cotacaoId);
        console.log('Status Da Cotacao:', StatusDaCotacao);
        $('#detalhesCotacaoModal').modal('show');
        $.ajax({
            url: 'modal/ModalMaisInformacoesDoPedido.php',
            type: 'POST',
            data: { id: cotacaoId },
            dataType: 'json',
            success: function (respostaEmJSON) {
                // aqui eu pego minha resposta(respostaEmJSON) da pagina, que é um objeto JSON, o datatype json converte o bjeto json em javascript 
                // e ai usamos a resposta da pagina como se fosse um Array
                // console.log(respostaEmJSON[0].imagens);
                let botoesHTML = '', MapaDeCotacao = '';
                let dadosDeQuemEstaLogadoCENTROCUSTO = $('#dadosDeQuemEstaLogadoCENTROCUSTO').val();
                let CARGO = $('#CARGO').val();

                if (respostaEmJSON[0].STATUS === 'NOVO' || respostaEmJSON[0].STATUS === 'EM COTAÇÃO' || respostaEmJSON[0].STATUS === 'COTADO') {

                    if (dadosDeQuemEstaLogadoCENTROCUSTO.trim().toUpperCase() == 'SUPRIMENTOS' && respostaEmJSON[0].STATUS === 'NOVO') {
                        botoesHTML += `
                                <button type="button" class="btn btn-secondary btnSuprimentosAprova" id="btnSuprimentosAprova">Aprovar</button>
                                <button type="button" class="btn btn-secondary btnSuprimentosReprova" id="btnSuprimentosReprova">Reprovar</button>
                            `;
                    } else
                        if (dadosDeQuemEstaLogadoCENTROCUSTO.trim().toUpperCase() == 'SUPRIMENTOS' && respostaEmJSON[0].STATUS == 'EM COTAÇÃO') {
                            botoesHTML += `
                                <label for="mapaDeCotacao">Mapa de Cotação:</label>
                                <input type="file" class="form-control" id="mapaDeCotacao" name="mapaDeCotacao[]" accept=".pdf" required>
                               <button button type="button" class="btn btn-secondary btnSuprimentosAprova" id="btnSuprimentosAprova">Aprovar</button>
                                <button type="button" class="btn btn-secondary btnSuprimentosReprova" id="btnSuprimentosReprova">Reprovar</button>
                            `;
                        }

                        else if (dadosDeQuemEstaLogadoCENTROCUSTO.trim().toUpperCase() == 'SUPRIMENTOS' && respostaEmJSON[0].STATUS === 'COTADO') {
                            botoesHTML += `
                                        `;
                        }

                        else if (CARGO.toUpperCase().includes('GERENTE') && respostaEmJSON[0].STATUS === 'COTADO') {
                            botoesHTML += `
                        <button type="button" class="btn btn-secondary btnGerenteAprova" id="btnGerenteAprova">Aprovar</button>
                        <button type="button" class="btn btn-secondary btnGerenteReprova" id="btnGerenteReprova">Reprovar</button>
                    `;
                            MapaDeCotacao = `
                        <h5>Mapa De Cotações</h5>
                        <div class="pdf-gallery">
                            ${respostaEmJSON[0].MAPADECOTACAO.map(pdf => `
                                <div class="pdf-container">
                                            <!-- Vamos lá! A diferença entre <embed> e <iframe> para exibir um PDF no HTML é a seguinte:
                                            <embed>:
                                            Insere um recurso diretamente no documento.
                                            É mais direto para mostrar arquivos específicos como PDFs.
                                            Não é muito flexível para customização ou interação.
                                            <iframe>:
                                            Insere outra página HTML dentro da página atual.
                                            Mais flexível, permitindo embutir páginas inteiras, não apenas arquivos específicos.
                                            Oferece mais controle sobre o conteúdo e permite melhor interação e personalização.
                                            Se você só quer mostrar o PDF, ambos funcionam bem. Se precisar de mais controle ou interatividade, vá de <iframe>.
                                            -->
                                    <embed src="Config/${pdf}" type="application/pdf" width="100%" height="400px" />
                                    <!-- <iframe src="Config/${pdf}" width="100%" height="400px"></iframe> -->
                                </div>
                            `).join('')}
                        </div>
                    `;

                        }
                }
                var html = `
                            <label for="datafim" class="form-label statusDoPedidoPosPesquisa">
                                <span>ID: <strong>${verificarInformacao(respostaEmJSON[0].ID)}</strong></span>
                                <span>Status: <strong style="color: ${DefineCorStatus(respostaEmJSON[0].STATUS)}">${verificarInformacao(respostaEmJSON[0].STATUS)}</strong></span>
                                <span>Classificação: <strong style="color: ${DefineCorClassificacao(respostaEmJSON[0].CLASSIFICACAO_NECESSIDADE)}">${verificarInformacao(respostaEmJSON[0].CLASSIFICACAO_NECESSIDADE)}</strong></span>
                            </label>

                            <h5>Informações do Solicitante</h5>
                            <ul>
                                <li><strong>Solicitante:</strong> ${verificarInformacao(respostaEmJSON[0].SOLICITANTE)}</li>
                                <li><strong>Departamento:</strong> ${verificarInformacao(respostaEmJSON[0].DEPARTAMENTO)}</li>
                                <li><strong>Data da Solicitação:</strong> ${verificarInformacao(respostaEmJSON[0].DATA_SOLICITACAO)}</li>
                                <li><strong>Nº Chamado:</strong> ${verificarInformacao(respostaEmJSON[0].NUMERO_CHAMADO)}</li>
                            </ul>

                            <h5>Informações da Loja</h5>
                            <ul>
                                <li><strong>Loja:</strong> ${verificarInformacao(respostaEmJSON[0].LOJA)}</li>
                                <li><strong>Cidade:</strong> ${verificarInformacao(respostaEmJSON[0].CIDADE)}</li>
                                <li><strong>Prazo Necessário (dias):</strong> ${verificarInformacao(respostaEmJSON[0].PRAZO_NECESSARIO)}</li>
                            </ul>

                            <h5>Informações do Item</h5>
                            <ul>
                                <li><strong>Item:</strong> ${verificarInformacao(respostaEmJSON[0].ITEM)}</li>
                                <li><strong>Tamanho:</strong> ${verificarInformacao(respostaEmJSON[0].TAMANHO)}</li>
                                <li><strong>Cor:</strong> ${verificarInformacao(respostaEmJSON[0].COR)}</li>
                                <li><strong>Modelo:</strong> ${verificarInformacao(respostaEmJSON[0].MODELO)}</li>
                                <li><strong>Espessura:</strong> ${verificarInformacao(respostaEmJSON[0].ESPESSURA)}</li>
                                <li><strong>Código Fornecedor:</strong> ${verificarInformacao(respostaEmJSON[0].CODIGO_FORNECEDOR)}</li>
                                <li><strong>Tipo Material:</strong> ${verificarInformacao(respostaEmJSON[0].TIPO_MATERIAL)}</li>
                                <li><strong>Marca:</strong> ${verificarInformacao(respostaEmJSON[0].MARCA)}</li>
                                <li><strong>Quantidade:</strong> ${verificarInformacao(respostaEmJSON[0].QUANTIDADE)}</li>
                                <li><strong>Original ou Genérico:</strong> ${verificarInformacao(respostaEmJSON[0].ORIGINAL_OU_GENERICO)}</li>
                                <li><strong>Unidade:</strong> ${verificarInformacao(respostaEmJSON[0].UNIDADE)}</li>
                                <li><strong>Medida:</strong> ${verificarInformacao(respostaEmJSON[0].MEDIDA)}</li>
                                <li><strong>Gás:</strong> ${verificarInformacao(respostaEmJSON[0].GAS)}</li>
                                <li><strong>Tensão:</strong> ${verificarInformacao(respostaEmJSON[0].TENSAO)}</li>
                                <li><strong>Potência:</strong> ${verificarInformacao(respostaEmJSON[0].POTENCIA)}</li>
                                <li><strong>Corrente:</strong> ${verificarInformacao(respostaEmJSON[0].CORRENTE)}</li>
                                <li><strong>Rosca / Solda:</strong> ${verificarInformacao(respostaEmJSON[0].ROSCA_SOLDA)}</li>
                                <li><strong>Classificação de Necessidade:</strong> ${verificarInformacao(respostaEmJSON[0].CLASSIFICACAO_NECESSIDADE)}</li>
                                <li><strong>Descrição:</strong> ${verificarInformacao(respostaEmJSON[0].DESCRICAO)}</li>
                            </ul>

                            <h5>Faturamento</h5>
                            <ul>
                                <li><strong>Faturamento:</strong> ${verificarInformacao(respostaEmJSON[0].FATURAMENTO)}</li>
                                <li><strong>CNPJ:</strong> ${verificarInformacao(respostaEmJSON[0].CNPJ)}</li>
                                <li><strong>Endereço:</strong> ${verificarInformacao(respostaEmJSON[0].ENDERECO)}</li>
                            </ul>

                            <h5>Local de Entrega</h5>
                            <ul>
                                <li><strong>Local de Entrega:</strong> ${verificarInformacao(respostaEmJSON[0].LOCAL_ENTREGA)}</li>
                            </ul>

                            <h5>Indicações de Fornecedores</h5>
                            <ul>
                                <li><strong>Nome do Fornecedor:</strong> ${verificarInformacao(respostaEmJSON[0].NOME_FORNECEDOR)}</li>
                                <li><strong>Telefone do Fornecedor:</strong> ${verificarInformacao(respostaEmJSON[0].TEL_FORNECEDOR)}</li>
                                <li><strong>E-mail do Fornecedor:</strong> ${verificarInformacao(respostaEmJSON[0].EMAIL_FORNECEDOR)}</li>
                            </ul>

                            <h5>Imagens</h5>
                            <div class="image-gallery">
                                ${respostaEmJSON[0].imagens.map(img => `<img src="Config/${img}" alt="Imagem" class="img-thumbnail expandable-image">`).join('')}
                            </div>
                             ${MapaDeCotacao}
                            `;
                // Insere o HTML no modal
                $('#modalDetalhesConteudo').html(html);
                // Insere o HTML dos botoes no modal
                $('#actionButtons').html(botoesHTML);
                criandoHtmlmensagemCarregamento("ocultar");
                // Limpa eventos
                limparEventos();
                // APROVAsuprimentos //////////////////////////////////////////////////////////////////////////
                $(document).on('click', '#btnSuprimentosAprova', function (a) {
                    a.preventDefault();
                    // Remover o evento anterior, se houver, para evitar múltiplos cliques
                    $(document).off('click', '#AprovadoSuprimentos'); // Remove qualquer evento anterior vinculado a '#AprovadoSuprimentos'

                    confirmaEscolha('Aprovar', 'AprovadoSuprimentos');

                    $(document).on('click', '#AprovadoSuprimentos', function (F) {
                        F.preventDefault();

                        var statusCotacao = respostaEmJSON[0].STATUS;
                        var mapaDeCotacao = null;

                        // Verifica se o elemento #mapaDeCotacao existe e se contém um arquivo
                        if ($('#mapaDeCotacao').length > 0) {
                            mapaDeCotacao = $('#mapaDeCotacao')[0].files[0]; // Captura o arquivo se o input existir
                        }

                        if (statusCotacao === 'EM COTAÇÃO' && !mapaDeCotacao) {
                            Toasty("Erro", 'O arquivo Mapa de Cotação é obrigatório.', "#E20914");
                            return;
                        }
                        aprovarOuReprovar(cotacaoId, 'Aprovar', null, mapaDeCotacao);
                    });
                });

                // REPROVAsuprimentos //////////////////////////////////////////////////////////////////////////
                $(document).on('click', '#btnSuprimentosReprova', function (a) {
                    $('#detalhesCotacaoModal').modal('hide');
                    confirmaEscolha('Reprovar', 'SuprimentosReprova');
                });
                $(document).on('click', '#SuprimentosReprova', function (a) {
                    a.preventDefault();
                    var JustificativaReprova = $('#JustificativaReprova').val();

                    if (JustificativaReprova == '') {
                        Toasty("Erro", "Para reprovar a cotação, por favor adicione uma justificativa.", "#E20914");
                    } else {
                        aprovarOuReprovar(cotacaoId, 'Reprovar', JustificativaReprova);
                    }
                });

                // APROVAgerente //////////////////////////////////////////////////////////////////////////
                $(document).on('click', '#btnGerenteAprova', function (a) {
                    a.preventDefault();
                    confirmaEscolha('Aprovar', 'AprovadoGerente');
                    $(document).on('click', '#AprovadoGerente', function (F) {
                        F.preventDefault();
                        aprovarOuReprovar(cotacaoId, 'Aprovar');
                    });
                });

                // REPROVAGerente //////////////////////////////////////////////////////////////////////////
                $(document).on('click', '#btnGerenteReprova', function (a) {
                    $('#detalhesCotacaoModal').modal('hide');
                    confirmaEscolha('Reprovar', 'GerenteReprova');
                });
                $(document).on('click', '#GerenteReprova', function (a) {
                    a.preventDefault();
                    var JustificativaReprova = $('#JustificativaReprova').val();

                    if (JustificativaReprova == '') {
                        Toasty("Erro", "Para reprovar a cotação, por favor adicione uma justificativa.", "#E20914");
                    } else {
                        aprovarOuReprovar(cotacaoId, 'Reprovar', JustificativaReprova);
                    }
                });

            }
        });
    });
});


function aprovarOuReprovar(cotacaoId, opcaoEscolhida, justificativa = null, mapaDeCotacao = null) {
    var formData = new FormData();
    formData.append('id', cotacaoId);
    formData.append('opcaoEscolhida', opcaoEscolhida);
    formData.append('justificativa', justificativa);

    // Se houver arquivo, adiciona-o ao FormData
    if (mapaDeCotacao) {
        formData.append('mapaDeCotacao', mapaDeCotacao);
    }
    atualizarCotacao(formData);
}


function atualizarCotacao(formData) {
    $.ajax({
        url: 'config/UpdateCotacao.php',
        type: 'POST',
        data: formData,
        processData: false, // Impede que o jQuery processe os dados
        contentType: false, // Impede que o jQuery defina o tipo de conteúdo
        dataType: 'json',
        success: function (respostaEmJSONAPROVACAO) {
            if (respostaEmJSONAPROVACAO.sucesso == 1) {
                Toasty("Sucesso", respostaEmJSONAPROVACAO.mensagem, "#00a550");
                $('#confirmaEscolha').remove();
                $('#detalhesCotacaoModal').modal('hide');
                criandoHtmlmensagemCarregamento("exibir");
                recuperaDadosDePesquisa();
                chamaTelaDePesquisa(dataInicio, dataFim, statusPesquisa, null,);
            } else {
                Toasty("Erro", respostaEmJSONAPROVACAO.mensagem, "#E20914");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Toasty("Erro", "Erro na comunicação com o servidor.", "#E20914");
        }
    });
}


$(document).ready(function () {
    // Função para abrir a imagem expandida
    $('body').on('click', '.expandable-image', function () {
        var imgSrc = $(this).attr('src');
        var modal = `
            <div id="imageModal" class="image-modal">
                <span class="close-modal">&times;</span>
                <img class="modal-content" src="${imgSrc}">
            </div>
        `;
        $('body').append(modal);

        // Fecha o modal quando clicar no "x"
        $('.close-modal').on('click', function () {
            $('#imageModal').remove();
        });

        // Fecha o modal quando clicar fora da imagem
        $('#imageModal').on('click', function (e) {
            if (e.target == this) {
                $(this).remove();
            }
        });
    });
});







