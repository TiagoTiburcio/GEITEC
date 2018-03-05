<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../class/principal.php';
$circuito = new Circuitos();
chdir( "uploads" );
$arquivos = glob("{*.txt}", GLOB_BRACE);
foreach($arquivos as $key2 => $img){  
    $sql = array(); 
    $linhas = explode("\n", file_get_contents($img));
    foreach ($linhas as $key => $value){
        $colunas = explode(";", $value);    
        if ($key == '0'){
           foreach ($colunas as $key1 => $v1){ 
               echo $key1.' : '.$v1."<br/>";
                switch ($key1) {
                case 0:
                    $site = $v1;
                    break;
                case 1:
                    $nome_cliente = $v1; 
                    break;
                case 2:
                    $finalidade = $v1;
                    break;
                case 3:
                    $contrato = $v1;
                    break;
                case 4:
                    $ciclo_faturamento = $v1;
                    break;
                case 5:
                    $num_fatura = $v1;
                    break;
                case 6:
                    $num_nota_fiscal = $v1;
                    break;
                case 7:
                    $cod_ddd = $v1;
                    break;
                case 8:
                    $num_telefone = $v1;
                    break;
                case 9:
                    $designacao = $v1;
                    break;
                case 10:
                    $valor_a_pagar = $v1;
                    break;
                case 11:
                    $nome_cidade = $v1;
                    break;
                case 12:
                    $tip_logradouro = $v1;
                    break;
                case 13:
                    $nome_logradouro = $v1;
                    break;
                case 14:
                    $num_imovel = $v1;
                    break;
                case 15:
                    $nome_bairro = $v1;
                    break;
                case 16:
                    $cep = $v1;
                    break;
                case 17:
                    $sigla_uf = $v1;
                    break;
                case 18:
                    $nome_cidade1 = $v1;
                    break;
                case 19:
                    $tip_logradouro1 = $v1;
                    break;
                case 20:
                    $nome_logradouro1 = $v1;
                    break;
                case 21:
                    $num_imovel1 = $v1;
                    break;
                case 22:
                    $nome_bairro1 = $v1;
                    break;
                case 23:
                    $cep1 = $v1;
                    break;
                case 24:
                    $sigla_uf1 = $v1;
                    break;
                case 25:
                    $prod_telefone = $v1;
                    break;
                case 26:
                    $velocidade_circuito = $v1;
                    break;
                case 27:
                    $num_pagina = $v1;
                    break;
                case 28:
                    $num_linha = $v1;
                    break;
                case 29:
                    $data_servico = $v1;
                    break;
                case 30:
                    $servico = $v1;
                    break;
                case 31:
                    $degrau = $v1;
                    break;
                case 32:
                    $num_tel_origem = $v1;
                    break;
                case 33:
                    $cod_selecao = $v1;
                    break;
                case 34:
                    $ddd_tel_origem = $v1;
                    break;
                case 35:
                    $telefone_destino = $v1;
                    break;
                case 36:
                    $hr_qtd_chamada = $v1;
                    break;
                case 37:
                    $duracao = $v1;
                    break;
                case 38:
                    $s = $v1;
                    break;
                default:                       
                }
            }
            //$sql[] = "('".$data_hora."', '".$sitename."', '".$computername."', '".$ip_srv."', '".$metodo."', '".$url_acesso."', '".$parametro_acesso."', '".$porta_acesso."', '".$usuario_logado."', '".$ip_cliente."', '".$versao_http."', '".$browser."', '".$cookie."', '".$site_encaminha."', '".$dns_acesso."', '".$status_solic."', '".$sub_status_solic."', '".$win32_status."', '".$bytes_enviados."', '".$bytes_recebidos."', '".$tempo_solic."')";
        }
    }
    //$sw->arrayLogWebIIS($sql);
    //unlink($img);
}