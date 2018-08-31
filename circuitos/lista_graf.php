<?php

//Conectando ao banco de dados
include "../class/principal.php";

$circuito = new Circuitos();

$meses = $circuito->listaMesesContasAno();
foreach ($meses as $meses_table) {
    $meses_graph[] = $meses_table['mes'];
}
// echo '["' . implode('", "', $meses_graph) . '"]';
// echo '';

$contratos = $circuito->listaContratosContasAno();
$contas = $circuito->listaValorContasAno();

foreach ($contratos as $contratos_table) {
    $contratos_graph[] = $contratos_table['fatura'];
}
$cores = array("red", "orange", "yellow", "green", "blue", "purple", "grey");
$ind_cor = "0";
//echo '["' . implode('", "', $contratos_graph) . '"]';    
// echo '';
echo "labels: ";
echo '["' . implode('", "', $meses_graph) . '"],  datasets:';
foreach ($contratos_graph as $key => $value) {
    if ($key == 0) {
        echo '[';
    } else {
        echo ',';
    }
    echo "{ backgroundColor: utils.transparentize(presets.$cores[$ind_cor]), borderColor: presets.$cores[$ind_cor], data: ";
    foreach ($meses_graph as $key1 => $value1) {
        $fat = $value;
        $val = '0.00';
        $mes = $value1;
        if ($key1 == 0) {
            echo '[';
        } else {
            echo ',';
        }
        foreach ($contas as $contas_table) {
            if (($value == $contas_table['fatura']) && ($value1 == $contas_table['mes'])) {
                $fat = $contas_table['fatura'];
                $val = $contas_table['valor_double'];
                $mes = $contas_table['mes'];
            }
        }
        echo ' ' . number_format($val, 2, '.', '');
    }
    if ($ind_cor < 6) {
        $ind_cor = $ind_cor + 1;
    } else {
        $ind_cor = 0;
    }
    echo "],  hidden: false,  label: '$value',  fill: true} ";
}
echo ']';
