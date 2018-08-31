<?php

session_start();
// as variaveis login e senha recebem os dados digitados na pagina anterior

session_destroy();

//Limpa
if (isset($_SESSION['login'])) {
    unset($_SESSION['login']);
}
if (isset($_SESSION['pass'])) {
    unset($_SESSION['pass']);
}


//Redireciona para a pagina de autenticacao
header('location:login.php');


