<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Requisição de Compra</title>
    <link rel="stylesheet" href="css/style_Formulario.css"> <!-- Link para o arquivo CSS separado -->
    <link rel="icon" type="image/png" href="../base/img/martband.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="../base/mdb/css/mdb.css" rel="stylesheet">
    <link href="../base/assets/css/paper-dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../base/DataTables/datatables.min.css" />
    <link href="../base/jquery_ui/jquery/jquery-ui.css" rel="stylesheet">
    <link rel='stylesheet' href='http://fonts.googleapis.com/icon?family=Material+Icons' type='text/css'>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css">
    <link rel="stylesheet" href="../base/dist/sidenav.css" type="text/css">
    <link rel="stylesheet" href="../base/bootstrap-multiselect/bootstrap-select-1.13.14/dist/css/bootstrap-select.css" type="text/css">
    <link href="../base/mdb/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../BASE/cssGeral.css" type="text/css">

</head>

<body>
    <?php
    include "../base/conexao_martdb.php";
    include "../base/conexao_TotvzOracle.php";
    include "config/php/crud_gerenciamento.php";
    include "../MobileNav/docs/index_menucomlogin.php";
    $USUARIO = $_SESSION['NomeUsuario'];
    $hoje = date('Y-m-d');
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
    <section class="body">
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header text-center identidadeMartMinaseDom">Requisição de Compra</div>
                        <div class="card-body">
                            <form class="needs-validation" id="form" novalidate>
                                <h4 class="text-center mb-4">Formulário de Compras</h4>

                                <!-- Seção 1: Informações do Solicitante -->
                                <fieldset>
                                    <legend>Informações do Solicitante</legend>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="solicitante">Solicitante:</label>
                                                <input type="text" class="form-control" value="<?= $dadosDeQuemEstaLogadoNome ?>" id="solicitante" name="solicitante" placeholder="Nome do solicitante" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o nome do solicitante.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="departamento">Departamento:</label>
                                                <input type="text" class="form-control" value='<?= $dadosDeQuemEstaLogadoCENTROCUSTO ?>' id="departamento" name="departamento" disabled required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o departamento.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dataSolicitacao">Data da Solicitação:</label>
                                                <input type="date" class="form-control" id="dataSolicitacao" name="dataSolicitacao" value="<?= $hoje ?>" disabled required>
                                                <div class="invalid-feedback">
                                                    Por favor, selecione a data da solicitação.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="numeroChamado">Nº Chamado:</label>
                                                <input type="text" class="form-control" id="numeroChamado" name="numeroChamado" placeholder="Número do chamado" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o número do chamado.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Seção 2: Informações da Loja -->
                                <fieldset>
                                    <legend>Informações da Loja</legend>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="loja">Loja:</label>
                                                <input type="text" class="form-control" id="loja" name="loja" placeholder="Nome da loja" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o nome da loja.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cidade">Cidade:</label>
                                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira a cidade.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-sm-6">
                                            <label for="prazoNecessario">Prazo Necessário (dias):</label>
                                            <input type="number" class="form-control" id="prazoNecessario" name="prazoNecessario" placeholder="Número de dias" required>
                                            <div class="invalid-feedback">
                                                Por favor, insira o prazo necessário em dias.
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Classificação de Necessidade:</label>
                                            <div class="radio-group">
                                                <div class="form-check">
                                                    <input type="radio" id="classificacaoBaixa" name="classificacaoNecessidade" value="BAIXA" class="form-check-input" required>
                                                    <label class="form-check-label" for="classificacaoBaixa">Baixa</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" id="classificacaoNormal" name="classificacaoNecessidade" value="NORMAL" class="form-check-input" required>
                                                    <label class="form-check-label" for="classificacaoNormal">Normal</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" id="classificacaoUrgente" name="classificacaoNecessidade" value="URGENTE" class="form-check-input" required>
                                                    <label class="form-check-label" for="classificacaoUrgente">Urgente</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>

                                <!-- Seção 3: Informações do Item -->
                                <!-- <fieldset>
                                    <legend>Informações dos Itens</legend>
                                    <div id="itemContainer">
                                        <div class="item" id="item-1">
                                            <legend>Informações do Item 1</legend>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="item">Item:</label>
                                                        <input type="text" class="form-control" name="item[]" placeholder="Nome do item" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="PrecoEstimado">Preço Estimado:</label>
                                                        <input type="text" class="form-control PrecoEstimado" name="PrecoEstimado[]" placeholder="0,00" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tamanho">Tamanho:</label>
                                                        <input type="text" class="form-control" name="tamanho[]" placeholder="Tamanho">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cor">Cor:</label>
                                                        <input type="text" class="form-control" id="cor" name="cor[]" value="N/A" placeholder="Cor">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="modelo">Modelo:</label>
                                                        <input type="text" class="form-control" id="modelo" name="modelo[]" value="N/A" placeholder="Modelo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="espessura">Espessura:</label>
                                                        <input type="text" class="form-control" id="espessura" name="espessura[]" value="N/A" placeholder="Espessura">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="codigoFornecedor">Código Fornecedor:</label>
                                                        <input type="text" class="form-control" id="codigoFornecedor" name="codigoFornecedor[]" value="N/A" placeholder="Código do fornecedor">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tipoMaterial">Tipo Material:</label>
                                                        <input type="text" class="form-control" id="tipoMaterial" name="tipoMaterial[]" value="N/A" placeholder="Tipo de material">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="marca">Marca:</label>
                                                        <input type="text" class="form-control" id="marca" name="marca[]" value="N/A" placeholder="Marca">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="quantidade">Quantidade:</label>
                                                        <input type="number" class="form-control" id="quantidade" name="quantidade[]" value='0' placeholder="Quantidade" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="originalOuGenerico">Original ou Genérico:</label>
                                                        <div class="radio-group">
                                                            <div class="form-check">
                                                                <input type="radio" id="original" name="originalOuGenerico[]" value="original" class="form-check-input" required>
                                                                <label class="form-check-label" for="original">Original</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" id="generico" name="originalOuGenerico[]" value="generico" class="form-check-input" required>
                                                                <label class="form-check-label" for="generico">Genérico</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="unidade">Unidade:</label>
                                                        <input type="number" class="form-control" id="unidade" name="unidade[]" value="0" placeholder="Unidade">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="medida">Medida (Bitola, MM, Polegada):</label>
                                                        <input type="text" class="form-control" id="medida" name="medida[]" value="N/A" placeholder="Medida">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gas">Gás:</label>
                                                        <input type="text" class="form-control" id="gas" name="gas[]" value="N/A" placeholder="Gás">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tensao">Tensão:</label>
                                                        <input type="text" class="form-control" id="tensao" name="tensao[]" value="N/A" placeholder="Tensão">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="potencia">Potência:</label>
                                                        <input type="text" class="form-control" id="potencia" name="potencia[]" value="N/A" placeholder="Potência">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="corrente">Corrente:</label>
                                                        <input type="text" class="form-control" id="corrente" name="corrente[]" value="N/A" placeholder="Corrente">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="roscaSolda">Rosca / Solda:</label>
                                                <input type="text" class="form-control" id="roscaSolda" name="roscaSolda[]" value="N/A" placeholder="Rosca / Solda">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="imagem">Imagem do Item:</label>
                                                        <input type="file" class="form-control" id="imagem" name="imagens[]" accept="image/*" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descricao">DESCRIÇÃO (detalhado c/especificação):</label>
                                                <textarea class="form-control" id="descricao" name="descricao[]" rows="4" placeholder="Descrição detalhada" required></textarea>
                                            </div>
                                            <div id="novoFormularioDeItem">

                                            </div>
                                            <div class="d-flex justify-content-end align-items-end">
                                                <i class="fa-solid fa-circle-plus fa-2xl BotaoAdicionaItensnaCotacao"></i>

                                            </div>
                                </fieldset> -->
                                <fieldset>
                                    <legend>Itens para Cotação</legend>
                                    <p>Por favor, preencha os detalhes de cada item que deseja cotar. Clique no botão abaixo para adicionar itens.</p>
                                    <div id="itemContainer">
                                        <div class="itens">
                                            <div id="FormularioDeItem">
                                                <!-- Formulários de itens serão adicionados aqui -->
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center mt-3">
                                                <button type="button" class="btn BotaoAdicionaItensnaCotacao">
                                                    <i class="fa-solid fa-circle-plus"></i> Adicionar Item
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Seção 4: Faturamento -->
                                <fieldset>
                                    <legend>Faturamento</legend>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="faturamento">Faturamento:</label>
                                                <input type="text" class="form-control" id="faturamento" name="faturamento" placeholder="Nome da empresa de faturamento" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o nome da empresa de faturamento.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cnpj">CNPJ:</label>
                                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o CNPJ.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="endereco">Endereço:</label>
                                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" required>
                                                <div class="invalid-feedback">
                                                    Por favor, insira o endereço.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Seção 5: Local de Entrega -->
                                <fieldset>
                                    <legend>Local de Entrega</legend>
                                    <div class="form-group mb-3">
                                        <label for="localEntrega">Local de Entrega:</label>
                                        <input type="text" class="form-control" id="localEntrega" name="localEntrega" placeholder="Local de entrega" required>
                                        <div class="invalid-feedback">
                                            Por favor, insira o local de entrega.
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- Seção 6: Indicações de Fornecedores -->
                                <fieldset>
                                    <legend>Indicações de Fornecedores</legend>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nomeFornecedor">Nome:</label>
                                                <input type="text" class="form-control" id="nomeFornecedor" name="nomeFornecedor" placeholder="Nome do fornecedor">
                                                <div class="invalid-feedback">
                                                    Por favor, insira o nome do fornecedor.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telFornecedor">Telefone:</label>
                                                <input type="tel" class="form-control" id="telFornecedor" name="telFornecedor" placeholder="Telefone">
                                                <div class="invalid-feedback">
                                                    Por favor, insira o telefone do fornecedor.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="emailFornecedor">E-mail:</label>
                                                <input type="email" class="form-control" id="emailFornecedor" name="emailFornecedor" placeholder="E-mail">
                                                <div class="invalid-feedback">
                                                    Por favor, insira o e-mail do fornecedor.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-center mt-4">
                                    <button class="btnEnviar btn identidadeMartMinaseDom">Enviar</button>
                                    <button class="btnLimpar btn" type="reset">Limpar</button>
                                </div>
                            </form>
                        </div>
                        <!-- <footer class="card-footer text-center">

                    </footer> -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script type="text/javascript" src="../BASE/mdb/js/jquery.js"></script>
    <script type="module" src="Js/Script_Formulario.js"></script>
    <script type="text/javascript" src="../BASE/mdb/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../BASE/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="../BASE/mdb/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../BASE/jquery_ui/jquery/jquery-ui.js"></script>
    <script src="../BASE/mdb/bootstrap/js/bootstrap.min.js"></script>
    <script src="../BASE/mdb/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../BASE/bootstrap-multiselect/bootstrap-select-1.13.14/dist/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="../BASE/jQuery-Mask/dist/jquery.mask.js"></script>
    <script src="../base/dist/sidenav.js"></script>
</body>

</html>