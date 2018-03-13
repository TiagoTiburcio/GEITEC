<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $circuitos = new Circuitos();   

   
    $designacao	= $_POST ["designacao"];    
    $localizacao   = $_POST ["localizacao"];
    $unidade    = $_POST ["combobox"];
    
    echo $designacao .' adsa '. $localizacao . ' asddsa '. $unidade;
    
    $circuitos->addRegistroConsumo($designacao, $localizacao, $unidade);
    header("Location: confirmaimport.php");