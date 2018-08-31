<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../class/principal.php';
$sw = new Switchs();
chdir("log");
$arquivos = glob("{*.log}", GLOB_BRACE);
foreach ($arquivos as $key2 => $img) {
    echo 'arquivo: adsad' . $img;
    $linhas = explode("\n", file_get_contents($img));

    unlink('../redelocal/log/' . $img);
}