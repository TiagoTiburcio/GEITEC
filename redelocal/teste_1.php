<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
set_time_limit(0);
require_once '../class/principal.php';
$sw = new Switchs();
chdir( "log" );
$inicio = $_GET ["inicio"];
$fim = $_GET ["fim"];
$num = $_GET ["num"];
$arquivos = glob("{*.jpg}", GLOB_BRACE);
foreach($arquivos as $key2 => $img){
    echo $key2.'as: '.$img.'<br/>';
    $string = $img;
    $string = str_replace(" ","_",$string);
    $arq = $string;
    rename($img , $arq);        
}
header("Refresh:5");