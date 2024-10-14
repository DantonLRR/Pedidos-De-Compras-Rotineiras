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

    $hoje = date('Y-m-d'); // Data atual
    $primeiroDiaDoMes = date('Y-m-01'); // Primeiro dia do mês atual
    $ultimoDiaMes = date("Y-m-t"); // Último dia do mês atual no formato Ano-Mês-Dia


    $pessoaLogada = new PessoaLogada($TotvsOracle, $_SESSION['cpf'], $_SESSION['LOJA']);

    // Acessando os dados
    $dadosDeQuemEstaLogadoNome = $pessoaLogada->getNome();
    $dadosDeQuemEstaLogadoCENTROCUSTO = $pessoaLogada->getCentroCusto();
    $dadosDeQuemEstaLogadoCARGO = $pessoaLogada->getCargo();

    $funcoes = new funcoesEmPHP();
    $InformacoesCotacoes = new InformacoesCotacoes();

    ?>

    <input class="usu" style="display:none" id="usuarioLogado" value="<?= $_SESSION['nome'] ?>">
    <input class="usu" id="usuarioLogado" value="<?= $_SESSION['nome'] ?>">
    <input class="loja" id="loja" value="<?= $_SESSION['LOJA'] ?>">
    <input class="" id="dadosDeQuemEstaLogadoNome" value="<?= $dadosDeQuemEstaLogadoNome ?>">
    <input class="" id="dadosDeQuemEstaLogadoCENTROCUSTO" value="<?= $dadosDeQuemEstaLogadoCENTROCUSTO ?>">
    <input class="" id="CARGO" value="<?= $dadosDeQuemEstaLogadoCARGO ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        Filtro de Cotações
                    </div>
                    <div class="card-body">
                        <form class="row g-3 align-items-end">
                            <div class="col-md-2 col-sm-4">
                                <label for="dataInicio" class="form-label">Data início:</label>
                                <input type="date" value="<?= htmlspecialchars($primeiroDiaDoMes) ?>" class="form-control" id="dataInicio" name="dataInicio" required>
                            </div>
                            <div class="col-md-2 col-sm-4">
                                <label for="datafim" class="form-label">Data fim:</label>
                                <input type="date" value="<?= htmlspecialchars($ultimoDiaMes) ?>" class="form-control" id="datafim" name="datafim" required>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label for="departamentoPesquisa" class="form-label">Departamento:</label>
                                <select class="form-select departamentoPesquisa" id="departamentoPesquisa" name="departamentoPesquisa" required>
                                    <?php if ($dadosDeQuemEstaLogadoCENTROCUSTO != 'SUPRIMENTOS'): ?>
                                        <option selected value="<?= htmlspecialchars($dadosDeQuemEstaLogadoCENTROCUSTO) ?>">
                                            <?= htmlspecialchars($dadosDeQuemEstaLogadoCENTROCUSTO) ?>
                                        </option>
                                    <?php else: ?>
                                        <option value="" disabled selected>Selecione o departamento</option>
                                        <?php
                                        $buscandoDepartamentos = $InformacoesCotacoes->buscaDepartamentos($oracle);
                                        foreach ($buscandoDepartamentos as $rowDepartamentos):
                                        ?>
                                            <option value="<?= htmlspecialchars($rowDepartamentos['DEPARTAMENTO']) ?>">
                                                <?= htmlspecialchars($rowDepartamentos['DEPARTAMENTO']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-4">
                                <label for="statusPesquisa" class="form-label">Status:</label>
                                <select class="form-select" id="statusPesquisa" name="statusPesquisa" required>
                                    <option value="" disabled selected>Selecione o status</option>
                                    <option value="NOVO">NOVO</option>
                                    <option value="EM COTAÇÃO">EM COTAÇÃO</option>
                                    <option value="COTADO">COTADO</option>
                                    <option value="APROVADO PARA COMPRA">APROVADO PARA COMPRA</option>
                                    <option value="REPROVADO">REPROVADO</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-4 d-flex align-items-end">
                                <button type="button" id="PesquisarGerenciamentoCotacao" class="btn btn-primary w-100">Pesquisar</button>
                            </div>
                        </form>
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
                        <?php if ($dadosDeQuemEstaLogadoCENTROCUSTO == 'SUPRIMENTOS'): ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="PesquisaDireta" class="form-label">Pesquisa Direta:</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="PesquisaDireta" name="PesquisaDireta" placeholder="Digite aqui o ID do item" required>
                                        <button class="btn btn-primary btnPesquisaDireta" type="button" id="btnPesquisaDireta" style="height: 38px; width: 40px;">
                                            <i class="fa-solid fa-arrow-right fa-lg" style="color: #ffffff;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <table class="table table-bordered table-striped" id="TabelaAcompanhamentoGerenciamentoCotacao">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="text-center" style='background-color: #00a451 !important'>Cotação</th>
                                    <th class="text-center" style='background-color: #00a451 !important'>ID item</th>
                                    <th class="text-center" style='background-color: #00a451 !important'>item</th>
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
                                $buscandoAcompanhamento = $FiltrosAcompanhamento->buscandoCotacoesPesquisa($oracle,  $primeiroDiaDoMes, $ultimoDiaMes, 'NOVO', $dadosDeQuemEstaLogadoCENTROCUSTO);
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
                                        <td class="statusDaCotacao text-center statusDoPedido " style="color: <?= $funcoes->definirCorStatus(htmlspecialchars($row['STATUS'])) ?>;">
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
                        <div class="action-buttons" id="actionButtons">

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
</body>

</html>