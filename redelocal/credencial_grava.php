<?php

include_once '../class/principal.php';
$rotina = new RotinasPublicas();

if ($rotina->validaSessao('2','17') == 1) {
    $redeLocal = new RedeLocal();
    $tipo = filter_input(INPUT_POST,'tipo');
    $descricao = filter_input(INPUT_POST,'descricao');
    $user = filter_input(INPUT_POST,'usuario');
    $senha = filter_input(INPUT_POST,'senha');
    $local = filter_input(INPUT_POST,'local');
    $codigo = filter_input(INPUT_POST,'codigo');
    $resultado = $redeLocal->manuCredencial($codigo, $tipo, $descricao, $user, $senha, $local);
}
header("Location: listar_creden.php");
