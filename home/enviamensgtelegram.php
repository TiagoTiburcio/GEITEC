<?php

declare(strict_types = 1);
include_once '../class/principal.php';
include('../vendor/autoload.php');
include '../class/conf_telegram.php';

use React\EventLoop\Factory;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\TgLog;

$padrao = new RotinasPublicas();

$filelog = "../temp/log.txt";
if (file_exists($filelog)) {
    echo 'Mensagem já enviada!';
} else {
    $loop = Factory::create();
    $tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));

    $sendMessage = new SendMessage();
    $sendMessage->chat_id = A_USER_CHAT_ID;
    $sendMessage->text = 'Banco de Dados Mysql SRV-027 Inacessível Zabbix Inoperantes sem possibilidade de envio de Graficos';

    $promise = $tgLog->performApiRequest($sendMessage);

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






