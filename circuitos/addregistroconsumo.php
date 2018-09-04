<?php

include_once '../class/principal.php';

$circuitos = new Circuitos();
$arquivo = filter_input(INPUT_GET, 'arquivo');
if ($circuitos->testeImport($arquivo) == '1') {
    $circuitos->insertContasImport($arquivo);
    $circuitos->editRegistroConsumo($arquivo);
    $circuitos->excluiImport($arquivo);
}
header("Location: confirmaimport.php");
