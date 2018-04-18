<?php
require '../../vendor/autoload.php';

$periodo1 = $_GET['periodo'];
$periodo = date('m/Y',strtotime($periodo1));

use PHPJasper\PHPJasper;

$input = __DIR__ . '/sintetico.jrxml';   

$jasper = new PHPJasper;
$jasper->compile($input)->execute();

$input = __DIR__ . '/sintetico.jasper';  
$output = __DIR__ . '/sintetico';    
$options = [
    'format' => ['pdf'],    
    'params' => ['periodo' => $periodo],
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
    $input,
    $output,
    $options
)->execute();

header("Location: sintetico.pdf");