<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../class/principal.php';
$circuito = new Circuitos();
chdir( "uploads" );
$sql = array(); 
$arquivos = glob("{*.txt}", GLOB_BRACE);
foreach($arquivos as $key2 => $img){
    $linhas = explode("\n", file_get_contents($img));
    foreach ($linhas as $key => $value){
        $colunas = explode(";", $value);    
        if ($key != '0'){
           foreach ($colunas as $key1 => $v1){                
                switch ($key1) {
                case 0:                    
                    $site = str_replace("'","",$v1);
                    break;
                case 1:
                    $nome_cliente = str_replace("'","",$v1); 
                    break;
                case 2:
                    $finalidade = str_replace("'","",$v1);
                    break;
                case 3:
                    $contrato = str_replace("'","",$v1);
                    break;
                case 4:
                    $ciclo_faturamento = str_replace("'","",$v1);
                    break;
                case 5:
                    $num_fatura = str_replace("'","",$v1);
                    break;
                case 6:
                    $num_nota_fiscal = str_replace("'","",$v1);
                    break;
                case 7:
                    $cod_ddd = str_replace("'","",$v1);
                    break;
                case 8:
                    $num_telefone = str_replace("'","",$v1);
                    break;
                case 9:
                    $designacao = str_replace("'","",$v1);
                    break;
                case 10:
                    $valor_a_pagar = str_replace("'","",$v1);
                    break;
                case 11:
                    $nome_cidade = str_replace("'","",$v1);
                    break;
                case 12:
                    $tip_logradouro = str_replace("'","",$v1);
                    break;
                case 13:
                    $nome_logradouro = str_replace("'","",$v1);
                    break;
                case 14:
                    $num_imovel = str_replace("'","",$v1);
                    break;
                case 15:
                    $nome_bairro = str_replace("'","",$v1);
                    break;
                case 16:
                    $cep = str_replace("'","",$v1);
                    break;
                case 17:
                    $sigla_uf = str_replace("'","",$v1);
                    break;
                case 18:
                    $nome_cidade1 = str_replace("'","",$v1);
                    break;
                case 19:
                    $tip_logradouro1 = str_replace("'","",$v1);
                    break;
                case 20:
                    $nome_logradouro1 = str_replace("'","",$v1);
                    break;
                case 21:
                    $num_imovel1 = str_replace("'","",$v1);
                    break;
                case 22:
                    $nome_bairro1 = str_replace("'","",$v1);
                    break;
                case 23:
                    $cep1 = str_replace("'","",$v1);
                    break;
                case 24:
                    $sigla_uf1 = str_replace("'","",$v1);
                    break;
                case 25:
                    $prod_telefone = str_replace("'","",$v1);
                    break;
                case 26:
                    $velocidade_circuito = str_replace("'","",$v1);
                    break;
                case 27:
                    $num_pagina = str_replace("'","",$v1);
                    break;
                case 28:
                    $num_linha = str_replace("'","",$v1);
                    break;
                case 29:
                    $data_servico = str_replace("'","",$v1);
                    break;
                case 30:
                    $servico = str_replace("'","",$v1);
                    break;
                case 31:
                    $degrau = str_replace("'","",$v1);
                    break;
                case 32:
                    $num_tel_origem = str_replace("'","",$v1);
                    break;
                case 33:
                    $cod_selecao = str_replace("'","",$v1);
                    break;
                case 34:
                    $ddd_tel_origem = str_replace("'","",$v1);
                    break;
                case 35:
                    $telefone_destino = str_replace("'","",$v1);
                    break;
                case 36:
                    $hr_qtd_chamada = str_replace("'","",$v1);
                    break;
                case 37:
                    $duracao = str_replace("'","",$v1);
                    break;
                case 38:
                    $s = str_replace("'","",$v1);
                    break;
                 case 39:
                    $valor_servico = str_replace("'","",$v1);
                    break;
                case 40:
                    $aliquota_icms = str_replace("'","",$v1);
                    break;
                case 41:
                    $conta = str_replace("'","",$v1);
                    break;
                case 42:
                    $num_detalhe = str_replace("'","",$v1);
                    break;
                case 43:
                    $cod_l_origem = str_replace("'","",$v1);
                    break;
                case 44:
                    $cod_l_destino = str_replace("'","",$v1);
                    break;
                case 45:
                    $vencimento = str_replace("'","",$v1);
                    break;
                case 46:
                    $contestar = str_replace("'","",$v1);
                    break;
                case 47:
                    $valor_contestar = str_replace("'","",$v1);
                    break;
                case 48:
                    $localidade = str_replace("'","",$v1);
                    break;
                case 49:
                    $tel_origem = str_replace("'","",$v1);
                    break;
                case 50:
                    $sigla_orgao_analise = str_replace("'","",$v1);
                    break;
                default:                       
                }
            }
            if($designacao != '' ){
                $sql[] = "('".$img."', '".$key."', '".$site."', '".$nome_cliente."', '".$finalidade."', '".$contrato."', '".$ciclo_faturamento."', '".$num_fatura."', '".$num_nota_fiscal."', '".$cod_ddd."', '".$num_telefone."', '".$designacao."', '".$valor_a_pagar."', '".$nome_cidade."', '".$tip_logradouro."', '".$nome_logradouro."', '".$num_imovel."', '".$nome_bairro."', '".$cep."', '".$sigla_uf."', '".$nome_cidade1."', '".$tip_logradouro1."', '".$nome_logradouro1."', '".$num_imovel1."', '".$nome_bairro1."', '".$cep1."', '".$sigla_uf1."', '".$prod_telefone."', '".$velocidade_circuito."', '".$num_pagina."', '".$num_linha."', '".$data_servico."', '".$servico."', '".$degrau."', '".$num_tel_origem."', '".$cod_selecao."', '".$ddd_tel_origem."', '".$telefone_destino."', '".$hr_qtd_chamada."', '".$duracao."', '".$s."', '".$valor_servico."', '".$aliquota_icms."', '".$conta."', '".$num_detalhe."', '".$cod_l_origem."', '".$cod_l_destino."', '".$vencimento."', '".$contestar."', '".$valor_contestar."', '".$localidade."', '".$tel_origem."', '".$sigla_orgao_analise."')";
            }            
            $site = '';
            $nome_cliente = ''; 
            $finalidade = '';
            $contrato = '';
            $ciclo_faturamento = '';
            $num_fatura = '';
            $num_nota_fiscal = '';
            $cod_ddd = '';
            $num_telefone = '';
            $designacao = '';
            $valor_a_pagar = '';
            $nome_cidade = '';
            $tip_logradouro = '';
            $nome_logradouro = '';
            $num_imovel = '';
            $nome_bairro = '';
            $cep = '';
            $sigla_uf = '';
            $nome_cidade1 = '';
            $tip_logradouro1 = '';
            $nome_logradouro1 = '';
            $num_imovel1 = '';
            $nome_bairro1 = '';
            $cep1 = '';
            $sigla_uf1 = '';
            $prod_telefone = '';
            $velocidade_circuito = '';
            $num_pagina = '';
            $num_linha = '';
            $data_servico = '';
            $servico = '';
            $degrau = '';
            $num_tel_origem = '';
            $cod_selecao = '';
            $ddd_tel_origem = '';
            $telefone_destino = '';
            $hr_qtd_chamada = '';
            $duracao = '';
            $s = '';
            $valor_servico = '';
            $aliquota_icms = '';
            $conta = '';
            $num_detalhe = '';
            $cod_l_origem = '';
            $cod_l_destino = '';
            $vencimento = '';
            $contestar = '';
            $valor_contestar = '';
            $localidade = '';
            $tel_origem = '';
            $sigla_orgao_analise = '';
        }
    }
    $circuito->insertImportContas($sql);
    unlink($img);
}
header("Location: confirmaimport.php");