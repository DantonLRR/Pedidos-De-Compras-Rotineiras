<?php
// Conexões
include "../../base/Conexao_martdb.php";
include "php/crud_canhoto.php";
$dataInicio = $_POST['dataInicio'];
$DataFim = $_POST['dataFim'];
$FiltrosAcompanhamento = new FiltrosAcompanhamento();
?>
<div class="container-fluid ">
    <div class="card">
        <div class="card-header text-center">
            Gerenciamento de Canhoto Eletrônico
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="TabelaAcompanhamentoCanhoto">
                <thead class="thead-custom">
                    <tr>
                        <th style=" background-color: #00a550 !important"class="text-center">Fornecedor</th>
                        <th style=" background-color: #00a550 !important" class="text-center">Data Recebimento</th>
                        <th class="text-center">Conferente</th>
                        <th class="text-center">CNPJ Loja</th>
                        <th class="text-center">CNPJ Fornecedor</th>
                        <th class="text-center">Nota Fiscal</th>
                        <th class="text-center">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $buscandoAcompanhamento = $FiltrosAcompanhamento->buscandoAcompanhamento($oracle, $dataInicio, $DataFim, $fornecedor = 174771);
                    foreach ($buscandoAcompanhamento as $row) :
                    ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['FORNECEDOR']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['DTA_RECEBIMENTO']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['CONFERENTE']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['CNPJ_LOJA']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['CNPJ_FORNECEDOR']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($row['NOTAFISCAL']) ?></td>
                            <td class="text-center numeric-field"><?= number_format($row['VALOR'], 2, ',', '.') ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="module">
    import {
        criandoHtmlmensagemCarregamento,
        Toasty
    } from "../../base/jsGeral.js";
    $(document).ready(function() {
    $('#TabelaAcompanhamentoCanhoto').DataTable({
        dom: 'Bfrtip',
        scrollY: "350px",
        scrollX: true,
        fixedColumns: {
            left: 2
        },
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

    });
});

</script>
