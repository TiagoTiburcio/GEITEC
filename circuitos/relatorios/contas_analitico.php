<?php

require '../../vendor/autoload.php';

use PHPJasper\PHPJasper;

$input = __DIR__ . '/analitico.jrxml';

$jasper = new PHPJasper;
$jasper->compile($input)->execute();

$periodo1 = filter_input(INPUT_GET,'periodo');
$periodo = date('m/Y', strtotime($periodo1));



$input = __DIR__ . '/analitico.jasper';
$output = __DIR__ . '/analitico';
$options = [
    'format' => ['pdf'],
    'params' => [
        'periodo' => $periodo,
        'REPORT_LOCALE' => 'pt_BR'
    ],
    'db_connection' => [
        'driver' => 'mysql',
        'username' => 'geitec',
        'password' => 'seedqawsed',
        'host' => '172.25.76.85',
        'database' => 'sis_geitec',
        'port' => '3306'
    ]
];

$jasper->process(
        $input, $output, $options
)->execute();

header("Location: analitico.pdf");
