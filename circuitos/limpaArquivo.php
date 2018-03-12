<?php
include_once '../class/principal.php';

$circuitos = new Circuitos();
$tipo = $_GET ['tipo'];
if ($tipo == '1'){
    $arquivo = $_GET ['arquivo'];
    $circuitos->excluiImport($arquivo);
}elseif ($tipo == '2') {
    $contrato = $_GET ['contrato'];
    $conta = $_GET ['conta'];
    $circuitos->excluiDadosContas($contrato, $conta);
}
header("Location: confirmaimport.php");

