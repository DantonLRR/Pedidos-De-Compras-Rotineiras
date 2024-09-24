<?php
$cotacaoId = $_POST['id'];
include "../../base/conexao_martdb.php";
include "../config/php/crud_gerenciamento.php";

$InformacoesCotacoes = new InformacoesCotacoes();
$buscandoAcompanhamento = $InformacoesCotacoes->maisInformacoesCotacaoPorID($oracle, $cotacaoId);

// Retorna o resultado da consulta em formato JSON
header('Content-Type: application/json');
echo json_encode($buscandoAcompanhamento);
?>
