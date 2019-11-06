<?php

require '../../vendor/autoload.php';
include_once '../../class/database.php';

$periodo1 = filter_input(INPUT_GET, 'periodo');
$contrato = filter_input(INPUT_GET, 'fatura');
$fornecedor = filter_input(INPUT_GET, 'fornecedor');
$periodo = date('m/Y', strtotime($periodo1));

use PHPJasper\PHPJasper;

$banco = new DatabaseCalendar();

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

$jasper->process(
        $input, $output, $options
)->execute();

header("Location: sintetico.pdf");
