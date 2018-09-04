<?php

//Conectando ao banco de dados
include "../servicos/conexao.php";

$consulta = $conexao->query(" SELECT * FROM circuitos_contas as c join circuitos_registro_consumo as rc on c.designacao = rc.codigo join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade where periodo_ref = '2017-10-01'; ");
while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $vetor[] = $linha;
}

//Passando vetor em forma de json
echo json_encode($vetor);
