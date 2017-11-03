<?php
    session_start();

    //Caso o usu�rio n�o esteja autenticado, limpa os dados e redireciona
    if ( !isset($_SESSION['login']) and !isset($_SESSION['pass']) ) {
	//Destr�i
	session_destroy();

	//Limpa
	unset ($_SESSION['login']);
	unset ($_SESSION['pass']);
        unset ($_SESSION['nome_usuario']);
	
	//Redireciona para a p�gina de autentica��o
	header('location:login.php');
    } else {
        include_once '../class/principal.php';
        
        $login = $_POST['login'];
        $nome_usuario = $_POST['nome_usuario'];
        $pass_branco = $_POST['pass'];
        
        $usuario = new Usuario();
        
        if($usuario->gravaNovaSenha($login, $pass_branco) == 1 ){
            echo "Gravado com sucesso";
            $pass = $usuario->getSenha();
        } else {
            echo "Erro gravacao";
        }
        
        header('location:index.php');
    }
