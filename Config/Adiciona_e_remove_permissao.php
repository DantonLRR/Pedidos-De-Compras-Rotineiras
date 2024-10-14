<?php
session_start();
include "../../base/Conexao_martdb.php";
if (!isset($_SESSION['nome'], $_GET['dados'], $_GET['dadosCODUSUARIO'], $_GET['seqmodulosel'], $_GET['dadosDESCRICAODisponivel'], $_GET['Status'])) {
    exit("Parâmetros insuficientes.");
}
$usuario = $_SESSION['nome'];
$dados = $_GET['dados'];
$dadosCODUSUARIO = $_GET['dadosCODUSUARIO'];
$dados_array = explode(",", $dados);
$dadosCODUSUARIO_array = explode(",", $dadosCODUSUARIO);
$seqaplicacao = $_GET['seqmodulosel'];
$dadosDESCRICAODisponivel = $_GET['dadosDESCRICAODisponivel'];
$Status = $_GET['Status'];
$seqAplicacaoParaLiberarAplicacao = [464, 465];

// Função para buscar o próximo valor da sequência
function getNextVal($oracle, $sequence)
{
    $sql = "SELECT $sequence.Nextval as NEXTVAL FROM dual";
    $parse = oci_parse($oracle, $sql);
    oci_execute($parse);
    return oci_fetch_assoc($parse)['NEXTVAL'];
}

// Função para executar SQL com tratamento de erros
function executeQuery($oracle, $sql)
{
    $parse = oci_parse($oracle, $sql);
    return oci_execute($parse) ? 1 : 0;
}

// Função para inserir permissões e logs
function processarPermissao($oracle, $usuario, $dados_array, $dadosCODUSUARIO_array, $seqaplicacao, $dadosDESCRICAODisponivel, $seqmodulo, $seqAplicacao, $acao)
{
    foreach ($dados_array as $index => $dados) {
        // Inserção em weboficial.WEB_PERMISSAOPEDIDODECOMPRAS
        $SEQPERMISSAO = getNextVal($oracle, 'weboficial.S_PERMISSAOESCALA');
        $sql = "INSERT INTO weboficial.WEB_PERMISSAOPEDIDODECOMPRAS 
                (ID, NIVEL, USUARIOINCLUSAO, USUARIO, SEQUSUARIO)
                VALUES (
                $SEQPERMISSAO,
                $seqaplicacao,
                '$usuario',
                '{$dadosCODUSUARIO_array[$index]}',
                '{$dados_array[$index]}')";
        echo executeQuery($oracle, $sql);

        // Verificação para não inserir módulo se a pessoa já estiver nele
        $sqlverificaModulo = "SELECT COUNT(*) AS TOTAL FROM consinco.Permissaoweb
            WHERE seqmodulo = 112
            AND permissao = '{$dados_array[$index]}'
            ";
        $parseModulo = oci_parse($oracle, $sqlverificaModulo);
        oci_execute($parseModulo);
        $row = oci_fetch_assoc($parseModulo);

        if ($row['TOTAL'] == 0) {
            // Inserção em consinco.PERMISSAOWEB (módulo 112)
            $SEQPERMISSAOmodulo = getNextVal($oracle, 'consinco.S_permissaoweb');
            $sql = "INSERT INTO consinco.PERMISSAOWEB
                (seqpermicao, seqmodulo, USUINCLUSAO, DTAINCLUSAO, permissao)
                VALUES
                ($SEQPERMISSAOmodulo, 112, '$usuario', sysdate, '{$dados_array[$index]}')";
            echo executeQuery($oracle, $sql);
        }
        // Inserção em consinco.PERMISSAOWEB (aplicação 464 ou 465)
        $SEQPERMISSAOmodulo = getNextVal($oracle, 'consinco.S_permissaoweb');
        $sql = "INSERT INTO consinco.PERMISSAOWEB
                (seqpermicao, seqaplicacao, USUINCLUSAO, DTAINCLUSAO, permissao)
                VALUES
                ($SEQPERMISSAOmodulo, $seqAplicacao, '$usuario', sysdate, '{$dados_array[$index]}')";
        echo executeQuery($oracle, $sql);

        // Inserir log de permissões
        $sql = "INSERT INTO weboficial.LOG_PERMISSAO_PEDIDODECOMPRAS
            (ID, NIVEL, USUARIOINCLUSAO, USUARIO, SEQUSUARIO, DTAHORA_PERMISSAO, DEPARTAMENTOPERMITIDO, DESCRICAO)
            VALUES (
            $SEQPERMISSAO,
            $seqaplicacao,
            '$usuario',
            '{$dadosCODUSUARIO_array[$index]}',
            '{$dados_array[$index]}',
            sysdate,
            '$dadosDESCRICAODisponivel',
            '$acao que {$dadosCODUSUARIO_array[$index]} tenha acesso ao: $dadosDESCRICAODisponivel')";
        echo executeQuery($oracle, $sql);
    }
}

