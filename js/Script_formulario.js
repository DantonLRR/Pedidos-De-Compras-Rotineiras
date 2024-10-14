import { criandoHtmlmensagemCarregamento, Toasty } from "../../base/jsGeral.js";
var formularioCount = 0;

function InclusaoDeItens() {
    if (formularioCount < 10) { // Limite de 10 formulários
        criandoHtmlmensagemCarregamento("exibir");
        const novoFormularioHtml = `                    
            <fieldset>
                <legend>Informações do Item ${formularioCount + 1}</legend>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="item${formularioCount + 1}">Item:</label>
                            <input type="text" class="form-control" id="item${formularioCount + 1}" name="item[]" value="Item: ${formularioCount + 1}" placeholder="Nome do item" required>
                            <div class="invalid-feedback">
                                Por favor, insira o nome do item.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="PrecoEstimado${formularioCount + 1}">Preço Estimado:</label>
                            <input type="text" class="form-control PrecoEstimado" id="PrecoEstimado${formularioCount + 1}" name="PrecoEstimado[]" value="${formularioCount + 1}" placeholder="0,00" required>
                            <div class="invalid-feedback">
                                Por favor, insira o preço estimado.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tamanho${formularioCount + 1}">Tamanho:</label>
                            <input type="text" class="form-control" id="tamanho${formularioCount + 1}" name="tamanho[]" value='N/A' placeholder="Tamanho">
                            <div class="invalid-feedback">
                                Por favor, insira o tamanho.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cor${formularioCount + 1}">Cor:</label>
                            <input type="text" class="form-control" id="cor${formularioCount + 1}" name="cor[]" value='N/A' placeholder="Cor">
                            <div class="invalid-feedback">
                                Por favor, insira a cor.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modelo${formularioCount + 1}">Modelo:</label>
                            <input type="text" class="form-control" id="modelo${formularioCount + 1}" name="modelo[]" value='N/A' placeholder="Modelo">
                            <div class="invalid-feedback">
                                Por favor, insira o modelo.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="espessura${formularioCount + 1}">Espessura:</label>
                            <input type="text" class="form-control" id="espessura${formularioCount + 1}" name="espessura[]" value='N/A' placeholder="Espessura">
                            <div class="invalid-feedback">
                                Por favor, insira a espessura.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigoFornecedor${formularioCount + 1}">Código Fornecedor:</label>
                            <input type="text" class="form-control" id="codigoFornecedor${formularioCount + 1}" name="codigoFornecedor[]" value='N/A' placeholder="Código do fornecedor">
                            <div class="invalid-feedback">
                                Por favor, insira o código do fornecedor.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipoMaterial${formularioCount + 1}">Tipo Material:</label>
                            <input type="text" class="form-control" id="tipoMaterial${formularioCount + 1}" name="tipoMaterial[]" value='N/A' placeholder="Tipo de material">
                            <div class="invalid-feedback">
                                Por favor, insira o tipo de material.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca${formularioCount + 1}">Marca:</label>
                            <input type="text" class="form-control" id="marca${formularioCount + 1}" name="marca[]" value='N/A' placeholder="Marca">
                            <div class="invalid-feedback">
                                Por favor, insira a marca.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantidade${formularioCount + 1}">Quantidade:</label>
                            <input type="number" class="form-control" id="quantidade${formularioCount + 1}" name="quantidade[]" value="${formularioCount + 1}" placeholder="Quantidade" required>
                            <div class="invalid-feedback">
                                Por favor, insira a quantidade.
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="originalOuGenerico${formularioCount + 1}">Original ou Genérico:</label>
                                <div class="radio-group">
                                    <div class="form-check">
                                        <input type="radio" id="original${formularioCount + 1}" name="originalOuGenerico${formularioCount + 1}" value="original" class="form-check-input" required>
                                        <label class="form-check-label" for="original${formularioCount + 1}">Original</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="generico${formularioCount + 1}" name="originalOuGenerico${formularioCount + 1}" value="generico" class="form-check-input" required>
                                        <label class="form-check-label" for="generico${formularioCount + 1}">Genérico</label>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor, selecione uma opção.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unidade${formularioCount + 1}">Unidade:</label>
                                <input type="number" class="form-control" id="unidade${formularioCount + 1}" name="unidade[]" value="${formularioCount + 1}" placeholder="Unidade">
                                <div class="invalid-feedback">
                                    Por favor, insira a unidade.
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medida${formularioCount + 1}">Medida (Bitola, MM, Polegada):</label>
                            <input type="text" class="form-control" id="medida${formularioCount + 1}" name="medida[]" value='N/A' placeholder="Medida">
                            <div class="invalid-feedback">
                                Por favor, insira a medida.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gas${formularioCount + 1}">Gás:</label>
                            <input type="text" class="form-control" id="gas${formularioCount + 1}" name="gas[]" value='N/A' placeholder="Gás">
                            <div class="invalid-feedback">
                                Por favor, insira o gás.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tensao${formularioCount + 1}">Tensão:</label>
                            <input type="text" class="form-control" id="tensao${formularioCount + 1}" name="tensao[]" value='N/A' placeholder="Tensão">
                            <div class="invalid-feedback">
                                Por favor, insira a tensão.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roscaSolda${formularioCount + 1}">Rosca / Solda:</label>
                            <input type="text" class="form-control" id="roscaSolda${formularioCount + 1}" name="roscaSolda[]" value="N/A" placeholder="Rosca / Solda">
                            <div class="invalid-feedback">
                                Por favor, insira informações sobre Rosca ou Solda.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="potencia${formularioCount + 1}">Potência:</label>
                            <input type="text" class="form-control" id="potencia${formularioCount + 1}" name="potencia[]" value="N/A" placeholder="Potência">
                            <div class="invalid-feedback">
                                Por favor, insira a potência.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="corrente${formularioCount + 1}">Corrente:</label>
                            <input type="text" class="form-control" id="corrente${formularioCount + 1}" name="corrente[]" value="N/A" placeholder="Corrente">
                            <div class="invalid-feedback">
                                Por favor, insira a corrente.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="imagem${formularioCount + 1}">Imagem do Item:</label>
                            <input type="file" class="form-control" id="imagem${formularioCount + 1}" name="imagens[]" accept="image/*" multiple>
                            <div class="invalid-feedback">
                                Por favor, adicione a imagem do item.
                            </div>
                        </div>
                    </div>
                </div>
            <div class="form-group">
                <label for="descricao${formularioCount + 1}">DESCRIÇÃO (detalhado c/especificação):</label>
                <textarea class="form-control" id="descricao${formularioCount + 1}" name="descricao[]" rows="4" placeholder="Descrição detalhada" required></textarea>
            </div>
            </fieldset>
            `;
        $('#FormularioDeItem').append(novoFormularioHtml);
        formularioCount++;
        criandoHtmlmensagemCarregamento("esconder");
    } else {
        Toasty("Atenção", "Limite de 10 itens alcançado!.", "#E20914");
    }
}
$(document).ready(function () {
    $('.BotaoAdicionaItensnaCotacao').on('click', function () {
        InclusaoDeItens();
    });
});


