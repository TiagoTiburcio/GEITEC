<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4') == 1) {
    $filtro_tarefa = filter_input(INPUT_GET, 'tarefa');
    $filtro_situacao = filter_input(INPUT_GET, 'situacao');
    $filtro_evento = filter_input(INPUT_GET, 'evento');
    $redmine = new Redmine();    
    $retorno = $redmine->fechaTarefa($filtro_tarefa, $filtro_situacao);
    header("Location: edittarefa.php?evento=$filtro_evento");
}//fim valida sessão