<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4') == 1) {
    $filtro_inep = filter_input(INPUT_GET, 'inep');  
    if (($filtro_inep != NULL) || ($filtro_inep != "")){
        $escolas = new EscolasPG();
        $result = $escolas->listaEscolas($filtro_inep);
        while ($consulta = pg_fetch_assoc($result)) {                         
            $url =  "https://www.seed.se.gov.br/redeEstadual/Escola.asp?cdEscola=".$consulta["cdescola"]."&cdestrutura=".$consulta["cdestrutura"];            
        }        
    } else {
      if ((filter_input(INPUT_SERVER, 'HTTP_REFERER') != NULL) || (filter_input(INPUT_SERVER, 'HTTP_REFERER') != "")){
        $url = filter_input(INPUT_SERVER, 'HTTP_REFERER');
      } else {
          $url = "../index.php";
      }
    }
    header("Location:  ".$url);  
}
    