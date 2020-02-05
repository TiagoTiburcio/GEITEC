<?php

use function Amp\Iterator\concat;

include_once '../class/principal.php';

$contas_div = new ImportContasDiversas();
$fornecedores = $contas_div->listaFornecedor();
$periodo = filter_input(INPUT_POST, 'periodo_ref');
$fornecedor = filter_input(INPUT_POST, 'fornecedor');
$contrato = filter_input(INPUT_POST, 'contrato');
$periodo = '01/' . $periodo;

//cria um array
$array = explode('/', $periodo);

//garante que o array possue tres elementos (dia, mes e ano)
if (count($array) == 3) {
    $dia = (int) $array[0];
    $mes = (int) $array[1];
    $ano = (int) $array[2];
    //testa se a data é válida
    if (checkdate($mes, $dia, $ano)) {
        echo " <div class='col-xs-4'> Data " . $periodo . " é válida <br/>";
        $data_depois = DateTime::createFromFormat('Y-m-d', date("Y-m-d"));
        $data_antes = DateTime::createFromFormat('Y-m-d', date("Y-m-d"));
        $data_depois->add(new DateInterval('P12M'));
        $data_antes->sub(new DateInterval('P24M'));
        $time = strtotime($periodo);
        $periodo_ref = date('Y-m-d', $time);
        if ($periodo_ref <= $data_antes->format('Y-m-d')) {
            session_start();
            $_SESSION['cd_erro'] = '1';
            $erro = 1;
        } elseif ($periodo_ref >= $data_depois->format('Y-m-d')) {
            session_start();
            $_SESSION['cd_erro'] = '2';
            $erro = 1;
        } else {
            $erro = 0;
        }
        echo '</div>';
    } else {
        echo " <div class='col-xs-4'> Data " . $periodo . " é inválida  </div>";
        session_start();
        $_SESSION['cd_erro'] = '3';
        $erro = 1;
    }
} else {
    echo " <div class='col-xs-4'> Formato da data " . $periodo . " inválido</div>";
    session_start();
    $_SESSION['cd_erro'] = '4';
    $erro = 1;
}
$rotina = new RotinasPublicas();
if ($erro == 1) {    
    header("Location: add_contas_diversas.php");    
} else {    
    if ($rotina->validaSessao('', '28') == 1) {
    
    ?>

    <?php    
        include("../class/footer.php");
    }
}