<?php

require '../../vendor/autoload.php';

$periodo1 = filter_input(INPUT_GET, 'periodo');
$contrato = filter_input(INPUT_GET, 'fatura');
$periodo = date('m/Y', strtotime($periodo1));

use PHPJasper\PHPJasper;

$input = __DIR__ . '/sintetico.jrxml';

$jasper = new PHPJasper;
$jasper->compile($input)->execute();

$input = __DIR__ . '/sintetico.jasper';
$output = __DIR__ . '/sintetico';
$options = [
    'format' => ['pdf'],
    'params' => [
        'periodo' => $periodo,
        'contrato' => $contrato,
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

header("Location: sintetico.pdf");
