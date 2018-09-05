<?php

include_once '../class/principal.php';

$usuario = new Usuario();
$rotina = new RotinasPublicas();

if ($rotina->validaSessao('2') == 1) {

    $login = filter_input(INPUT_POST, 'login');
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario');
    $pass_branco = filter_input(INPUT_POST, 'pass');
    $perfil = filter_input(INPUT_POST, 'perfil');
    $ativo = filter_input(INPUT_POST, 'ativo');
    $resetSenha = filter_input(INPUT_POST, 'resetSenha');
    $altProxLogin = filter_input(INPUT_POST, 'altProxLogin');
    $tipoLogin = filter_input(INPUT_POST, 'tipologin');
    date_default_timezone_set("America/Bahia");
    $data = date('Y-m-d H:i:s');
    $resutado = $usuario->manutUsuario($login, $nome_usuario, $pass_branco, $ativo, $perfil, $altProxLogin, $usuario->getUsuario(), $data);
    if ($resutado == '1') {
        echo 'usuario atualizado!';
    } else {
        echo 'usuario novo!';
    }

    header('location:listarusuarios.php');
}  