<?php
    include_once '../class/principal.php';
        
    $usuario = new Usuario();    
    $servicos = new Servico();
       
    $usuario->validaSessao();
    
    $repeticao	= $_POST ["repeticao"];    
    $descricao  = $_POST ["descricao"];
    $nome_redu  = $_POST ["nome_redu"];
    $codigo     = $_POST ["servico"];
    
    $servicos->manutServico($codigo,$nome_redu,$descricao,$repeticao);
    
    echo '<META http-equiv="refresh" content="0;../servicos/servicos.php">';
    
   
include ("../class/footer.php");
