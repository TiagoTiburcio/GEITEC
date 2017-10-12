<?php
    //Conectando ao banco de dados
    include "../servicos/conexao.php"; 

    $consulta = $conexao->query("SELECT * FROM servicos_eventos where color in ('green','#ff9f89');"); 

    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {        
        $vetor[] = $linha;
     }

    //Passando vetor em forma de json
    echo json_encode($vetor);