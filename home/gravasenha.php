<?php

if (!session_id()) {
    session_start();
}
//Caso o usuario nao esteja autenticado, limpa os dados e redireciona
if (!isset($_SESSION['login']) and ! isset($_SESSION['pass'])) {
    //Destroi
    session_destroy();

    //Limpa
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
    unset($_SESSION['nome_usuario']);

    //Redireciona para a pagina de autenticacao
    header('location:login.php');
} else {
    include_once '../class/principal.php';

    $login = filter_input(INPUT_POST, 'login');
    $nome_usuario = filter_input(INPUT_POST, 'nome_usuario');
    $pass_branco = filter_input(INPUT_POST, 'pass');
    date_default_timezone_set("America/Bahia");
    $data = date('Y-m-d H:i:s');
    $usuario = new Usuario();
    $dadosUsuario = $usuario->iniUsuario($login);
    foreach ($dadosUsuario as $table) {
        $resultado = $usuario->manutUsuario($table['usuario'], $table['nome'], $pass_branco , $table['ativo'], $table['codigo_perfil'], "0",  $_SESSION['login'], "1" , $data);
        if ($resultado == 1) {
        echo  $table['codigo_perfil'] . "Gravado com sucesso";
            $pass = $table['senha'];
        } else {
            echo "Erro gravacao";
        }
    }    
    
    header('location:index.php');
}
