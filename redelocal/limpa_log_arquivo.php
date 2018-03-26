<?php
include_once '../class/principal.php';
$zbxCofre = new ZabbixCofre();
$logArquivos = new LogArquivos();   
$logArquivos->limpaLog(); 
header("Location: ../servicos/telacentral.php");