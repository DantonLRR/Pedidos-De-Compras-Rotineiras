<?php
session_start();
include "../../base/conexao_martdb.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitante = $_POST['solicitante'];
    $departamento = $_POST['departamento'];
    $dataSolicitacao = $_POST['dataSolicitacao'];
    $numeroChamado = $_POST['numeroChamado'];
    $loja = $_POST['loja'];
    $cidade = $_POST['cidade'];
    $prazoNecessario = $_POST['prazoNecessario'] . "- Dias";
    $USUARIOlogado = $_SESSION['nome'];
    $classificacaoNecessidade = $_POST['classificacaoNecessidade'];
    $faturamento = $_POST['faturamento'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $localEntrega = $_POST['localEntrega'];
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $telFornecedor = $_POST['telFornecedor'];
    $emailFornecedor = $_POST['emailFornecedor'];

    // Gera um novo seqRequisicao
    $sqlSeq = "SELECT weboficial.seq_cotacao.NEXTVAL AS NEXTVAL FROM dual";
    $stmtSeq = oci_parse($oracle, $sqlSeq);
    oci_execute($stmtSeq);
    $rowSeq = oci_fetch_assoc($stmtSeq);
    $seqCotacao = $rowSeq['NEXTVAL'];

    // Loop através dos itens enviados
    foreach ($_POST['item'] as $i => $item) {
        $tamanho = $_POST['item'][$i]['tamanho'];
        $cor = $_POST['item'][$i]['cor'];
        $modelo = $_POST['item'][$i]['modelo'];
        $espessura = $_POST['item'][$i]['espessura'];
        $codigoFornecedor = $_POST['item'][$i]['codigoFornecedor'];
        $tipoMaterial = $_POST['item'][$i]['tipoMaterial'];
        $marca = $_POST['item'][$i]['marca'];
        $quantidade = $_POST['item'][$i]['quantidade'];
        $originalOuGenerico = $_POST['item'][$i]['originalOuGenerico'];
        $unidade = $_POST['item'][$i]['unidade'];
        $medida = $_POST['item'][$i]['medida'];
        $gas = $_POST['item'][$i]['gas'];
        $tensao = $_POST['item'][$i]['tensao'];
        $potencia = $_POST['item'][$i]['potencia'];
        $corrente = $_POST['item'][$i]['corrente'];
        $roscaSolda = $_POST['item'][$i]['roscaSolda'];
        $descricao = $_POST['item'][$i]['descricao'];
        $PrecoEstimado = $_POST['item'][$i]['precoEstimado'];
        $itemCotado = $_POST['item'][$i]['nome'];

        // Inserção de cada item
        $sql = "INSERT INTO weboficial.WEB_ComprasRotineiras (
                    solicitante, departamento, data_solicitacao, numero_chamado,
                    loja, cidade, prazo_necessario,
                    item, tamanho, cor, modelo, espessura, codigo_fornecedor, tipo_material, marca,
                    quantidade, original_ou_generico, unidade, medida, gas, tensao, potencia, corrente, rosca_solda,
                    descricao, classificacao_necessidade, faturamento, cnpj, endereco, local_entrega,
                    nome_fornecedor, tel_fornecedor, email_fornecedor, Data_inclusao, usuario_inclusao, status, Valor_Estimado, SEQ_COTACAO
                ) VALUES (
                    :solicitante, :departamento, TO_DATE(:dataSolicitacao, 'YYYY-MM-DD'), :numeroChamado,
                    :loja, :cidade, :prazoNecessario,
                    :item, :tamanho, :cor, :modelo, :espessura, :codigoFornecedor, :tipoMaterial, :marca,
                    :quantidade, :originalOuGenerico, :unidade, :medida, :gas, :tensao, :potencia, :corrente, :roscaSolda,
                    :descricao, :classificacaoNecessidade, :faturamento, :cnpj, :endereco, :localEntrega,
                    :nomeFornecedor, :telFornecedor, :emailFornecedor, SYSDATE, :usuario_inclusao, 'NOVO', :precoEstimado, $seqCotacao
                ) RETURNING ID INTO :item_id"; // Aqui estamos retornando o ID do item inserido

        $stmt = oci_parse($oracle, $sql);

        // Vinculação dos parâmetros
        oci_bind_by_name($stmt, ':solicitante', $solicitante);
        oci_bind_by_name($stmt, ':departamento', $departamento);
        oci_bind_by_name($stmt, ':dataSolicitacao', $dataSolicitacao);
        oci_bind_by_name($stmt, ':numeroChamado', $numeroChamado);
        oci_bind_by_name($stmt, ':loja', $loja);
        oci_bind_by_name($stmt, ':cidade', $cidade);
        oci_bind_by_name($stmt, ':prazoNecessario', $prazoNecessario);
        oci_bind_by_name($stmt, ':item', $itemCotado);
        oci_bind_by_name($stmt, ':tamanho', $tamanho);
        oci_bind_by_name($stmt, ':cor', $cor);
        oci_bind_by_name($stmt, ':modelo', $modelo);
        oci_bind_by_name($stmt, ':espessura', $espessura);
        oci_bind_by_name($stmt, ':codigoFornecedor', $codigoFornecedor);
        oci_bind_by_name($stmt, ':tipoMaterial', $tipoMaterial);
        oci_bind_by_name($stmt, ':marca', $marca);
        oci_bind_by_name($stmt, ':quantidade', $quantidade);
        oci_bind_by_name($stmt, ':originalOuGenerico', $originalOuGenerico);
        oci_bind_by_name($stmt, ':unidade', $unidade);
        oci_bind_by_name($stmt, ':medida', $medida);
        oci_bind_by_name($stmt, ':gas', $gas);
        oci_bind_by_name($stmt, ':tensao', $tensao);
        oci_bind_by_name($stmt, ':potencia', $potencia);
        oci_bind_by_name($stmt, ':corrente', $corrente);
        oci_bind_by_name($stmt, ':roscaSolda', $roscaSolda);
        oci_bind_by_name($stmt, ':descricao', $descricao, 1000, SQLT_CHR);
        oci_bind_by_name($stmt, ':classificacaoNecessidade', $classificacaoNecessidade);
        oci_bind_by_name($stmt, ':faturamento', $faturamento);
        oci_bind_by_name($stmt, ':cnpj', $cnpj);
        oci_bind_by_name($stmt, ':endereco', $endereco);
        oci_bind_by_name($stmt, ':localEntrega', $localEntrega);
        oci_bind_by_name($stmt, ':nomeFornecedor', $nomeFornecedor);
        oci_bind_by_name($stmt, ':telFornecedor', $telFornecedor);
        oci_bind_by_name($stmt, ':emailFornecedor', $emailFornecedor);
        oci_bind_by_name($stmt, ':usuario_inclusao', $USUARIOlogado);
        oci_bind_by_name($stmt, ':precoEstimado', $PrecoEstimado);

        // para capturar o ID do item inserido e retornado pelo returning
        // depois vinculamos o valor a variavel
        oci_bind_by_name($stmt, ':item_id', $itemId, 32);
        if (oci_execute($stmt)) {
            // Processa as imagens se houver
            if (!empty($_FILES['item']['name'][$i]['imagens'][0])) {
                $uploadDir = '../Config/uploads/';
                $fileNames = $_FILES['item']['name'][$i]['imagens']; // Pega as imagens do item atual
                $fileTmpNames = $_FILES['item']['tmp_name'][$i]['imagens'];
                $fileErrors = $_FILES['item']['error'][$i]['imagens'];

                foreach ($fileNames as $index => $fileName) {
                    if ($fileErrors[$index] === UPLOAD_ERR_OK) {
                        $filePath = $uploadDir . basename($fileName);
                        if (move_uploaded_file($fileTmpNames[$index], $filePath)) {
                            // Inserção do caminho da imagem na base de dados
                            $sqlImg = "INSERT INTO weboficial.imagens_solicitacaoCompras (solicitacao_id, imagem_caminho, DATA_INCLUSAO)
                                       VALUES (:solicitacao_id, :imagem_path, SYSDATE)";
                            $stmtImg = oci_parse($oracle, $sqlImg);
                            oci_bind_by_name($stmtImg, ':solicitacao_id', $itemId); // Usa o ID do item
                            oci_bind_by_name($stmtImg, ':imagem_path', $filePath);
                            oci_execute($stmtImg);
                        }
                    }
                }
            }
        }
    }

    echo '1'; // Sucesso
} else {
    echo '0'; // Falha
}
