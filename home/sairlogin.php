<?php
session_start();
// as variбveis login e senha recebem os dados digitados na pбgina anterior
$login = $_POST['login'];
$pass =  $_POST['pass'];
//Destrуi
session_destroy();

//Limpa
unset ($_SESSION['login']);
unset ($_SESSION['pass']);

//Redireciona para a pбgina de autenticaзгo
header('location:login.php');
	

