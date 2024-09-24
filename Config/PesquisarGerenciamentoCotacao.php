<?php
session_start();
include "../../base/conexao_martdb.php";
include "php/crud_gerenciamento.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataInicio = $_POST['dataInicio'];
    $dataFim = $_POST['dataFim'];
    $statusPesquisa = $_POST['statusPesquisa'];

    $FiltrosAcompanhamento = new FiltrosAcompanhamento();
    $buscandoAcompanhamento = $FiltrosAcompanhamento->buscandoCotacoesPesquisa($oracle, $dataInicio, $dataFim, $statusPesquisa);

    foreach ($buscandoAcompanhamento as $row) :
?>
        <tr data-id="<?= htmlspecialchars($row['ID']) ?>">
            <td class="text-center ID"><?= htmlspecialchars($row['ID']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['SOLICITANTE']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['DEPARTAMENTO']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['DATA_SOLICITACAO']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['NUMERO_CHAMADO']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['LOJA']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['CIDADE']) ?></td>
            <td class="text-center statusDoPedido" style="color: <?php switch (htmlspecialchars($row['STATUS'])) {
                                                                        case 'NOVO':
                                                                            echo '#007bff'; // Azul
                                                                            break;
                                                                        case 'APROVADO':
                                                                            echo '#28a745'; // Verde
                                                                            break;
                                                                        case 'REPROVADO':
                                                                            echo '#dc3545'; // Vermelho
                                                                            break;
                                                                        default:
                                                                            echo '#6c757d'; // Cinza
                                                                    }
                                                                    ?> ">
                <?= htmlspecialchars($row['STATUS']) ?></td>
            <td class="text-center statusDoPedido" style="color: <?php switch (htmlspecialchars($row['CLASSIFICACAO_NECESSIDADE'])) {
                                                                        case 'BAIXA':
                                                                            echo '#6c757d'; // Cinza
                                                                            break;
                                                                        case 'NORMAL':
                                                                            echo '#007bff'; // Azul
                                                                            break;
                                                                        case 'URGENTE':
                                                                            echo '#dc3545'; // Vermelho
                                                                            break;
                                                                        default:
                                                                            echo '#6c757d'; // Cinza
                                                                    }
                                                                    ?> ">
                <?= htmlspecialchars($row['CLASSIFICACAO_NECESSIDADE']) ?></td>
            <td class="text-center open-modal">
                <i class="fa-solid fa-clipboard fa-xl" style="color: <?php switch (htmlspecialchars($row['CLASSIFICACAO_NECESSIDADE'])) {
                                                                            case 'BAIXA':
                                                                                echo '#6c757d'; // Cinza
                                                                                break;
                                                                            case 'NORMAL':
                                                                                echo '#007bff'; // Azul
                                                                                break;
                                                                            case 'URGENTE':
                                                                                echo '#dc3545'; // Vermelho
                                                                                break;
                                                                            default:
                                                                                echo '#6c757d'; // Cinza
                                                                        }
                                                                        ?> "></i>
        </tr>
<?php
    endforeach;
}
?>