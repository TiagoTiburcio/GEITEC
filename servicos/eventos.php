<?php
    //Conectando ao banco de dados
    include "../servicos/conexao.php"; 

    $consulta = $conexao->query("SELECT * FROM servicos_eventos;"); 

    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {        
        $vetor[] = $linha;
     }

    //Passando vetor em forma de json
    echo json_encode($vetor);

