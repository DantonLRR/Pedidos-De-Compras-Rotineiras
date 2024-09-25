<?php
session_start();
include "../../base/conexao_martdb.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cotacaoId = $_POST['id'];
    $opcaoEscolhida = $_POST['opcaoEscolhida'];
    // Verifica se o ID foi fornecido
    if (!empty($cotacaoId) && $opcaoEscolhida == 'Aprovar') {
        $queryId = "SELECT a.status FROM weboficial.WEB_ComprasRotineiras a WHERE id = :cotacaoId";
        $stmtId = oci_parse($oracle, $queryId);
        oci_bind_by_name($stmtId, ':cotacaoId', $cotacaoId);
        oci_execute($stmtId);
        $row = oci_fetch_assoc($stmtId);
        if ($row) {
            // Pega o valor do campo 'STATUS'
            $status = $row['STATUS'];
            $response = ["sucesso" => 0, "mensagem" => ""]; // Resposta padrão

            switch ($status) {
                case 'NOVO':
                    // Consulta para atualizar o status para 'EM COTAÇÃO'
                    $sql = "UPDATE weboficial.WEB_ComprasRotineiras 
                            SET STATUS = 'EM COTAÇÃO'
                            WHERE id = :cotacaoId";
                    $stmt = oci_parse($oracle, $sql);
                    oci_bind_by_name($stmt, ':cotacaoId', $cotacaoId);
                    if (oci_execute($stmt)) {
                        $response["sucesso"] = 1;
                        $response["mensagem"] = "Cotação aprovada para 'EM COTAÇÃO'.";
                    } else {
                        $response["mensagem"] = "Erro ao atualizar o status para 'EM COTAÇÃO'.";
                    }
                    break;
                case 'EM COTAÇÃO':
                    // Consulta para atualizar o status para 'COTADO'
                    $sql = "UPDATE weboficial.WEB_ComprasRotineiras 
                                   SET STATUS = 'COTADO'
                                   WHERE id = :cotacaoId";
                    $stmt = oci_parse($oracle, $sql);
                    oci_bind_by_name($stmt, ':cotacaoId', $cotacaoId);
                    if (oci_execute($stmt)) {
                        $response["sucesso"] = 1;
                        $response["mensagem"] = "Cotação aprovada para 'COTADO'.";
                    } else {
                        $response["mensagem"] = "Erro ao atualizar o status para 'COTADO'.";
                    }
                    break;
                case 'COTADO':
                    // Consulta para atualizar o status para 'APROVADO PARA COMPRA'
                    $sql = "UPDATE weboficial.WEB_ComprasRotineiras 
                                       SET STATUS = 'APROVADO PARA COMPRA'
                                       WHERE id = :cotacaoId";
                    $stmt = oci_parse($oracle, $sql);
                    oci_bind_by_name($stmt, ':cotacaoId', $cotacaoId);
                    if (oci_execute($stmt)) {
                        $response["sucesso"] = 1;
                        $response["mensagem"] = "Cotação aprovada para 'APROVADO PARA COMPRA'.";
                    } else {
                        $response["mensagem"] = "Erro ao atualizar o status para 'APROVADO PARA COMPRA'.";
                    }
                    break;
                default:
                    $response["mensagem"] = "Status não reconhecido.";
                    break;
            }
        } else {
            $response["mensagem"] = "Nenhuma cotação encontrada com esse ID.";
        }
    } else if (!empty($cotacaoId) && $opcaoEscolhida == 'Reprovar') {
        $justificativa = $_POST['justificativa'];
        // Consulta para atualizar o status para 'REPROVADO'
        $sql = "UPDATE weboficial.WEB_ComprasRotineiras 
                            SET STATUS = 'REPROVADO',
                            justificativa_Reprova = :justificativa
                            WHERE id = :cotacaoId";
        $stmt = oci_parse($oracle, $sql);
        oci_bind_by_name($stmt, ':cotacaoId', $cotacaoId);
        oci_bind_by_name($stmt, ':justificativa', $justificativa);
        if (oci_execute($stmt)) {
            $response["sucesso"] = 1;
            $response["mensagem"] = "A Cotação foi 'REPROVADA'.";
        } else {
            $response["mensagem"] = "Erro para 'REPROVAR'.";
        }
    } else {
        $response["mensagem"] = "ID da cotação não fornecido.";
    }

    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
