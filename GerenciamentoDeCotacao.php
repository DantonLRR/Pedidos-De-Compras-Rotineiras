<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Gerenciamento de Cotações</title>
    <link rel="icon" type="image/png" href="../base/img/martband.png">
    <link href="../base/mdb/css/bootstrap.css" rel="stylesheet">
    <link href="../base/assets/css/paper-dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="../base/DataTables/datatables.min.css" type="text/css">
    <link rel="stylesheet" href="../base/dist/sidenav.css" type="text/css">
    <link rel="stylesheet" href="../../BASE/DataTables/FixedColumns 4.3.0/FixedColumns-4.3.0/css/fixedColumns.dataTables.min.css" type="text/css">
    <link rel="stylesheet" href="../BASE/cssGeral.css" type="text/css">
    <link rel="stylesheet" href="css/gerenciamento.css" type="text/css">
    <link rel="icon" type="../base/image/png" href="../base/img/martband.png">
</head>

<body>
    <?php
    include "../base/conexao_martdb.php";
    include "../MobileNav/docs/index_menucomlogin.php";
    include "../base/conexao_TotvzOracle.php";
    include "config/php/crud_gerenciamento.php";


    // Exemplo de uso
    $pessoaLogada = new PessoaLogada($TotvsOracle, $_SESSION['cpf'], $_SESSION['LOJA']);

    // Acessando os dados
    $dadosDeQuemEstaLogadoNome = $pessoaLogada->getNome();
    $dadosDeQuemEstaLogadoCENTROCUSTO = $pessoaLogada->getCentroCusto();
    $dadosDeQuemEstaLogadoCARGO = $pessoaLogada->getCargo();

    ?>
    <input class="usu" style="display:none" id="usuarioLogado" value="<?= $_SESSION['nome'] ?>">
    <input class="usu" id="usuarioLogado" value="<?= $_SESSION['nome'] ?>">
    <input class="loja" id="loja" value="<?= $_SESSION['LOJA'] ?>">
    <input class="" id="dadosDeQuemEstaLogadoNome" value="<?= $dadosDeQuemEstaLogadoNome ?>">
    <input class="" id="dadosDeQuemEstaLogadoCENTROCUSTO" value="<?= $dadosDeQuemEstaLogadoCENTROCUSTO ?>">
    <input class="" id="CARGO" value="<?= $dadosDeQuemEstaLogadoCARGO ?>">
    <div class="container-fluid">
    <div class="row" id="">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-center">
                    Filtro de Cotações
                </div>
                <div class="card-body">
                    <form class="row g-4 align-items-end">
                        <div class="col-md-3">
                            <label for="dataInicio" class="form-label">Data início:</label>
                            <input type="date" class="form-control" id="dataInicio" required>
                        </div>
                        <div class="col-md-3">
                            <label for="datafim" class="form-label">Data fim:</label>
                            <input type="date" class="form-control" id="datafim" required>
                        </div>
                        <div class="col-md-3">
                            <label for="statusPesquisa" class="form-label">Status:</label>
                            <select class="form-select" id="statusPesquisa" required>
                                <option value="" disabled selected>Selecione o status</option>
                                <option value="NOVO">NOVO</option>
                                <option value="EM COTAÇÃO">EM COTAÇÃO</option>
                                <option value="COTADO">COTADO</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" id="PesquisarGerenciamentoCotacao" class="btn w-100">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header text-center">
                    Gerenciamento de Cotações
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="TabelaAcompanhamentoGerenciamentoCotacao">
                        <thead class="thead-custom">
                            <tr>
                                <th class="text-center" style='background-color: #00a451 !important'>ID</th>
                                <th class="text-center" style='background-color: #00a451 !important'>Solicitante</th>
                                <th class="text-center">Departamento</th>
                                <th class="text-center">Data Solicitação</th>
                                <th class="text-center">Número Chamado</th>
                                <th class="text-center">Loja</th>
                                <th class="text-center">Cidade</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Urgência </th>
                                <th class="text-center">Ações</th>

                            </tr>
                        </thead>
                        <tbody class='TabelaAcompanhamentoGerenciamentoCotacao'>
                            <?php
                            $FiltrosAcompanhamento = new FiltrosAcompanhamento();
                            $dataInicio = $_POST['dataInicio'] ?? '';
                            $datafim = $_POST['datafim'] ?? '';
                            $buscandoAcompanhamento = $FiltrosAcompanhamento->buscandoCotacoes($oracle, $dataInicio, $datafim);
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
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="detalhesCotacaoModal" tabindex="-1" aria-labelledby="detalhesCotacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style='background: linear-gradient(to right, #00a451, #052846 85%) !important; color: white;'>
                    <h5 class="modal-title" id="detalhesCotacaoModalLabel">Detalhes da Cotação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalDetalhesConteudo">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="action-buttons">
                        <?php
                        switch (strtoupper(trim($dadosDeQuemEstaLogadoCENTROCUSTO))) {
                            case 'SUPRIMENTOS':
                        ?>
                                <button type="button" class="btn btn-secondary btnSuprimentosAprova"id='btnSuprimentosAprova'>Aprovar</button>
                                <button type="button" class="btn btn-secondary btnSuprimentosReprova"id='btnSuprimentosReprova'>Reprovar</button>
                            <?php
                                break;
                            default: ?>
                        <?php
                        }
                        ?>
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>



    <script type="module" src="js/Script_gerenciamento.js"></script>
    <script type="text/javascript" src="../base/mdb/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../base/mdb/js/jquery.min.js"></script>
    <script type="text/javascript" src="../base/bootstrap-5.0.2/bootstrap-5.0.2/dist/js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="../base/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../../BASE/DataTables/FixedColumns 4.3.0/FixedColumns-4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script type="module">
        import {
            criandoHtmlmensagemCarregamento,
            Toasty
        } from "../../base/jsGeral.js";
    </script>
</body>

</html>