// Função para deletar permissões e logs
function deletarPermissao($oracle, $dados_array, $seqAplicacaoParaLiberarAplicacao, $dadosCODUSUARIO_array, $seqaplicacao, $usuario, $dadosDESCRICAODisponivel)
{
    foreach ($dados_array as $index => $dados) {
        // Deletar permissão de weboficial.WEB_PERMISSAOPEDIDODECOMPRAS do usuário
        $query1 = "DELETE FROM weboficial.WEB_PERMISSAOPEDIDODECOMPRAS WHERE TRIM(SEQUSUARIO) = TRIM('$dados')";
        echo executeQuery($oracle, $query1);

        // Verificação para ver se a permissão já está na aplicação
        $sqlverificaModulo = "SELECT COUNT(*) AS TOTAL FROM consinco.Permissaoweb
            WHERE seqaplicacao = 112
            AND permissao = '{$dados_array[$index]}'";
        $parseModulo = oci_parse($oracle, $sqlverificaModulo);
        oci_execute($parseModulo);
        $row = oci_fetch_assoc($parseModulo);

        if ($row['TOTAL'] == 0) {
            // Deletar permissão do módulo 112
            $sql = "DELETE FROM consinco.PERMISSAOWEB WHERE seqmodulo = 112 AND permissao = '$dados'";
            echo executeQuery($oracle, $sql);
        }
        // Deletar permissões de aplicações
        foreach ($seqAplicacaoParaLiberarAplicacao as $seqAplicacao) {
            $sqlDeleteAplicacao = "DELETE FROM consinco.PERMISSAOWEB WHERE seqaplicacao = $seqAplicacao AND permissao = '$dados'";
            echo executeQuery($oracle, $sqlDeleteAplicacao);
        }

        // Inserir log de exclusão
        $SEQPERMISSAO = getNextVal($oracle, 'weboficial.S_PERMISSAOESCALA');
        $sql = "INSERT INTO weboficial.LOG_PERMISSAO_PEDIDODECOMPRAS
                    (ID, NIVEL, USUARIOINCLUSAO, USUARIO, SEQUSUARIO, DTAHORA_PERMISSAO, DEPARTAMENTOPERMITIDO, DESCRICAO)
                    VALUES (
                    $SEQPERMISSAO,
                    $seqaplicacao,
                    '$usuario',
                    '{$dadosCODUSUARIO_array[$index]}',
                    '$dados',
                    sysdate,
                    '$dadosDESCRICAODisponivel',
                    'Retirado a permissão de {$dadosCODUSUARIO_array[$index]} para fazer  $dadosDESCRICAODisponivel')";
        echo executeQuery($oracle, $sql);
    }
}

if ($Status == 'F') {
    processarPermissao($oracle, $usuario, $dados_array, $dadosCODUSUARIO_array, $seqaplicacao, $dadosDESCRICAODisponivel, 112, 464, 'Permitido');
} else if ($Status == 'A') {
    processarPermissao($oracle, $usuario, $dados_array, $dadosCODUSUARIO_array, $seqaplicacao, $dadosDESCRICAODisponivel, 112, 465, 'Permitido');
} else {
    deletarPermissao($oracle, $dados_array, $seqAplicacaoParaLiberarAplicacao, $dadosCODUSUARIO_array, $seqaplicacao, $usuario, $dadosDESCRICAODisponivel);
}
