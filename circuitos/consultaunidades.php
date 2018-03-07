<?php
    //Conectando ao banco de dados
    include "../servicos/conexao.php"; 

    $consulta = $conexao->query("SELECT u_sup.sigla, u_sup.sigla as nome FROM circuitos_unidades as u left join circuitos_unidades as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig where u.ativo = '1' and u_sup.sigla = 'DRE01' order by u_sup.sigla;");    
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) { 
        $vetor[] = $linha;
     }

    //Passando vetor em forma de json
    echo json_encode($vetor);


//    
//    $consulta = $conexao->query("SELECT distinct u_sup.sigla, u_sup.sigla as nome FROM circuitos_unidades as u left join circuitos_unidades as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig where u.ativo = '1' and u_sup.sigla = 'DRE01' order by u_sup.sigla;");    
//    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {        
//        $consulta2 = $conexao->query("SELECT concat(u.cidade,' - ', u.descricao ) as cidades, u.codigo FROM circuitos_unidades as u left join circuitos_unidades as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig where u.ativo = '1' and u_sup.sigla = '".$linha['sigla']."' order by u.cidade , u.descricao ;"); 
//        while ($coluna = $consulta2->fetch(PDO::FETCH_ASSOC)) { 
//            if($coluna['cidades'] != ''){
//                $linha['cidades'][] = $coluna['cidades'];
//            }            
//        }
//        $vetor[] = $linha;
//     }
//
//    //Passando vetor em forma de json
//    echo json_encode($vetor);
//
