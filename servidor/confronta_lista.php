<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();


if ($rotina->validaSessao('2', '23') == 1) {

    $servidores = new Servidores();

    $lista_sem_cpf = $servidores->listaSemCPF();
    echo "'usuario_exp','nome_usuario','nome_servidor','cpf','ativo'<br/>";
    foreach ($lista_sem_cpf as $table) {
        $linhas = explode(" ", $table['nome']);
        foreach ($linhas as $key => $value) {
            switch ($key) {
                case 0:
                    $nome1 = $value;
                    break;
                case 1:
                    $nome2 = $value;
                    break;
                case 2:
                    $nome3 = $value;
                    break;
                default:
            }
        }
        $result = $servidores->buscaServidor($nome1, $nome2, $nome3);
        while ($consulta = pg_fetch_assoc($result)) {
            echo "'".$table['usuario']."','".$table['nome']."','" . $consulta["nome_servidor"] . "','" . $consulta["cpf"]."','".$consulta["ativo"]."'<br/>";
        }
    }
    echo '</div>';
   // include ("../class/footer.php");
}    
