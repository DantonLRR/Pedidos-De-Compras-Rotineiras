<?php
session_start();
include "../../base/Conexao_martdb.php";
include "php/crud_controle_de_permissao.php";

$dados = new dados();
$nivel = $_POST['SEQOPCAO'];
$loja = $_POST['loja'];
$status = $_POST['Status'];
$dadosDESCRICAODisponivel = $_POST['dadosDESCRICAODisponivel'];
?>
<div>
    <div class="row">
        <div class="col-6">
        <input class="loja" type="HIDDEN" value="<?= $loja?>">
            <input style="display: none;" class="seqmodulosel" id="NivelPermissao" value="<?= $nivel ?>">
            <input style="display: none;" class="" id="dadosDESCRICAODisponivel" value="<?= $dadosDESCRICAODisponivel ?>">
            <input style="display: none;" class="" id="status" value="<?= $status ?>">
            <table class="table table-bordered table-striped text-center  table_man_dados " id="table2" style="width:100%">
                <div>
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="text-center"> <input type="checkbox" class="atrrcheck" name="checkbox" id="atrrcheck" value=""></th>
                            <th class="text-center">seleção</th>
                            <th style="display:none" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $buscandoCargosDisponiveis = $dados->buscandoUsuarios($oracle,$loja);
                        foreach ($buscandoCargosDisponiveis as $row) :
                        ?>
                            <tr class="trteste tr">
                                <td class="text-center">
                                    <input type="checkbox" class="checkbox" name="checkbox" id="checkbox" value="">
                                </td>
                                <td class="CODUSUARIO td2"><?= $row['CODUSUARIO'] ?> </td>
                                <td style="display:none" class="SEQSELEC td2"><?= $row['SEQUSUARIO'] ?> </td>
                            </tr>
                        <?php
                        endforeach
                        ?>
                    </tbody>
                </div>
            </table>

        </div>
        <div class="col-6">
            <table class="table table-bordered table-striped text-center tablepermissao" style="width:100%">
                <div>
                    <thead>
                        <tr class="bg-success text-white">
                            <th class="text-center"> <input type="checkbox" class="atrrcheck1" name="checkbox" id="atrrcheck1" value=""></th>
                            <th style="display:none"></th>
                            <th class="text-center">Responsável(is) por: <?= $dadosDESCRICAODisponivel ?>  do setor:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $buscandoCargosDisponiveis = $dados->buscandoUsuariosPermitidos($oracle, $nivel);
                        foreach ($buscandoCargosDisponiveis as $buscandoCargosDisponiveis) :
                        ?>
                            <tr class="trppermitido">
                                <td class="text-center">
                                    <input type="checkbox" class="checkbox1" name="checkbox" id="checkbox1" value="">
                                </td>
                                <td class="CodUsuarioPermitido"><?= $buscandoCargosDisponiveis['USUARIO'] ?> </td>
                                <td style="display: none;" class="SEQCODUSUARIO"><?= $buscandoCargosDisponiveis['SEQUSUARIO'] ?> </td>
                            </tr>
                        <?php
                        endforeach
                        ?>
                    </tbody>
                </div>
            </table>
        </div>
    </div>