$(document).ready(function () {
    function formatarPreco(valor) {
        valor = valor.replace(/\D/g, '');
        valor = (valor / 100).toFixed(2) + '';
        valor = valor.replace('.', ',');
        return valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }


    $(document).on('keyup', '.PrecoEstimado', function () {
        var value = $(this).val();
        $(this).val(formatarPreco(value));
    });


    $('#form').on('submit', function (event) {
        criandoHtmlmensagemCarregamento("exibir");
        event.preventDefault();
        var form = $(this)[0];
        var impedimento = false;

        form.classList.add('was-validated');

        // Validação dos campos do formulário principal
        if (!form.checkValidity()) {
            impedimento = true;
        }

        // Verificação dos itens dinâmicos
        for (var i = 1; i <= formularioCount; i++) {
            let itemFields = $(`#item${i}, #PrecoEstimado${i}, #tamanho${i}, #cor${i}, #modelo${i}, #espessura${i}, #codigoFornecedor${i}, #tipoMaterial${i}, #marca${i}, #quantidade${i}, #unidade${i}, #medida${i}, #gas${i}, #tensao${i}, #potencia${i}, #corrente${i}, #roscaSolda${i}, #imagem${i}, #descricao${i}`);

            itemFields.each(function () {
                if (!this.checkValidity()) {
                    impedimento = true;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (impedimento) {
                Toasty("Atenção", "Por favor, preencha todos os campos obrigatórios corretamente.", "#E20914");
                return;
            }
        }

        if (impedimento) return;



        let classificacaoNecessidade = $('input[name="classificacaoNecessidade"]:checked').val();
        let faturamento = $('#faturamento').val();
        let cnpj = $('#cnpj').val();
        let endereco = $('#endereco').val();
        let localEntrega = $('#localEntrega').val();
        let nomeFornecedor = $('#nomeFornecedor').val();
        let telFornecedor = $('#telFornecedor').val();
        let emailFornecedor = $('#emailFornecedor').val();


        let formData = new FormData();
        formData.append('solicitante', $('#solicitante').val());
        formData.append('departamento', $('#departamento').val());
        formData.append('dataSolicitacao', $('#dataSolicitacao').val());
        formData.append('numeroChamado', $('#numeroChamado').val());
        formData.append('loja', $('#loja').val());
        formData.append('cidade', $('#cidade').val());
        formData.append('prazoNecessario', $('#prazoNecessario').val());
        formData.append('classificacaoNecessidade', classificacaoNecessidade);
        formData.append('faturamento', faturamento);
        formData.append('cnpj', cnpj);
        formData.append('endereco', endereco);
        formData.append('localEntrega', localEntrega);
        formData.append('nomeFornecedor', nomeFornecedor);
        formData.append('telFornecedor', telFornecedor);
        formData.append('emailFornecedor', emailFornecedor);

        // Loop para adicionar dados dos itens dinâmicos
        for (var i = 1; i <= formularioCount; i++) {
            formData.append(`item[${i}][nome]`, $(`#item${i}`).val());
            formData.append(`item[${i}][precoEstimado]`, $(`#PrecoEstimado${i}`).val());
            formData.append(`item[${i}][tamanho]`, $(`#tamanho${i}`).val());
            formData.append(`item[${i}][cor]`, $(`#cor${i}`).val());
            formData.append(`item[${i}][modelo]`, $(`#modelo${i}`).val());
            formData.append(`item[${i}][espessura]`, $(`#espessura${i}`).val());
            formData.append(`item[${i}][codigoFornecedor]`, $(`#codigoFornecedor${i}`).val());
            formData.append(`item[${i}][tipoMaterial]`, $(`#tipoMaterial${i}`).val());
            formData.append(`item[${i}][marca]`, $(`#marca${i}`).val());
            formData.append(`item[${i}][quantidade]`, $(`#quantidade${i}`).val());
            formData.append(`item[${i}][originalOuGenerico]`, $(`input[name="originalOuGenerico${i}"]:checked`).val());
            formData.append(`item[${i}][unidade]`, $(`#unidade${i}`).val());
            formData.append(`item[${i}][medida]`, $(`#medida${i}`).val());
            formData.append(`item[${i}][gas]`, $(`#gas${i}`).val());
            formData.append(`item[${i}][tensao]`, $(`#tensao${i}`).val());
            formData.append(`item[${i}][potencia]`, $(`#potencia${i}`).val());
            formData.append(`item[${i}][corrente]`, $(`#corrente${i}`).val());
            formData.append(`item[${i}][roscaSolda]`, $(`#roscaSolda${i}`).val());
            formData.append(`item[${i}][descricao]`, $(`#descricao${i}`).val());

            // Adiciona as imagens para cada item
            let imagens = $(`#imagem${i}`).prop('files');

            // Adicionando console para verificar se o elemento de imagem foi encontrado e os arquivos
            console.log(`Imagens do item ${i}:`, imagens);

            // Verifica se o elemento de imagem existe e tem arquivos
            if (imagens && imagens.length > 0) {
                for (let j = 0; j < imagens.length; j++) {
                    formData.append(`item[${i}][imagens][]`, imagens[j]);
                    // Adiciona um console para cada imagem que está sendo adicionada ao formData
                    console.log(`Adicionando imagem ${j} do item ${i}:`, imagens[j]);
                }
            } else {
                // Caso não haja imagens, você pode logar algo para saber o que está acontecendo
                console.warn(`Nenhuma imagem encontrada para o item ${i}`);
            }
        }
        $.ajax({
            url: "Config/Insert_Formulario.php",
            method: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (retornoInsert) {
                if (retornoInsert === '1') {
                    Toasty("Sucesso", "Formulário enviado com sucesso.", "#00a550");
                    setTimeout(function () {
                        window.location.href = "FormularioPedidoDeComprasRotineiras.php";
                    }, 2500);
                    criandoHtmlmensagemCarregamento("ocultar");
                } else {
                    Toasty("Atenção", "Houve um erro ao enviar o formulário. Procure o administrador.", "#E20914");
                    criandoHtmlmensagemCarregamento("ocultar");
                }
            },
            error: function () {
                Toasty("Erro", "Houve um erro de comunicação. Tente novamente.", "#E20914");
                criandoHtmlmensagemCarregamento("ocultar");
            }
        });
    });
});
