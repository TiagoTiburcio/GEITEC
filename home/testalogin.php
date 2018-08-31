<?php

// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$pass_branco = $_POST['pass'];

include_once '../class/principal.php';

$usuario = new Usuario();
//Caso consiga logar cria a sessão
$teste = $usuario->iniUsuario($login);

if ($teste == 1 && $usuario->getSenha() == $usuario->getSenhaEncriptada($pass_branco) && $usuario->getAtivo() == '1') {
    // session_start inicia a sessão
    session_start();

    $_SESSION['login'] = $usuario->getUsuario();
    $_SESSION['pass'] = $usuario->getSenha();
    $_SESSION['nome_usuario'] = $usuario->getNome();
    echo '<META http-equiv="refresh" content="0;../home/index.php">';
}
//Caso contrário redireciona para a página de autenticação
else {
    //Destrói
    session_destroy();

    //Limpa
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
    unset($_SESSION['nome_usuario']);
    unset($usuario);

    //Redireciona para a página de autenticação
    echo '<META http-equiv="refresh" content="0;../home/login.php">';
}

    