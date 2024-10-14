import { criandoHtmlmensagemCarregamento, Toasty } from "../../base/jsGeral.js";
$(document).ready(function() {
    $('.table').DataTable({
        dom: 'ft',
        paging: true,
        info: false,
        searching: true,
        ordering: false,
        scrollY: "280px",
        lengthMenu: [[50], [50]],
        language: {
            sEmptyTable: "Nenhum registro encontrado",
            sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            sLengthMenu: "_MENU_ resultados por página",
            oPaginate: {
                sNext: "Próximo",
                sPrevious: "Anterior"
            }
        }
    });
    $('.trr').click(function() {
        var linha = $(this).closest('tr');
        var id = linha.find('td:first').text(); // Pega o ID
        var Status = linha.find('td:eq(1)').text(); // Pega o STATUS (segunda célula)
        var descricao = linha.find('td:last').text();
        var loja = $('.loja').val();

        $.ajax({
            url: 'Config/GerenciamentoPermissao.php',
            method: 'POST',
            data: {
                SEQOPCAO: id,
                dadosDESCRICAODisponivel: descricao,
                loja: loja,
                Status: Status
            },
            beforeSend: function() {
                criandoHtmlmensagemCarregamento("exibir");
            },
            success: function(response) {
                $('.tablereq').html(response);
                criandoHtmlmensagemCarregamento("ocultar");
            }
        });
    });
});
//////////////////////////////////////////////////////////////////////////////////////////////////////

