<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('','6') == 1) {

    $servicos = new Servico();
    $repeticao = filter_input(INPUT_POST,'repeticao');
    $descricao = filter_input(INPUT_POST,'descricao');
    $nome_redu = filter_input(INPUT_POST,'nome_redu');
    $codigo = filter_input(INPUT_POST,'servico');
    $data_prox_exec = filter_input(INPUT_POST,'data_prox');
    $servicos->manutServico($codigo, $nome_redu, $descricao, $repeticao, $data_prox_exec );

    echo '<META http-equiv="refresh" content="0;../servicos/servicos.php">';


    include ("../class/footer.php");
}