<?php
    include_once '../class/principal.php';
     
    $circuitos = new Circuitos();   

    if(!isset($_POST['arquivo'])) { $_POST['arquivo'] = ''; }
    if(!isset($_POST['num_linha'])) { $_POST['num_linha'] = ''; }
    if(!isset($_POST['designacao'])) { $_POST['designacao'] = ''; }
    $arquivo	= $_POST ["arquivo"];    
    $num_linha    = $_POST ["num_linha"];
    $designacao    = $_POST ["designacao"];
    $circuitos->editLinhaArquivo($arquivo, $num_linha, $designacao);
    header("Location: confirmaimport.php");