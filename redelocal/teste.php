<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
set_time_limit(0);
require_once '../class/principal.php';
$sw = new Switchs();
chdir("log");
$inicio = filter_input(INPUT_GET,'inicio');
$fim = filter_input(INPUT_GET,'fim');
$num = filter_input(INPUT_GET,'num');
$arquivos = glob("{*.log}", GLOB_BRACE);
foreach ($arquivos as $key2 => $img) {
    if (($key2 >= $inicio) & ($key2 <= $fim)) {
        echo $key2 . 'as: ' . $img . '<br/>';
        $arq = $num . "-" . $key2 . ".txt";
        rename($img, $arq);
        unlink($img);
        $ch = curl_init('http://' . filter_input(INPUT_SERVER,'SERVER_NAME') . str_replace("teste.php", "", filter_input(INPUT_SERVER,'REQUEST_URI')) . 'abrirarq.php?arq=' . $arq);
        $fp = fopen("example_homepage.txt", "w");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }
}
header("Refresh:5");
