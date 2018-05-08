<?php
     include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if ($usuario->validaSessao('2') == 1){
    
    $login = $_POST['login'];
    $nome_usuario = $_POST['nome_usuario'];
    $pass_branco = $_POST['pass'];
    $perfil = $_POST['perfil'];
    $ativo = $_POST['ativo'];
    $resetSenha = $_POST['resetSenha'];
    $altProxLogin = $_POST['altProxLogin'];
    $data = date_default_timezone_set("America/Bahia");
    $data = date('Y-m-d H:i:s');
    $resutado = $usuario->manutUsuario($login, $nome_usuario, $pass_branco, $ativo, $perfil, $altProxLogin, $usuario->getUsuario(), $data);
    if($resutado == '1'){
        echo 'usuario atualizado!';
    } else {
        echo 'usuario novo!';
    }
    
    header('location:listarusuarios.php');
    }  