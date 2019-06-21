<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {
    $hostid = (empty(filter_input(INPUT_POST, 'hostid'))) ? '' : filter_input(INPUT_POST, 'hostid');
    if ($hostid != '') {
        $servidores = new RedeLocalServidores();
        $dados_srv = $servidores->listServidores($hostid);
        $codigo_bd = (empty(filter_input(INPUT_POST, 'codigo'))) ? '' : filter_input(INPUT_POST, 'codigo');
        $nome = (empty(filter_input(INPUT_POST, 'nome'))) ? '' : filter_input(INPUT_POST, 'nome');
        $descricao = (empty(filter_input(INPUT_POST, 'descricao'))) ? '' : filter_input(INPUT_POST, 'descricao');
        $tipo_bd = (empty(filter_input(INPUT_POST, 'tipo_bd'))) ? '' : filter_input(INPUT_POST, 'tipo_bd');
        $servidores->addBancoDados($hostid, $nome, $tipo_bd, $descricao, $codigo_bd);
        header('location:servidores_servidor_aplicativo.php?hostid='.$hostid);
    }else {
        echo 'Erro sem codigo de Servidor Atualize a pagina';
    }
}
    