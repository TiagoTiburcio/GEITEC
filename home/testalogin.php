<?php
// as vari�veis login e senha recebem os dados digitados na p�gina anterior
$login = $_POST['login'];
$pass_branco = $_POST['pass'];

include_once '../class/principal.php';

$usuario = new Usuario();    
//Caso consiga logar cria a sess�o
if ($usuario->verificaUsuario($login, $pass_branco) == 1) {
	// session_start inicia a sess�o
	session_start();
	
	$_SESSION['login'] = $usuario->getUsuario();
	$_SESSION['pass'] = $usuario->getSenha();
        $_SESSION['nome_usuario'] = $usuario->getNome();
        echo '<META http-equiv="refresh" content="0;../home/index.php">';
}

//Caso contr�rio redireciona para a p�gina de autentica��o
else {
	//Destr�i
	session_destroy();

	//Limpa
	unset ($_SESSION['login']);
	unset ($_SESSION['pass']);
        unset ($_SESSION['nome_usuario']);

	//Redireciona para a p�gina de autentica��o
	echo '<META http-equiv="refresh" content="0;../home/login.php">';
	
}

    