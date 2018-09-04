<?php

include_once '../class/principal.php';

$circuitos = new Circuitos();
$tipo = filter_input(INPUT_GET,'tipo');
if ($tipo == '1') {
    $arquivo = filter_input(INPUT_GET,'arquivo');
    $circuitos->excluiImport($arquivo);
} elseif ($tipo == '2') {
    $contrato = filter_input(INPUT_GET,'contrato');
    $conta = filter_input(INPUT_GET,'conta');
    $circuitos->excluiDadosContas($contrato, $conta);
}
header("Location: confirmaimport.php");

