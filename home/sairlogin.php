<?php
session_start();
// as vari�veis login e senha recebem os dados digitados na p�gina anterior

session_destroy();

//Limpa
 if (isset($_SESSION['login'])){unset ($_SESSION['login']);}
if (isset($_SESSION['pass'])){unset ($_SESSION['pass']);}


//Redireciona para a p�gina de autentica��o
header('location:login.php');
	

