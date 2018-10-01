<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();
// Substitua os asteriscos (*) pelo números fornecidos nos passos anteriores.

$chat_id = "SeedCodinSeBot";

$token = "613587290:AAHvXgrfWBEcWRaZyiS-S-bkljsS8_GGEkA";

$mensagem = " Serviços SEED inporantes!!!!!!  ";

$url = "https://api.telegram.org/bot613587290:AAHvXgrfWBEcWRaZyiS-S-bkljsS8_GGEkA/sendMessage?chat_id=@seedcodinse&text=" . $mensagem ;

$execucao = file_get_contents($url);



//declare(strict_types = 1);
//include('../vendor/autoload.php');
//include '../class/conf.php-sample';
//
//use \unreal4u\TelegramAPI\HttpClientRequestHandler;
//use \unreal4u\TelegramAPI\TgLog;
//use \unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
//define('BOT_TOKEN', '613587290:AAHvXgrfWBEcWRaZyiS-S-bkljsS8_GGEkA');
//define('A_USER_CHAT_ID', 'seedcodinse');
//$loop = \React\EventLoop\Factory::create();
//$handler = new HttpClientRequestHandler($loop);
//$tgLog = new TgLog(BOT_TOKEN, $handler);
//
//$sendMessage = new SendMessage();
//$sendMessage->chat_id = A_USER_CHAT_ID;
//$sendMessage->text = 'Hello world!';
//
//$tgLog->performApiRequest($sendMessage);
//$loop->run();

//use React\EventLoop\Factory;
//use unreal4u\TelegramAPI\HttpClientRequestHandler;
//use unreal4u\TelegramAPI\Telegram\Methods\GetMe;
//use unreal4u\TelegramAPI\TgLog;
//use \unreal4u\TelegramAPI\Abstracts\TelegramTypes;
//$loop = Factory::create();
//$tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));
//$getMePromise = $tgLog->performApiRequest(new GetMe());
//$getMePromise->then(
//    function (TelegramTypes $getMeResponse) {
//        var_dump($getMeResponse);
//    },
//    function (\Exception $e) {
//        var_dump($e);
//    }
//);
//$loop->run();

//use React\EventLoop\Factory;
//use unreal4u\TelegramAPI\HttpClientRequestHandler;
//use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
//use unreal4u\TelegramAPI\TgLog;
//
//$loop = Factory::create();
//$tgLog = new TgLog(BOT_TOKEN, new HttpClientRequestHandler($loop));
//
//$sendMessage = new SendMessage();
//$sendMessage->chat_id = A_USER_CHAT_ID;
//$sendMessage->text = 'Hello world to the user... from a specialized getMessage file';
//
//$promise = $tgLog->performApiRequest($sendMessage);
//
//$promise->then(
//    function ($response) {
//        echo '<pre>';
//        var_dump($response);
//        echo '</pre>';
//    },
//    function (\Exception $exception) {
//        // Onoes, an exception occurred...
//        echo 'Exception ' . get_class($exception) . ' caught, message: ' . $exception->getMessage();
//    }
//);
//
//
//$sendMessage = new SendMessage();
//$sendMessage->chat_id = A_GROUP_CHAT_ID;
//$sendMessage->text = 'And this is a hello to the group... also from a getMessage file';
//
//$promise = $tgLog->performApiRequest($sendMessage);
//
//$promise->then(
//    function ($response) {
//        echo '<pre>';
//        var_dump($response);
//        echo '</pre>';
//    },
//    function (\Exception $exception) {
//        // Onoes, an exception occurred...
//        echo 'Exception ' . get_class($exception) . ' caught, message: ' . $exception->getMessage();
//    }
//);
//
//$loop->run();
