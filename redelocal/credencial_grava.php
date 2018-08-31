<?php

include_once '../class/principal.php';
$rotina = new RotinasPublicas();

if ($rotina->validaSessao('2') == 1) {
    $redeLocal = new RedeLocal();
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];
    $user = $_POST ['usuario'];
    $senha = $_POST ['senha'];
    $local = $_POST ['local'];
    $codigo = $_POST['codigo'];
    $resultado = $redeLocal->manuCredencial($codigo, $tipo, $descricao, $user, $senha, $local);
}
header("Location: listar_creden.php");
