import { criandoHtmlmensagemCarregamento, Toasty } from "../../base/jsGeral.js";

$(document).ready(function() {
    $('#PrecoEstimado').on('keyup', function() {
        var value = $(this).val().replace(/\D/g, ''); // Remove qualquer caractere que não seja número

        // Formata o valor como moeda
        value = (value / 100).toFixed(2) + ''; 
        value = value.replace('.', ','); // Substitui ponto por vírgula
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Adiciona pontos como separadores de milhar

        // Define o valor formatado no campo
        $(this).val(value);
    });

    $('#form').on('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário
        var form = $(this)[0];
        var impedimento = false;
        let tensao = $('#tensao').val();
        alert(tensao);
        // Adiciona a classe 'was-validated' para mostrar feedback
        form.classList.add('was-validated');

        // Valida todos os campos do formulário
        if (!form.checkValidity()) {
            impedimento = true;
        }

        if (impedimento) {
            Toasty("Atenção", "Por favor, preencha todos os campos obrigatórios corretamente.", "#E20914");
            return;
        }

        // Recupera os dados dos campos
        let solicitante = $('#solicitante').val();
        let departamento = $('#departamento').val();
        let dataSolicitacao = $('#dataSolicitacao').val();
        let numeroChamado = $('#numeroChamado').val();
        let loja = $('#loja').val();
        let cidade = $('#cidade').val();
        let prazoNecessario = $('#prazoNecessario').val();
        let item = $('#item').val();
        let tamanho = $('#tamanho').val();
        let cor = $('#cor').val();
        let modelo = $('#modelo').val();
        let espessura = $('#espessura').val();
        let codigoFornecedor = $('#codigoFornecedor').val();
        let tipoMaterial = $('#tipoMaterial').val();
        let marca = $('#marca').val();
        let quantidade = $('#quantidade').val();
        let originalOuGenerico = $('input[name="originalOuGenerico"]:checked').val();
        let unidade = $('#unidade').val();
        let medida = $('#medida').val();
        let gas = $('#gas').val();
        // let tensao = $('#tensao').val();
        let potencia = $('#potencia').val();
        let corrente = $('#corrente').val();
        let roscaSolda = $('#roscaSolda').val();
        let imagens = $('#imagem').prop('files'); // Recupera todas as imagens selecionadas
        let classificacaoNecessidade = $('input[name="classificacaoNecessidade"]:checked').val();
        let descricao = $('#descricao').val();
        let faturamento = $('#faturamento').val();
        let cnpj = $('#cnpj').val();
        let endereco = $('#endereco').val();
        let localEntrega = $('#localEntrega').val();
        let nomeFornecedor = $('#nomeFornecedor').val();
        let telFornecedor = $('#telFornecedor').val();
        let emailFornecedor = $('#emailFornecedor').val();
        let precoEstimado = $('#PrecoEstimado').val();

        // Se não houver impedimentos, envia a requisição AJAX
        if (!impedimento) {
            criandoHtmlmensagemCarregamento("exibir");
            let formData = new FormData();
            formData.append('solicitante', solicitante);
            formData.append('departamento', departamento);
            formData.append('dataSolicitacao', dataSolicitacao);
            formData.append('numeroChamado', numeroChamado);
            formData.append('loja', loja);
            formData.append('cidade', cidade);
            formData.append('prazoNecessario', prazoNecessario);
            formData.append('item', item);
            formData.append('tamanho', tamanho);
            formData.append('cor', cor);
            formData.append('modelo', modelo);
            formData.append('espessura', espessura);
            formData.append('codigoFornecedor', codigoFornecedor);
            formData.append('tipoMaterial', tipoMaterial);
            formData.append('marca', marca);
            formData.append('quantidade', quantidade);
            formData.append('originalOuGenerico', originalOuGenerico);
            formData.append('unidade', unidade);
            formData.append('medida', medida);
            formData.append('gas', gas);
            formData.append('tensao', tensao);
            formData.append('potencia', potencia);
            formData.append('corrente', corrente);
            formData.append('roscaSolda', roscaSolda);
            for (let i = 0; i < imagens.length; i++) {
                formData.append('imagem[]', imagens[i]);
            }
            formData.append('classificacaoNecessidade', classificacaoNecessidade);
            formData.append('descricao', descricao);
            formData.append('faturamento', faturamento);
            formData.append('cnpj', cnpj);
            formData.append('endereco', endereco);
            formData.append('localEntrega', localEntrega);
            formData.append('nomeFornecedor', nomeFornecedor);
            formData.append('telFornecedor', telFornecedor);
            formData.append('emailFornecedor', emailFornecedor);
            formData.append('PrecoEstimado', precoEstimado);
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
                            criandoHtmlmensagemCarregamento("ocultar");
                            window.location.href = "FormularioPedidoDeComprasRotineiras.php";
                        }, 2500);
                    } else {
                        Toasty("Atenção", "Houve um erro ao enviar o formulário. Procure o administrador.", "#E20914");
                    }
                },
                error: function () {
                    Toasty("Erro", "Houve um erro de comunicação. Tente novamente.", "#E20914");
                }
            });
        }
    });
});
