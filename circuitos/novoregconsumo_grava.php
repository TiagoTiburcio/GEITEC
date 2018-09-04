<?php

include_once '../class/principal.php';

$usuario = new Usuario();

$circuitos = new Circuitos();


$designacao = filter_input(INPUT_POST, 'designacao');
$localizacao = filter_input(INPUT_POST, 'localizacao');
$unidade = filter_input(INPUT_POST, 'combobox');

echo $designacao . ' adsa ' . $localizacao . ' asddsa ' . $unidade;

$circuitos->addRegistroConsumo($designacao, $localizacao, $unidade);
header("Location: confirmaimport.php");
