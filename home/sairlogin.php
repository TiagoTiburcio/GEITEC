<?php
session_start();
// as vari�veis login e senha recebem os dados digitados na p�gina anterior
$login = $_POST['login'];
$pass =  $_POST['pass'];
//Destr�i
session_destroy();

//Limpa
unset ($_SESSION['login']);
unset ($_SESSION['pass']);

//Redireciona para a p�gina de autentica��o
header('location:login.php');
	

