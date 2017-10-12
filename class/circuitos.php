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
class Circuitos extends database {
    private $dre;
    
    private $cidade;
    
    private $circuito;
    
    private $localizacao;
    
    private $codUnidade;
    
    private $nomeUnidade;
    
    private $periodoRef;
    
    private $fatura;
    
    private $valor;
    
    function __construct(){ }

    function setDre($_dre){
        $this->dre = $_dre;
    }

    function getDre(){
        return $this->dre;
    }
        
    private function setCidade($_cidade){
        $this->cidade = $_cidade;
    }

    function getCidade(){
        return $this->cidade;
    }
        
    private function setCircuito($_circuito){
        $this->circuito = $_circuito;
    }

    function getCircuito(){
        return $this->circuito;
    }
    
    private function setLocalizacao($_localizacao){
        $this->localizacao = $_localizacao;
    }
            
    function getLocalizacao(){
        return $this->localizacao;
    }
    
    private function setCodUnidade($_codUnidade){
        $this->codUnidade = $_codUnidade;
    }
            
    function getCodUnidade(){
        return $this->codUnidade;
    }
    
    private function setPeriodoRef($_periodoRef){
        $this->nomeUnidade = $_periodoRef;
    }
            
    function getPeriodoRef(){
        return $this->periodoRef;
    }
    
    private function setFatura($_fatura){
        $this->fatura = $_fatura;
    }
            
    function getFatura(){
        return $this->nomeUnidade;
    }
    
    private function setNomeUnidade($_nomeUnidade){
        $this->nomeUnidade = $_nomeUnidade;
    }
            
    function getNomeUnidade(){
        return $this->nomeUnidade;
    }
    
    private function setValor($_valor){
        $this->valor = $_valor;
    }
            
    function getValor(){
        return $this->valor;
    }
          
    // retorna lista com todos os usuarios cadastrados
    function listaCircuitos($_mescad,$_fatura){        
        $consulta_circuito1 = "SELECT cp.periodo_ref,"
                             . " cp.fatura, cp.localizacao,"
                             . "CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(cp.valor_conta), 2),'.',';'),',','.'),';',',')) as valor,"
                             . "date_format(cp.periodo_ref,'%m/%Y') as mes,"
                             . " lo.descricao, co.descricao_servico"
                             . " FROM circuitos_contas"
                             . " as cp join circuitos_contrato as co on co.codigo = cp.fatura "
                             . "join circuitos_localizacao as lo on lo.id = cp.localizacao "
                             . "where"
                             . " cp.periodo_ref = '$_mescad'"
                             . " and cp.fatura like '%$_fatura%'"
                             . "GROUP BY cp.periodo_ref, cp.fatura, cp.localizacao "
                             . "ORDER BY cp.periodo_ref desc, cp.fatura ,cp.localizacao";                              
        $resultado_circuito1 = mysqli_query($this->connect(), $consulta_circuito1);
        return $resultado_circuito1;
    }
    
    function listaPeriodoRef(){        
        $consulta_circuito2 = "SELECT distinct periodo_ref, date_format(periodo_ref,'%m/%Y') as mes FROM circuitos_contas order by periodo_ref desc limit 10";
        $resultado_circuito2 = mysqli_query($this->connect(), $consulta_circuito2);
        return $resultado_circuito2;
    }
    
    function listaConsultaDetalhada($_unidade,$_fatura,$_circuito,$_diretoria,$_mescad){        
        $consulta_circuito3 = "SELECT `circuitos_contas`.`DRE`,"
                            . " `circuitos_contas`.`cidade`, `circuitos_contas`.`circuito`,"
                            . "`circuitos_contas`.`nome_unidade`, date_format(periodo_ref,'%m/%Y') as `periodo_ref`,"
                            . "`circuitos_contas`.`fatura`, "
                            . " CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(valor_conta, 2),'.',';'),',','.'),';',',')) as `valor_conta`FROM `circuitos_contas`"
                            . " where "
                            . "`circuitos_contas`.`nome_unidade` like '%$_unidade%'"
                            . " and `circuitos_contas`.`fatura` like '%$_fatura%'"
                            . " and `circuitos_contas`.`circuito` like '%$_circuito%'"
                            . " and `circuitos_contas`.`DRE` like '%$_diretoria%'"
                            . " and `circuitos_contas`.`periodo_ref` = '$_mescad'"
                            . "order by DRE, cidade, nome_unidade;";
        $resultado_circuito3 = mysqli_query($this->connect(), $consulta_circuito3);
        return $resultado_circuito3;
    }
    function __destruct() {}
}
