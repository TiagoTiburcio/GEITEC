<?php

include_once '../class/principal.php';

$circuitos = new Circuitos();

$arquivo = filter_input(INPUT_POST, 'arquivo');
$num_linha = filter_input(INPUT_POST, 'num_linha');
$designacao = filter_input(INPUT_POST, 'designacao');
$circuitos->editLinhaArquivo($arquivo, $num_linha, $designacao);
header("Location: confirmaimport.php");
