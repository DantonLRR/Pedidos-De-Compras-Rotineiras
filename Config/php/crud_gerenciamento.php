<?php
class FiltrosAcompanhamento
{
    public function buscandoCotacoesPesquisa($oracle, $dataInicio = '', $datafim = '', $statusPesquisa, $dadosDeQuemEstaLogadoCENTROCUSTO, $Departamento = false)
    {
        $filtroPesquisa = '';
        if ($dadosDeQuemEstaLogadoCENTROCUSTO != 'SUPRIMENTOS') {
            $filtroPesquisa = "AND a.departamento like( '" . $dadosDeQuemEstaLogadoCENTROCUSTO . "') ";
        }

        if ($dadosDeQuemEstaLogadoCENTROCUSTO == 'SUPRIMENTOS' && $Departamento) {
            $filtroPesquisa = "AND a.departamento like( '" . $Departamento . "') ";
        }
        $lista = array();
        // Use parâmetros para evitar SQL Injection
        $query = "SELECT a.id,
                    a.solicitante,
                    a.departamento,
                    TO_CHAR(a.data_solicitacao, 'DD/MM/YYYY') AS data_solicitacao,
                    a.numero_chamado,
                    a.loja,
                    a.cidade,
                    a.prazo_necessario,
                    a.item,
                    a.tamanho,
                    a.cor,
                    a.modelo,
                    a.espessura,
                    a.codigo_fornecedor,
                    a.tipo_material,
                    a.marca,
                    a.quantidade,
                    a.original_ou_generico,
                    a.unidade,
                    a.medida,
                    a.gas,
                    a.tensao,
                    a.potencia,
                    a.corrente,
                    a.rosca_solda,
                    a.descricao,
                    a.classificacao_necessidade,
                    a.faturamento,
                    a.cnpj,
                    a.endereco,
                    a.local_entrega,
                    a.nome_fornecedor,
                    a.tel_fornecedor,
                    a.email_fornecedor,
                    a.data_inclusao,
                    a.usuario_inclusao,
                    a.status,
                    a.SEQ_COTACAO
                    FROM weboficial.WEB_ComprasRotineiras a
                    WHERE a.status = :statusPesquisa
                    AND TO_CHAR(a.data_solicitacao,'YYYY-MM-DD' ) BETWEEN :dataInicio AND :datafim
                     $filtroPesquisa
                    ORDER BY a.id DESC
                    ";
        // Preparar a query
        $resultado = oci_parse($oracle, $query);
        // Vincular os parâmetros
        oci_bind_by_name($resultado, ':statusPesquisa', $statusPesquisa);
        oci_bind_by_name($resultado, ':dataInicio', $dataInicio);
        oci_bind_by_name($resultado, ':datafim', $datafim);
        // Exibir a consulta para depuração
        // echo "Consulta: $query\n";
        // echo   $filtroPesquisa;
        // echo "Parâmetros: status='$statusPesquisa', dataInicio='$dataInicio', datafim='$datafim'\n";
        // Executar a query
        if (!oci_execute($resultado)) {
            $error = oci_error($resultado);
            echo "Erro na execução da consulta: " . $error['message'] . "\n";
        }

        while ($row = oci_fetch_assoc($resultado)) {
            array_push($lista, $row);
        }

        return $lista;
    }
}
class InformacoesCotacoes
{
    public function maisInformacoesCotacaoPorID($oracle, $id)
    {
        $lista = array();

        // Consulta principal
        $query = "SELECT a.id,
                         a.solicitante,
                         a.departamento,
                        TO_CHAR(a.data_solicitacao, 'DD/MM/YYYY') AS data_solicitacao,
                         a.numero_chamado,
                         a.loja,
                         a.cidade,
                         a.prazo_necessario,
                         a.item,
                         a.tamanho,
                         a.cor,
                         a.modelo,
                         a.espessura,
                         a.codigo_fornecedor,
                         a.tipo_material,
                         a.marca,
                         a.quantidade,
                         a.original_ou_generico,
                         a.unidade,
                         a.medida,
                         a.gas,
                         a.tensao,
                         a.potencia,
                         a.corrente,
                         a.rosca_solda,
                         a.descricao,
                         a.classificacao_necessidade,
                         a.faturamento,
                         a.cnpj,
                         a.endereco,
                         a.local_entrega,
                         a.nome_fornecedor,
                         a.tel_fornecedor,
                         a.email_fornecedor,
                         a.data_inclusao,
                         a.usuario_inclusao,
                         a.status,
                         SEQ_COTACAO
                  FROM weboficial.WEB_ComprasRotineiras a
                  WHERE a.id = :id";

        $resultado = oci_parse($oracle, $query);
        oci_bind_by_name($resultado, ':id', $id);
        oci_execute($resultado);

        while ($row = oci_fetch_assoc($resultado)) {
            array_push($lista, $row);
        }

        // Buscar imagens associadas
        $queryImagens = "SELECT imagem_caminho 
        FROM weboficial.IMAGENS_SOLICITACAOCOMPRAS 
        WHERE solicitacao_id = :solicitacao_id";
        $stmtImagens = oci_parse($oracle, $queryImagens);
        oci_bind_by_name($stmtImagens, ':solicitacao_id', $id);
        oci_execute($stmtImagens);

        $imagens = array();
        while ($row = oci_fetch_assoc($stmtImagens)) {
            $imagens[] = $row['IMAGEM_CAMINHO'];
        }

        // Adiciona as imagens ao array de resposta
        if (!empty($lista)) {
            $lista[0]['imagens'] = $imagens;
        }





        // Buscar arquivos associadas
        $queryMAPAdeCOTACOES = "SELECT mapadecotacao_caminho 
                        FROM weboficial.WEB_ComprasRotineiras
                        WHERE id = :solicitacao_id";
        $stmtMAPAdeCOTACOES = oci_parse($oracle, $queryMAPAdeCOTACOES);
        oci_bind_by_name($stmtMAPAdeCOTACOES, ':solicitacao_id', $id);
        oci_execute($stmtMAPAdeCOTACOES);

        $MapaDeCotacoes = array();
        while ($row = oci_fetch_assoc($stmtMAPAdeCOTACOES)) {
            $MapaDeCotacoes[] = $row['MAPADECOTACAO_CAMINHO'];
        }

        // Adiciona as imagens ao array de resposta
        if (!empty($lista)) {
            $lista[0]['MAPADECOTACAO'] = $MapaDeCotacoes;
        }

        return $lista;
    }
    public function buscaDepartamentos($oracle)
    {
        $lista = array();
        $query = "SELECT DISTINCT a.DEPARTAMENTO FROM weboficial.WEB_ComprasRotineiras a";

        $resultado = oci_parse($oracle, $query);

        if (!oci_execute($resultado)) {
            $error = oci_error($resultado);
            echo "Erro na execução da consulta: " . $error['message'];
            return $lista;
        }

        // Verifique se o resultado possui dados
        if (oci_fetch_all($resultado, $lista, null, null, OCI_FETCHSTATEMENT_BY_ROW) === 0) {
            echo "Nenhum dado retornado pela consulta.";
            return [];
        }

        return $lista;
    }
}
class Verifica
{
    public function informacaoPessoaLogada($TotvsOracle, $cpf, $lojaDaPessoaLogada)
    {
        $lista = array();
        $query = "SELECT DISTINCT PFUNC.CHAPA,
                PFUNC.NOME AS NOME,
                SUBSTR(PFUNCAO.NOME, 0, 11) AS NOME2,
                PFUNCAO.NOME AS CARGO,
                PCCUSTO.NOME AS DESCRICAO,
                PCCUSTO.NOME AS CENTROCUSTO,
                PCCUSTO.CODCCUSTO,
                PSECAO.CODIGO AS NROEMPRESA,
                PPESSOA.CPF,
                PFUNC.CODSITUACAO AS CODSITUACAO,
                PFUNC.DATAADMISSAO AS DATA_ADMISSAO,
                SUBSTR(PSECAO.DESCRICAO, 1, 3) AS LOJA,
                SUBSTR(PSECAO.DESCRICAO, 6) AS SETOR1,
                TRIM(SUBSTR(PSECAO.DESCRICAO, 6)) AS SETORSEMESPACO,
                TO_CHAR(PFUNC.DATAADMISSAO, 'YYYY-MM-DD') AS DATA_ADMISSAO_CONVERTIDA,
                PSECAO.DESCRICAO AS SETOR,
                PFUNCAO.CODIGO AS CODFUNCAO,
                TRUNC(MONTHS_BETWEEN(SYSDATE, PFUNC.DATAADMISSAO) / 12) AS ANOS_TEMPO_CASA,
                TRUNC(MONTHS_BETWEEN(SYSDATE, PFUNC.DATAADMISSAO)) - CASE
                  WHEN TO_NUMBER(TO_CHAR(SYSDATE, 'DD')) <
                       TO_NUMBER(TO_CHAR(PFUNC.DATAADMISSAO, 'DD')) THEN
                   1
                  ELSE
                   0
                END - 12 *
                TRUNC(MONTHS_BETWEEN(SYSDATE, PFUNC.DATAADMISSAO) / 12) AS MESES_TEMPO_CASA,
                ABS(EXTRACT(DAY FROM PFUNC.DATAADMISSAO) -
                    EXTRACT(DAY FROM SYSDATE)) AS DIAS_TEMPO_CASA,
                TRUNC(MONTHS_BETWEEN(SYSDATE, FUNCAO.DATAMUDANCA) / 12) AS ANOS_TEMPO_FUNCAO,
                TRUNC(MONTHS_BETWEEN(SYSDATE, FUNCAO.DATAMUDANCA)) - CASE
                  WHEN TO_NUMBER(TO_CHAR(SYSDATE, 'DD')) <
                       TO_NUMBER(TO_CHAR(FUNCAO.DATAMUDANCA, 'DD')) THEN
                   1
                  ELSE
                   0
                END - 12 *
                TRUNC(MONTHS_BETWEEN(SYSDATE, FUNCAO.DATAMUDANCA) / 12) AS MESES_TEMPO_FUNCAO,
                ABS(EXTRACT(DAY FROM FUNCAO.DATAMUDANCA) -
                    EXTRACT(DAY FROM SYSDATE)) AS DIAS_TEMPO_FUNCAO

                FROM PFUNC

                INNER JOIN PPESSOA
                    ON PFUNC.CODPESSOA = PPESSOA.CODIGO

                INNER JOIN PFRATEIOFIXO
                    ON PFUNC.CODCOLIGADA = PFRATEIOFIXO.CODCOLIGADA
                AND PFUNC.CHAPA = PFRATEIOFIXO.CHAPA

                INNER JOIN PCCUSTO
                    ON PFRATEIOFIXO.CODCOLIGADA = PCCUSTO.CODCOLIGADA
                AND PFRATEIOFIXO.CODCCUSTO = PCCUSTO.CODCCUSTO

                INNER JOIN PFUNCAO
                    ON PFUNC.CODCOLIGADA = PFUNCAO.CODCOLIGADA
                AND PFUNC.CODFUNCAO = PFUNCAO.CODIGO

                INNER JOIN PSECAO
                    ON PFUNC.CODCOLIGADA = PSECAO.CODCOLIGADA
                AND PFUNC.CODSECAO = PSECAO.CODIGO

                LEFT JOIN (SELECT PFHSTFCO.CODCOLIGADA,
                                    PFHSTFCO.CHAPA,
                                    MAX(PFHSTFCO.DTMUDANCA) AS DATAMUDANCA
                            FROM PFHSTFCO
                            WHERE PFHSTFCO.CODCOLIGADA = 1
                            GROUP BY PFHSTFCO.CODCOLIGADA, PFHSTFCO.CHAPA) FUNCAO
                    ON PFUNC.CODCOLIGADA = FUNCAO.CODCOLIGADA
                AND PFUNC.CHAPA = FUNCAO.CHAPA

                WHERE PFUNC.CODCOLIGADA = 1
                AND PPESSOA.CPF LIKE '$cpf'
                AND PFUNC.CODSITUACAO <> 'D'

                UNION ALL

                SELECT DISTINCT PEXTERNO.CODEXTERNO,
                                PPESSOA.NOME AS NOME,
                                SUBSTR(PFUNCAO.NOME, 0, 11) AS NOME2,
                                PFUNCAO.NOME AS CARGO,
                                GCONSIST.DESCRICAO AS CENTROCUSTO,
                                GCONSIST.DESCRICAO AS DESCRICAO,
                                VPCOMPL.CCUSTO,
                                PSECAO.CODIGO AS NROEMPRESA,
                                PPESSOA.CPF,
                                PEXTERNO.CODSITUACAO AS CODSITUACAO,
                                PEXTERNO.DATAINICIO AS DATA_ADMISSAO,
                                SUBSTR(PSECAO.DESCRICAO, 1, 3) AS LOJA,
                                SUBSTR(PSECAO.DESCRICAO, 6) AS SETOR1,
                                TRIM(SUBSTR(PSECAO.DESCRICAO, 6)) AS SETORSEMESPACO,
                                TO_CHAR(PEXTERNO.DATAINICIO, 'YYYY-MM-DD') AS DATA_ADMISSAO_CONVERTIDA,
                                PSECAO.DESCRICAO AS SETOR,
                                PFUNCAO.CODIGO AS CODFUNCAO,
                                TRUNC(MONTHS_BETWEEN(SYSDATE, PEXTERNO.DATAINICIO) / 12) AS ANOS_TEMPO_CASA,
                                TRUNC(MONTHS_BETWEEN(SYSDATE, PEXTERNO.DATAINICIO)) - CASE
                                WHEN TO_NUMBER(TO_CHAR(SYSDATE, 'DD')) <
                                    TO_NUMBER(TO_CHAR(PEXTERNO.DATAINICIO, 'DD')) THEN
                                1
                                ELSE
                                0
                                END - 12 *
                                TRUNC(MONTHS_BETWEEN(SYSDATE, PEXTERNO.DATAINICIO) / 12) AS MESES_TEMPO_CASA,
                                ABS(EXTRACT(DAY FROM PEXTERNO.DATAINICIO) -
                                    EXTRACT(DAY FROM SYSDATE)) AS DIAS_TEMPO_CASA,
                                TRUNC(MONTHS_BETWEEN(SYSDATE, PEXTERNO.DATAINICIO) / 12) AS ANOS_TEMPO_FUNCAO,
                                TRUNC(MONTHS_BETWEEN(SYSDATE, PEXTERNO.DATAINICIO)) - CASE
                                WHEN TO_NUMBER(TO_CHAR(SYSDATE, 'DD')) <
                                    TO_NUMBER(TO_CHAR(PEXTERNO.DATAINICIO, 'DD')) THEN
                                1
                                ELSE
                                0
                                END - 12 *
                                TRUNC(MONTHS_BETWEEN(SYSDATE, PEXTERNO.DATAINICIO) / 12) AS MESES_TEMPO_FUNCAO,
                                ABS(EXTRACT(DAY FROM PEXTERNO.DATAINICIO) -
                                    EXTRACT(DAY FROM SYSDATE)) AS DIAS_TEMPO_FUNCAO

                FROM PEXTERNO

                INNER JOIN PPESSOA
                    ON PEXTERNO.CODPESSOA = PPESSOA.CODIGO

                INNER JOIN VPCOMPL
                    ON (PPESSOA.CODIGO = VPCOMPL.CODPESSOA)

                INNER JOIN GCONSIST
                    ON (VPCOMPL.CCUSTO = GCONSIST.CODCLIENTE)

                INNER JOIN PFUNCAO
                    ON PEXTERNO.CODCOLIGADA = PFUNCAO.CODCOLIGADA
                AND PEXTERNO.CODFUNCAO = PFUNCAO.CODIGO

                INNER JOIN PSECAO
                    ON PEXTERNO.CODCOLIGADA = PSECAO.CODCOLIGADA
                AND PEXTERNO.CODSECAO = PSECAO.CODIGO

                WHERE PEXTERNO.CODCOLIGADA = 1
                AND PPESSOA.CPF LIKE '$cpf'
            ";
        $resultado = oci_parse($TotvsOracle, $query);
        oci_execute($resultado);
        while ($row = oci_fetch_assoc($resultado)) {
            array_push($lista, $row);
        }
        return $lista;
        $dadosDeQuemEstaLogadoNome =  $rowVerificaEncarregado['NOME'];
        $dadosDeQuemEstaLogadoCENTROCUSTO = $rowVerificaEncarregado['SETORSEMESPACO'];
        $dadosDeQuemEstaLogadoCARGO = $rowVerificaEncarregado['CARGO'];
        //  echo $query;
    }
}
class PessoaLogada
{
    private $nome;
    private $centroCusto;
    private $cargo;

