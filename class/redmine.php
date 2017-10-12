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
include_once '../class/databaseRed.php';
class Redmine extends databaseRed {
       
    private $numTarefa;
    
    private $sitTarefa;
    
    private $iniTarefa;
    
    private $fimTarefa;
    
    private $login;
    
    
    function __construct(){ }
    
    function setNumTarefa($_numTarefa){ $this->numTarefa = $_numTarefa;}
    
    function getNumTarefa(){ return $this->numTarefa;}
    
    function setSitTarefa($_sitTarefa){ $this->sitTarefa = $_sitTarefa; }
    
    function getSitTarefa(){ return $this->sitTarefa; }
    
    function setIniTarefa($_iniTarefa){ $this->iniTarefa = $_iniTarefa; }
    
    function getIniTarefa(){ return $this->iniTarefa; }
    
    function setFimTarefa($_fimTarefa){ $this->fimTarefa = $_fimTarefa; }
    
    function getFimTarefa(){ return $this->fimTarefa; }
    
    function setLogin($_login){ $this->login = $_login;}
    
    function getLogin(){ return $this->login;}
    
    //retorno 0 - tarefa não cadastrado | 1 - tarefa cadastrada
    private function testeTarefa($_numTarefa){
        $consulta_usuario1 = "SELECT count(`id`) as cont from `issues` where `id` = '$_numTarefa';";                                
        $resultado_usuario1 = mysqli_query($this->connectRed(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1){                        
           $resultado = $table_usuario1["cont"]; 
        } 
        return $resultado;
    }
    //retorno 
    function iniTarefaRedmine($_numTarefa){
        $resultado = $this->testeTarefa($_numTarefa);
        if ($resultado == 1){
            $consulta_redmine2 = "SELECT i.id ,tec.login ,i.due_date ,i.start_date ,i.status_id  from issues as i left join users as tec on i.assigned_to_id = tec.id where i.id =  '$_numTarefa';";
            $resultado_redmine2 = mysqli_query($this->connectRed(), $consulta_redmine2);
            foreach ($resultado_redmine2 as $table_redmine2){
                $this->setNumTarefa($table_redmine2["id"]);
                $this->setSitTarefa($table_redmine2["status_id"]);                 
                $this->setiniTarefa($table_redmine2["start_date"]); //data formatadata yyyy-MM-dd padrão BD
                $this->setFimTarefa($table_redmine2["due_date"]); //data formatadata yyyy-MM-dd padrão BD
                $this->setLogin($table_redmine2["login"]);
            }
        }
        return $resultado;
    } 
    function __destruct() {}
}
