<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {

    $servicos = new Servico();
    $repeticao = $_POST ["repeticao"];
    $descricao = $_POST ["descricao"];
    $nome_redu = $_POST ["nome_redu"];
    $codigo = $_POST ["servico"];

    $servicos->manutServico($codigo, $nome_redu, $descricao, $repeticao);

    echo '<META http-equiv="refresh" content="0;../servicos/servicos.php">';


    include ("../class/footer.php");
}