<?php

include_once '../class/principal.php';

$switch = new Switchs();

$sw = filter_input(INPUT_POST, 'sw');
$porta = filter_input(INPUT_POST, 'porta');
$tipo = filter_input(INPUT_POST, 'tipo_porta');
$tela = filter_input(INPUT_POST, 'tela');
$observacao = filter_input(INPUT_POST, 'observacao');
$velocidade = filter_input(INPUT_POST, 'velocidade');
$limpar = filter_input(INPUT_POST, 'limpar');
$vlan = filter_input(INPUT_POST, 'vlan');
$vlansw = filter_input(INPUT_POST, 'vlansw');
$opcaoTexto = filter_input(INPUT_POST, 'opcaoTexto');
$impressora = filter_input(INPUT_POST, 'Imp');
$modeloImp = filter_input(INPUT_POST, 'modImp');
$setor = filter_input(INPUT_POST, 'setorImp');
date_default_timezone_set("America/Bahia");
$data = date('Y-m-d H:i:s');

$resultado_portImp = $switch->consImpressoraPorta($sw, $porta, $tipo);
foreach ($resultado_portImp as $table_portImp) {
    $contador = $table_portImp['contador'];
    if ($table_portImp['contador'] != '0') {
        $impPorta = $table_portImp['codigo_host_zabbix'];
    }
}

$resultado_consImp = $switch->consImpressoraZbx($impressora);
foreach ($resultado_consImp as $table_consImp) {
    $contador2 = $table_consImp['contador'];

    if ($table_consImp['contador'] != '0') {
        $swImp = $table_consImp['codigo_switch'];
        $portImp = $table_consImp['codigo_porta_switch'];
        $tipoPortImp = $table_consImp['tipo_porta'];
    } else {
        $swImp = '';
        $portImp = '';
        $tipoPortImp = '';
    }
}

if ($opcaoTexto == '1') {
    $tela = $vlan;
} elseif (($opcaoTexto == '0') & ($tela == '')) {
    $tela = $vlan;
}

if ($limpar == '0') {
    if ($contador != '0') {
        $switch->limpaImpPorta($impPorta);
    }
    if (($vlan == '300')) {
        if (($impressora != '0') & ($modeloImp != '0')) {
            $switch->limpaImpPorta($impressora);
            $switch->limpaPortaSwitch($swImp, $portImp, $tipoPortImp);
            $switch->cadImpressora($porta, $sw, $tipo, $setor, $impressora, $modeloImp);
            $switch->manutPortaSwitch($porta, $sw, $tipo, $velocidade, $vlan, $observacao, $tela, $data);
        }
    } else {
        $switch->manutPortaSwitch($porta, $sw, $tipo, $velocidade, $vlan, $observacao, $tela, $data);
    }
} elseif ($limpar == '1') {
    $switch->limpaPortaSwitch($sw, $porta, $tipo);
    if ($contador != '0') {
        $switch->limpaImpPorta($impPorta);
    }
}

header('location:listarsw.php');
