<?php
     include_once '../class/usuario.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
    
    $login = $_POST['login'];
    $nome_usuario = $_POST['nome_usuario'];
    $pass_branco = $_POST['pass'];    
    
    if($usuario->editUsuario($login, $nome_usuario, $pass_branco) == 1){
        $pass = $usuario->getSenha();
    } else {
        echo "erro na gravacao";
    }
    
    header('location:index.php');
    