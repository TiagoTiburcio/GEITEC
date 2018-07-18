<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
set_time_limit(0);
require_once '../class/principal.php';
$teste = new Rede();
$zabbix = new ZabbixSEED();
//var_dump($teste->getArrayIPsRede("300"));
$c1 = $zabbix->listImpr();
foreach ($c1 as $value) {
    echo $value['ip'].'<br/>';
}

