<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../class/principal.php';
$img = filter_input(INPUT_GET,'arq');
$sw = new Switchs();
chdir("log");
$sql = array();
$linhas = explode("\n", file_get_contents($img));
foreach ($linhas as $key => $value) {
    $colunas = explode(" ", $value);
    if (substr($value, 0, 1) != '#') {
        foreach ($colunas as $key1 => $v1) {
            switch ($key1) {
                case 0:
                    $data_hora = $v1;
                    break;
                case 1:
                    $data_hora = $data_hora . " " . $v1;
                    break;
                case 2:
                    $sitename = $v1;
                    break;
                case 3:
                    $computername = $v1;
                    break;
                case 4:
                    $ip_srv = $v1;
                    break;
                case 5:
                    $metodo = $v1;
                    break;
                case 6:
                    $url_acesso = $v1;
                    break;
                case 7:
                    $parametro_acesso = $v1;
                    break;
                case 8:
                    $porta_acesso = $v1;
                    break;
                case 9:
                    $usuario_logado = $v1;
                    break;
                case 10:
                    $ip_cliente = $v1;
                    break;
                case 11:
                    $versao_http = $v1;
                    break;
                case 12:
                    $browser = $v1;
                    break;
                case 13:
                    $cookie = $v1;
                    break;
                case 14:
                    $site_encaminha = $v1;
                    break;
                case 15:
                    $dns_acesso = $v1;
                    break;
                case 16:
                    $status_solic = $v1;
                    break;
                case 17:
                    $sub_status_solic = $v1;
                    break;
                case 18:
                    $win32_status = $v1;
                    break;
                case 19:
                    $bytes_enviados = $v1;
                    break;
                case 20:
                    $bytes_recebidos = $v1;
                    break;
                case 21:
                    $tempo_solic = $v1;
                    break;
                default:
            }
        }
        $sql[] = "('" . $data_hora . "', '" . $sitename . "', '" . $computername . "', '" . $ip_srv . "', '" . $metodo . "', '" . $url_acesso . "', '" . $parametro_acesso . "', '" . $porta_acesso . "', '" . $usuario_logado . "', '" . $ip_cliente . "', '" . $versao_http . "', '" . $browser . "', '" . $cookie . "', '" . $site_encaminha . "', '" . $dns_acesso . "', '" . $status_solic . "', '" . $sub_status_solic . "', '" . $win32_status . "', '" . $bytes_enviados . "', '" . $bytes_recebidos . "', '" . $tempo_solic . "')";
    }
}
$sw->arrayLogWebIIS($sql);
unlink($img);
