<?php
session_start();
include "../../base/conexao_martdb.php";
include "php/crud_gerenciamento.php";
$funcoes = new funcoesEmPHP();

$dataInicio = $_POST['dataInicio'];
$dataFim = $_POST['dataFim'];
$statusPesquisa = $_POST['statusPesquisa'];
$dadosDeQuemEstaLogadoCENTROCUSTO = $_POST['dadosDeQuemEstaLogadoCENTROCUSTO'];
$Departamento = $_POST['DepartamentoPesquisa'];
$idPesquisaDireta = $_POST['idPesquisaDireta'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$idPesquisaDireta) {
    $FiltrosAcompanhamento = new FiltrosAcompanhamento();
    $buscandoAcompanhamento = $FiltrosAcompanhamento->buscandoCotacoesPesquisa($oracle, $dataInicio, $dataFim, $statusPesquisa, $dadosDeQuemEstaLogadoCENTROCUSTO, $Departamento);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $idPesquisaDireta) {
    $InformacoesCotacoes = new InformacoesCotacoes();
    $buscandoAcompanhamento = $InformacoesCotacoes->maisInformacoesCotacaoPorID($oracle, $idPesquisaDireta);
}
foreach ($buscandoAcompanhamento as $row) :
?>
    <tr data-id="<?= htmlspecialchars($row['ID']) ?>">
        <td class="text-center ID"><?= htmlspecialchars($row['SEQ_COTACAO']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['ID']) ?></td>
        <td class="text-center "><?= htmlspecialchars($row['ITEM']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['SOLICITANTE']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['DEPARTAMENTO']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['DATA_SOLICITACAO']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['NUMERO_CHAMADO']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['LOJA']) ?></td>
        <td class="text-center"><?= htmlspecialchars($row['CIDADE']) ?></td>
        <td class="text-center statusDoPedido statusDaCotacao" style="color: <?= $funcoes->definirCorStatus(htmlspecialchars($row['STATUS'])) ?>;">
            <?= htmlspecialchars($row['STATUS']) ?>
        </td>
        <td class="text-center statusDoPedido" style="color: <?= $funcoes->definirCorStatus(htmlspecialchars($row['CLASSIFICACAO_NECESSIDADE'])) ?>;">
            <?= htmlspecialchars($row['CLASSIFICACAO_NECESSIDADE']) ?>
        </td>
        <td class="text-center open-modal">
            <i class="fa-solid fa-clipboard fa-xl" style="color: <?= $funcoes->definirCorStatus(htmlspecialchars($row['CLASSIFICACAO_NECESSIDADE'])) ?>;"></i>
        </td>
    </tr>
<?php
endforeach;
?>