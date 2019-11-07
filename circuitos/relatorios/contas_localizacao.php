<?php

require '../../vendor/autoload.php';
include_once '../../class/database.php';

use PHPJasper\PHPJasper;


$banco = new DatabaseCalendar();
$jasper = new PHPJasper;

$periodo1 = filter_input(INPUT_GET, 'periodo');
$fornecedor = filter_input(INPUT_GET, 'fornecedor');
$periodo = date('m/Y', strtotime($periodo1));

if ($fornecedor == 'Aloo') {
    $input = __DIR__ . '/localizacao_aloo.jrxml';
    $jasper->compile($input)->execute();
    $input = __DIR__ . '/localizacao_aloo.jasper';
    $output = __DIR__ . '/localizacao';
    $options = [
        'format' => ['pdf'],
        'params' => [
            'periodo' => $periodo,
            'fornecedor' => $fornecedor,
            'REPORT_LOCALE' => 'pt_BR'
        ],
        'db_connection' => [
            'driver' => 'mysql',
            'username' => $banco::$user,
            'password' => $banco::$password,
            'host' => $banco::$host,
            'database' => $banco::$db,
            'port' => '3306'
        ]
    ];
} elseif ($fornecedor == 'OI') {
    $input = __DIR__ . '/localizacao.jrxml';
    $jasper->compile($input)->execute();
    $input = __DIR__ . '/localizacao.jasper';
    $output = __DIR__ . '/localizacao';
    $options = [
        'format' => ['pdf'],
        'params' => [
            'periodo' => $periodo,
            'fornecedor' => $fornecedor,
            'REPORT_LOCALE' => 'pt_BR'
        ],
        'db_connection' => [
            'driver' => 'mysql',
            'username' => $banco::$user,
            'password' => $banco::$password,
            'host' => $banco::$host,
            'database' => $banco::$db,
            'port' => '3306'
        ]
    ];
}

$jasper->process(
    $input,
    $output,
    $options
)->execute();

header("Location: localizacao.pdf");
