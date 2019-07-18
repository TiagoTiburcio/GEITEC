<?php

require '../../vendor/autoload.php';
include_once '../../class/database.php';

use PHPJasper\PHPJasper;


$banco = new DatabaseCalendar();

$input = __DIR__ . '/localizacao.jrxml';

$jasper = new PHPJasper;
$jasper->compile($input)->execute();

$periodo1 = filter_input(INPUT_GET,'periodo');
$periodo = date('m/Y', strtotime($periodo1));

$input = __DIR__ . '/localizacao.jasper';
$output = __DIR__ . '/localizacao';
$options = [
    'format' => ['pdf'],
    'params' => [
        'periodo' => $periodo,
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


$jasper->process(
        $input, $output, $options
)->execute();

header("Location: localizacao.pdf");
