<?php
session_start();
include "../../base/conexao_martdb.php"; // Ajuste o caminho conforme necessário

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitante = $_POST['solicitante'];
    $departamento = $_POST['departamento'];
    $dataSolicitacao = $_POST['dataSolicitacao'];
    $numeroChamado = $_POST['numeroChamado'];
    $loja = $_POST['loja'];
    $cidade = $_POST['cidade'];
    $prazoNecessario = $_POST['prazoNecessario'] . "- Dias";
    $item = $_POST['item'];
    $tamanho = $_POST['tamanho'];
    $cor = $_POST['cor'];
    $modelo = $_POST['modelo'];
    $espessura = $_POST['espessura'];
    $codigoFornecedor = $_POST['codigoFornecedor'];
    $tipoMaterial = $_POST['tipoMaterial'];
    $marca = $_POST['marca'];
    $quantidade = $_POST['quantidade'];
    $originalOuGenerico = $_POST['originalOuGenerico'];
    $unidade = $_POST['unidade'];
    $medida = $_POST['medida'];
    $gas = $_POST['gas'];
    $tensao = $_POST['tensao'];
    $potencia = $_POST['potencia'];
    $corrente = $_POST['corrente'];
    $roscaSolda = $_POST['roscaSolda'];
    $descricao = $_POST['descricao'];
    $classificacaoNecessidade = $_POST['classificacaoNecessidade'];
    $faturamento = $_POST['faturamento'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $localEntrega = $_POST['localEntrega'];
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $telFornecedor = $_POST['telFornecedor'];
    $emailFornecedor = $_POST['emailFornecedor'];
    $PrecoEstimado = $_POST['PrecoEstimado'];
    $USUARIOlogado = $_SESSION['nome'];

    // Prepare a consulta para inserir os dados na tabela solicitacao
    $sql = "INSERT INTO weboficial.WEB_ComprasRotineiras (
                solicitante, departamento, data_solicitacao, numero_chamado,
                loja, cidade, prazo_necessario,
                item, tamanho, cor, modelo, espessura, codigo_fornecedor, tipo_material, marca,
                quantidade, original_ou_generico, unidade, medida, gas, tensao, potencia, corrente, rosca_solda,
                descricao, classificacao_necessidade, faturamento, cnpj, endereco, local_entrega,
                nome_fornecedor, tel_fornecedor, email_fornecedor, Data_inclusao, usuario_inclusao, status, Valor_Estimado
            ) VALUES (
                :solicitante, :departamento, TO_DATE(:dataSolicitacao, 'YYYY-MM-DD'), :numeroChamado,
                :loja, :cidade, :prazoNecessario,
                :item, :tamanho, :cor, :modelo, :espessura, :codigoFornecedor, :tipoMaterial, :marca,
                :quantidade, :originalOuGenerico, :unidade, :medida, :gas, :tensao, :potencia, :corrente, :roscaSolda,
                :descricao, :classificacaoNecessidade, :faturamento, :cnpj, :endereco, :localEntrega,
                :nomeFornecedor, :telFornecedor, :emailFornecedor, SYSDATE, :usuario_inclusao, 'NOVO', :precoEstimado
            )";

    // Prepare a consulta
    $stmt = oci_parse($oracle, $sql);

    // Vincule os parâmetros
    oci_bind_by_name($stmt, ':solicitante', $solicitante);
    oci_bind_by_name($stmt, ':departamento', $departamento);
    oci_bind_by_name($stmt, ':dataSolicitacao', $dataSolicitacao);
    oci_bind_by_name($stmt, ':numeroChamado', $numeroChamado);
    oci_bind_by_name($stmt, ':loja', $loja);
    oci_bind_by_name($stmt, ':cidade', $cidade);
    oci_bind_by_name($stmt, ':prazoNecessario', $prazoNecessario);
    oci_bind_by_name($stmt, ':item', $item);
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

    // Execute a consulta
    if (oci_execute($stmt)) {
        // Se a execução foi bem-sucedida, recupera o ID da última inserção
        $queryId = "SELECT id FROM weboficial.WEB_ComprasRotineiras
            WHERE numero_chamado = :numeroChamado
            AND data_solicitacao = TO_DATE(:dataSolicitacao, 'YYYY-MM-DD')
            AND usuario_inclusao = :usuario_inclusao";
        $stmtId = oci_parse($oracle, $queryId);
        oci_bind_by_name($stmtId, ':numeroChamado', $numeroChamado);
        oci_bind_by_name($stmtId, ':dataSolicitacao', $dataSolicitacao);
        oci_bind_by_name($stmtId, ':usuario_inclusao', $USUARIOlogado);
        oci_execute($stmtId);

        $row = oci_fetch_assoc($stmtId);
        if ($row) {
            $solicitacaoId = $row['ID'];

            // Processa as imagens se houver
            if (!empty($_FILES['imagem']['name'][0])) {
                $uploadDir = 'Config/uploads/';
                $fileNames = $_FILES['imagem']['name'];
                $fileTmpNames = $_FILES['imagem']['tmp_name'];
                $fileErrors = $_FILES['imagem']['error'];
                $fileSizes = $_FILES['imagem']['size'];
                $fileTypes = $_FILES['imagem']['type'];

                foreach ($fileNames as $index => $fileName) {
                    if ($fileErrors[$index] === UPLOAD_ERR_OK) {
                        $filePath = $uploadDir . basename($fileName);
                        if (move_uploaded_file($fileTmpNames[$index], $filePath)) {
                            $sqlImg = "INSERT INTO weboficial.imagens_solicitacaoCompras (solicitacao_id, imagem_caminho, DATA_INCLUSAO)
                                VALUES (:solicitacao_id, :imagem_path, SYSDATE)";
                            $stmtImg = oci_parse($oracle, $sqlImg);
                            oci_bind_by_name($stmtImg, ':solicitacao_id', $solicitacaoId);
                            oci_bind_by_name($stmtImg, ':imagem_path', $filePath);
                            oci_execute($stmtImg);
                        }
                    }
                }
            }
            echo '1'; // Sucesso
        } else {
            echo '0'; // Falha na recuperação do ID
        }
    } else {
        // Exibe o erro se a execução da consulta falhar
        $e = oci_error($stmt);
        echo "Erro ao executar a consulta: " . $e['message'];

        // Exibe a consulta com os valores dos parâmetros para depuração
        echo "<pre>";
        echo "Query preparada:\n";
        echo "INSERT INTO weboficial.WEB_ComprasRotineiras (
                solicitante, departamento, data_solicitacao, numero_chamado,
                loja, cidade, prazo_necessario,
                item, tamanho, cor, modelo, espessura, codigo_fornecedor, tipo_material, marca,
                quantidade, original_ou_generico, unidade, medida, gas, tensao, potencia, corrente, rosca_solda,
                descricao, classificacao_necessidade, faturamento, cnpj, endereco, local_entrega,
                nome_fornecedor, tel_fornecedor, email_fornecedor, Data_inclusao, usuario_inclusao, status, Valor_Estimado
            ) VALUES (
                '$solicitante', '$departamento', TO_DATE('$dataSolicitacao', 'YYYY-MM-DD'), '$numeroChamado',
                '$loja', '$cidade', '$prazoNecessario',
                '$item', '$tamanho', '$cor', '$modelo', '$espessura', '$codigoFornecedor', '$tipoMaterial', '$marca',
                '$quantidade', '$originalOuGenerico', '$unidade', '$medida', '$gas', '$tensao', '$potencia', '$corrente', '$roscaSolda',
                '$descricao', '$classificacaoNecessidade', '$faturamento', '$cnpj', '$endereco', '$localEntrega',
                '$nomeFornecedor', '$telFornecedor', '$emailFornecedor', SYSDATE, '$USUARIOlogado', 'NOVO', '$PrecoEstimado'
            );";
        echo "</pre>";
    }
}
?>