    public function __construct($TotvsOracle, $cpf, $loja)
    {
        $this->recuperarInformacoes($TotvsOracle, $cpf, $loja);
    }

    private function recuperarInformacoes($TotvsOracle, $cpf, $loja)
    {
        $verifica = new verifica();
        $verificaPessoaLogada = $verifica->informacaoPessoaLogada($TotvsOracle, $cpf, $loja);

        foreach ($verificaPessoaLogada as $rowVerificaEncarregado) {
            $this->nome = $rowVerificaEncarregado['NOME'];
            $this->centroCusto = $rowVerificaEncarregado['SETORSEMESPACO'];
            $this->cargo = $rowVerificaEncarregado['CARGO'];
        }
    }

    // Getters para acessar as informações
    public function getNome()
    {
        return $this->nome;
    }

    public function getCentroCusto()
    {
        return $this->centroCusto;
    }

    public function getCargo()
    {
        return $this->cargo;
    }
}
class funcoesEmPHP
{
    public function definirCorStatus($status)
    {
        switch ($status) {
            case 'NOVO':
            case 'NORMAL':
                return '#007bff';
            case 'COTADO':
            case 'EM COTAÇÃO':
                return '#28a745';
            case 'REPROVADO':
            case 'URGENTE':
                return '#dc3545';
            case 'BAIXA':
                return '#6c757d';
            default:
                return '#6c757d';
        }
    }
}
