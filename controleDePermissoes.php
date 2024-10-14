<!DOCTYPE html>
<html lang="pt-br">
<meta charset="utf-8" />

<head>
    <link rel="icon" type="../base/image/png" href="../base/img/martband.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;400;600&family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="../BASE/mdb/css/bootstrap.css" rel="stylesheet">
    <link href="../BASE/mdb/css/mdb.css" rel="stylesheet">
    <link rel="stylesheet" href="../BASE/datetimepicker/jquery.datetimepicker.min.css" />
    <link href="../BASE/assets/css/paper-dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="../BASE/jquery_ui/jquery/jquery-ui.css">
    <link rel="stylesheet" href="../BASE/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../BASE/cssGeral.css">
    <link rel="stylesheet" href="css/ControleDePermissoes.css">
</head>

<body class="bg-light">
    <?php
    include "../MobileNav/docs/index_menucomlogin.php";
    include "../base/conexao_TotvzOracle.php";
    include "../base/Conexao_martdb.php";
    include "config/php/crud_controle_de_permissao.php";
    $dados = new dados();
    $USUARIO = $_SESSION['nome'];
    $cpf = $_SESSION['cpf'];
    ?>
    <style>
    .linhaMarcada tr:hover {
        background-color: lightblue !important;
    }

    .degrade {
        background: linear-gradient(to right, #00a451, #052846 85%);
        font-weight: bold;
        color: white
    }

    .trr {
        cursor: pointer;
    }
</style>
    <div class="container-fluid">
        <div class="row cardGerenciamentoPermissao">
            <div class="col-lg-12 mt-4">
                <div class="card">
                    <div class="card-header text-center text-white bg-success">Gerenciamento de permissão</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card h-100">
                                    <h6 class="card-header text-center font-weight-bold text-uppercase bg-success text-white">Gerenciamento Compras Rotineiras</h6>
                                    <div class="card-body">
                                        <table id="table1" class="table table-bordered table-hover text-center table-striped">
                                            <input class="usu" type="hidden" value="<?= $_SESSION['nome'] ?>">
                                            <input class="loja" type="hidden" value="<?= $_SESSION['LOJA'] ?>">
                                            <thead class="bg-success text-white">
                                                <tr>
                                                    <th style="display:none">ID</th>
                                                    <th style="display:none">STATUS</th>
                                                    <th>Processos</th>
                                                </tr>
                                            </thead>
                                            <tbody class="linhaMarcada">
                                                <?php
                                                $processos = [
                                                    ['id' => 1, 'id' => 2,'status'=> 'F' , 'nome' => 'Formulario De Pedidos Rotineiros'],
                                                    ['id' => 2, 'id' => 2,'status'=> 'A' , 'nome' => 'Aprovação de Pedidos para Compra Rotineiras']
                                                ];
                                                foreach ($processos as $processo) {
                                                ?>
                                                    <tr class='trr'>
                                                        <td style="display:none"><?= $processo['id'] ?></td>
                                                        <td style="display:none"><?= $processo['status'] ?></td>
                                                        <td><?= $processo['nome'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card h-100">
                                    <h6 class="card-header text-center font-weight-bold text-uppercase bg-success text-white">Gerenciar usuários</h6>
                                    <div class="card-body">
                                        <div id="table" class="table-editable"></div>
                                        <div class="tablereq">
                                        </div>
                                        <div class="d-flex justify-content-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalLabel">Adicionar tipo de movimentação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <label for="validationCustom02" class="form-label">Tipo de Movimentação:</label>
                        <input type="text" class="form-control novoTipoMovimentacao" id="validationCustom02" required>
                        <div class="invalid-feedback">Campo obrigatório.</div>
                    </div>
                    <div class="col-lg-4 pt-3">
                        <button type="button" class="btn btn-success text-white AdicionarNovoTipoMovimentacao">Adicionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module" src="js/ControleDePermissoes.js"></script>
<script type="text/javascript" src="../base/mdb/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script type="text/javascript" src="../BASE/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../base/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="../base/mdb/js/mdb.min.js"></script>
<script type="text/javascript" src="../BASE/bootstrap-multiselect/bootstrap-select-1.13.14/dist/js/bootstrap-select.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"> </script> -->
<script type="text/javascript" src="../base/jquery_ui/jquery/jquery-ui.js"></script>
<script src="../BASE/mdb/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../BASE/formulario7/formulario/js/out/jquery.idealforms.js"></script>
<script src="../BASE/formulario7/formulario/js/i18n/jquery.idealforms.i18n.pt.js"></script>
<script type="text/javascript" src="../BASE/bootstrap-multiselect/bootstrap-select-1.13.14/dist/js/bootstrap-select.js"></script>
<script src="../base/dist/sidenav.js"></script>