</div>
<script type="module" defer>
            var loja = $('.loja').val();
    import {
        criandoHtmlmensagemCarregamento,
        Toasty
    } from "../../base/jsGeral.js";
    var Status = $('#status').val();
      // Função para marcar/desmarcar todas as checkboxes ao clicar no checkbox principal
      $('.atrrcheck').on('click', function() {
        var todasCheckboxes = $('.checkbox');
        // Verifica se a checkbox principal está marcada ou não
        if ($(this).is(':checked')) {
            todasCheckboxes.prop('checked', true); // Marca todas
        } else {
            todasCheckboxes.prop('checked', false); // Desmarca todas
        }
    });

    // Função para marcar/desmarcar todas as checkboxes da segunda tabela
    $('.atrrcheck1').on('click', function() {
        var todasCheckboxes1 = $('.checkbox1');
        if ($(this).is(':checked')) {
            todasCheckboxes1.prop('checked', true); // Marca todas
        } else {
            todasCheckboxes1.prop('checked', false); // Desmarca todas
        }
    });


    $('.table_man_dados').DataTable({
        dom: 'Bfrtip',
        "paging": true,
        "info": false,
        "searching": true,
        "ordering": false,
        scrollY: "280px",
        "lengthMenu": [
            [50],
            [50]
        ],
        buttons: [
            {
                text: 'Permitir',
                action: function(f) {

                    var checkede = $('.checkbox').toArray().map(function(checkede) {
                        return $(checkede).is(':checked');
                    });

                    for (var i = 0, l = checkede.length; i < l; i++) {

                        if (checkede[i] == true) {

                            var checkedvazio = 'true'
                        }
                    }

                    if (checkedvazio == 'true') {

                        var dados = $('.checkbox:checked').parent().parent().find(".SEQSELEC").closest('.SEQSELEC').toArray().map(function(dados) {
                            return $(dados).text();
                        });
                        var dadosCODUSUARIO = $('.checkbox:checked').parent().parent().find(".CODUSUARIO").closest('.CODUSUARIO').toArray().map(function(dadosCODUSUARIO) {
                            return $(dadosCODUSUARIO).text();
                        });
                        var NivelPermissao = $('#NivelPermissao').val();
                        var dadosDESCRICAODisponivel = $('#dadosDESCRICAODisponivel').val();
                        criandoHtmlmensagemCarregamento("exibir");

                        $.ajax({
                            url: "Config/Adiciona_e_remove_permissao.php",
                            method: 'get',
                            data: 'dados=' + dados + '&seqmodulosel=' + NivelPermissao + '&dadosCODUSUARIO=' + dadosCODUSUARIO + '&Status=' + Status+ '&dadosDESCRICAODisponivel=' + dadosDESCRICAODisponivel,

                            success: function(filtro) {
                                $.ajax({
                                    url: "Config/GerenciamentoPermissao.php",
                                    method: 'POST',
                                    data: 'dadosDESCRICAODisponivel=' + dadosDESCRICAODisponivel + '&SEQOPCAO=' + NivelPermissao+ '&Status=' + Status+'&loja=' + loja,
                                    success: function(filtro) {
                                        $('.tablereq').empty().html(filtro);
                                        criandoHtmlmensagemCarregamento("ocultar");
                                    }
                                });
                            }
                        });
                    } else {
                        Toasty("Atenção", "Selecione um usuário!.", "#E20914");
                    }
                }
            },
            // 'colvis'
        ],


        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
        }
    });


    $('.tablepermissao').DataTable({
        dom: 'Bfrtip',
        "paging": true,
        "info": false,
        "searching": true,
        "ordering": false,
        scrollY: "280px",
        "lengthMenu": [
            [50],
            [50]
        ],
        buttons: [
            {
                // Permitir no modulo
                text: 'Remover',
                action: function(e) {

                    var checkede = $('.checkbox1').toArray().map(function(checkede) {
                        return $(checkede).is(':checked');
                    });

                    for (var i = 0, l = checkede.length; i < l; i++) {

                        if (checkede[i] == true) {

                            var checkedvazio = 'true'
                        }
                    }
                    if (checkedvazio == 'true') {

                        var dados = $('.checkbox1:checked').parent().parent().find(".SEQCODUSUARIO").closest('.SEQCODUSUARIO').toArray().map(function(dados) {
                            return $(dados).text();
                        });
                        var dadosCODUSUARIO = $('.checkbox1:checked').parent().parent().find(".CodUsuarioPermitido").closest('.CodUsuarioPermitido').toArray().map(function(dados) {
                            return $(dados).text();
                        });
                        var NivelPermissao = $('#NivelPermissao').val();
                        var dadosDESCRICAODisponivel = $('#dadosDESCRICAODisponivel').val();
                        Status = 'C';
                        //  alert(seqmodulosel)
                        criandoHtmlmensagemCarregamento("exibir");
                        $.ajax({
                            url: "Config/Adiciona_e_remove_permissao.php",
                            method: 'get',
                            data: 'dados=' + dados + '&seqmodulosel=' + NivelPermissao + '&dadosCODUSUARIO=' + dadosCODUSUARIO + '&Status=' + Status+ '&dadosDESCRICAODisponivel=' + dadosDESCRICAODisponivel,
                            success: function(filtro) {
                                $.ajax({
                                    url: "Config/GerenciamentoPermissao.php",
                                    method: 'POST',
                                    data: 'dadosDESCRICAODisponivel=' + dadosDESCRICAODisponivel + '&SEQOPCAO=' + NivelPermissao+ '&Status=' + Status+'&loja=' + loja,
                                    success: function(filtro) {
                                        $('.tablereq').empty().html(filtro);
                                        criandoHtmlmensagemCarregamento("ocultar");
                                    }
                                });
                            }
                        });

                    } else {
                        Toasty("Atenção", "Selecione um usuário!.", "#E20914");
                    }
                }
            },
        ],
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
        }
    });
</script>