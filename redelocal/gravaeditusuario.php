<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('4', '0') == 1) {
$codigo = filter_input(INPUT_GET, 'codigo');

$redeLocal = new RedeLocal();
if ($codigo == '') {
    $cpf = filter_input(INPUT_POST, 'cpf');
    $cod = filter_input(INPUT_POST, 'codigo');
    $usuario_exp = filter_input(INPUT_POST, 'usuario_exp');
    $usuario_rede = filter_input(INPUT_POST, 'usuario_rede');
    $cod_recad = filter_input(INPUT_POST, 'cod_recad');
    $mot_desat = filter_input(INPUT_POST, 'mot_desat');
    $situacao = filter_input(INPUT_POST, 'situacao');
    
    date_default_timezone_set("America/Bahia");
    $data = date('Y-m-d H:i:s');
    echo 'Data: '.$data.' | Cod: '.$cod;
    $teste = $redeLocal->updateSituacaoExpresso($cod, "1");
    $redeLocal->gravaUsuarioGeral($cpf, $usuario_rede, $cod_recad, $usuario_exp, $data, $_SESSION['login'], $situacao, $mot_desat);
} else {
    echo $codigo;    
    $teste = $redeLocal->updateSituacaoExpresso($codigo, "0");
}
}

header('location:lista_expresso.php');
