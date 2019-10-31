<?php

require '../../vendor/autoload.php';
include_once '../../class/database.php';

use PHPJasper\PHPJasper;


$banco = new DatabaseCalendar();

$input = __DIR__ . '/inventario_A4.jrxml';

$jasper = new PHPJasper;
$jasper->compile($input)->execute();

$periodo1 = filter_input(INPUT_GET,'periodo');
$periodo = date('m/Y', strtotime($periodo1));

$input = __DIR__ . '/inventario_A4.jasper';
$output = __DIR__ . '/inventario_A4';
$options = [
    'format' => ['pdf'],
    'params' => [       
        'REPORT_LOCALE' => 'pt_BR'
    ],
    'db_connection' => [
        'driver' => 'mysql',
        'username' => 'geitec',
        'password' => '74123698geitec',
        'host' => '172.25.76.68',
        'database' => 'glpi',
        'port' => '3306'
    ]
];


$jasper->process(
        $input, $output, $options
)->execute();

header("Location: inventario_a4.pdf");
