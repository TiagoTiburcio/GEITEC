<?php
     include_once '../class/principal.php';
    
    $switch = new Switchs();
    
    $sw = $_POST['sw'];
    $porta = $_POST['porta'];
    $tipo = $_POST['tipo_porta'];
    $tela = $_POST['tela'];
    $observacao = $_POST['observacao'];
    $velocidade = $_POST['velocidade'];
    $vlan = $_POST['vlan'];
    $data = date_default_timezone_set("America/Bahia");
    $data = date('Y-m-d H:i:s');
    $switch->manutPortaSwitch($porta, $sw, $tipo, $velocidade, $vlan, $observacao, $tela, $data);
   
    
    header('location:listarsw.php');
    