<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author tiagoc
 */
include_once '../class/database.php';
class Servidores extends database {
       
    function __construct(){ }
          
    // retorna lista com todos os usuarios cadastrados
    function listaServidores($_cpf, $_nome, $_setor, $_siglasetor){        
        $consulta_servidores1 = "select * from (SELECT (INSERT(INSERT( INSERT( lpad(cpf, 11, '0'), 10, 0, '-' ), 7, 0, '.' ), 4, 0, '.' )) as formatcpf,"
                                . "`nome_servidor`, `cpf`, `pis`, `nivel_4`, "
                                . "`nivel_3`, `nivel_2`, `nivel_1`, `nome_setor`, "
                                . "`tipo_vinculo`, `cargo` "
                                . "FROM servidor_lista) as consulta "
                                . "where "
                                . "`nome_servidor` like '%$_nome%' "
                                . "and formatcpf like '%$_cpf%' "
                                . "and nome_setor like '%$_setor%' "
                                . "and nivel_1 like '%$_siglasetor%' "
                                . "order by `nome_servidor` "
                                . "limit 30;";                              
        $resultado_servidores1 = mysqli_query($this->connect(), $consulta_servidores1);
        return $resultado_servidores1;
    } 
    
    function __destruct() {}
}
