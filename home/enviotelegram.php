<?php

declare(strict_types = 1);
include_once '../class/principal.php';
include('../vendor/autoload.php');
include '../class/conf_telegram.php';

use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendPhoto;
use unreal4u\TelegramAPI\Telegram\Types\Custom\InputFile;
use unreal4u\TelegramAPI\TgLog;

$circuitos = new Circuitos();

if ($circuitos->testeConexao() == 1) {
    include '../home/enviamensgtelegram.php';
} else {
    $zabbix = new ZabbixCofre();
    $rotina = new RotinasPublicas();
    $rede = new Rede();

    $consulta = $zabbix->listaAtivosPrincipais();

    $filtro_ckt = "";
    $filtro_period = "7200";
    foreach ($consulta as $ativos) {
        $teste = 0;
        $alerta = $rede->getAlertas($ativos['name']);
        foreach ($alerta as $table_alerta) {
            if (($table_alerta['cont'] == 0) && ($ativos['value'] == 1)) {
                $teste = 1 + $teste;
                $rede->setAlerta($ativos['name'], $ativos['data']);
            } elseif (($table_alerta['cont'] != 0) && ($ativos['value'] == 1)) {
                echo 'Incidente em aberto <br/>Data: ' . $table_alerta['data_evento'] . '<br/>';
                echo 'Nome Host: ' . $table_alerta['nome_host'] . '<br/>';
            } elseif (($table_alerta['cont'] != 0) && ($ativos['value'] == 0)) {
                $teste = 1 + $teste;
                echo 'Data: ' . $table_alerta['data_evento'] . '<br/>';
                echo 'Nome Host: ' . $table_alerta['nome_host'] . '<br/>';
                $rede->updateAlerta($table_alerta['nome_host'], $table_alerta['data_evento']);
            }
        }
        echo $ativos['name'] . ' Siutacao ' . $teste . '<br/>';
        if ($teste == 1) {
            $filelog = "../temp/log.txt";
            if (file_exists($filelog)){
                unlink($filelog);
            }
            $zbx = 'http://172.25.76.61/zabbix/index.php';
            $data = 'name=redmine&password=74123698seed&autologin=1&enter=Sign+in';

            $rotina->login($zbx, $data, "zabbix_cofre");

            $filtro_ckt = $ativos['name'];
            $grafico = $ativos['graphid'];
            if ($grafico != "") {
                $s = "http://172.25.76.61/zabbix/chart2.php?graphid=$grafico&period=$filtro_period&width=960";
                $rotina->grab_page($s, $filtro_ckt . ".png", "zabbix_cofre");
            }

            $loop = Factory::create();
            $tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));

            $sendPhoto = new SendPhoto();
            $sendPhoto->chat_id = A_USER_CHAT_ID;
            $sendPhoto->photo = new InputFile('../images/temp/' . $filtro_ckt . '.png');
            $sendPhoto->caption = "$filtro_ckt com está " . $ativos['situacao'] . " desde " . $ativos['data'];

            $promise = $tgLog->performApiRequest($sendPhoto);

            $promise->then(
                    function ($response) {
                echo '<pre>';
                var_dump($response);
                echo '</pre>';
            }, function (\Exception $exception) {
                // Onoes, an exception occurred...
                echo 'Exception ' . get_class($exception) . ' caught, message: ' . $exception->getMessage();
            }
            );
            $loop->run();
        }
    }
}




