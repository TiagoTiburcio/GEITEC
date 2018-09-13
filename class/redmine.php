<?php

/**
 * Description of Redmine
 *
 * @author tiagoc
 */
class Redmine extends DatabaseRed {

    private $numTarefa;
    private $sitTarefa;
    private $iniTarefa;
    private $fimTarefa;
    private $login;

    function __construct() {
        
    }

    function setNumTarefa($_numTarefa) {
        $this->numTarefa = $_numTarefa;
    }

    function getNumTarefa() {
        return $this->numTarefa;
    }

    function setSitTarefa($_sitTarefa) {
        $this->sitTarefa = $_sitTarefa;
    }

    function getSitTarefa() {
        return $this->sitTarefa;
    }

    function setIniTarefa($_iniTarefa) {
        $this->iniTarefa = $_iniTarefa;
    }

    function getIniTarefa() {
        return $this->iniTarefa;
    }

    function setFimTarefa($_fimTarefa) {
        $this->fimTarefa = $_fimTarefa;
    }

    function getFimTarefa() {
        return $this->fimTarefa;
    }

    function setLogin($_login) {
        $this->login = $_login;
    }

    function getLogin() {
        return $this->login;
    }

    //retorno 0 - tarefa não cadastrado | 1 - tarefa cadastrada
    private function testeTarefa($_numTarefa) {
        $consulta_usuario1 = "SELECT count(`id`) as cont from `issues` where `id` = '$_numTarefa';";
        $resultado_usuario1 = mysqli_query($this->connectRed(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1) {
            $resultado = $table_usuario1["cont"];
        }
        return $resultado;
    }

    //retorno 
    function iniTarefaRedmine($_numTarefa) {
        $resultado = $this->testeTarefa($_numTarefa);
        if ($resultado == 1) {
            $consulta_redmine2 = "SELECT i.id ,tec.login ,i.due_date ,i.start_date ,i.status_id  from issues as i left join users as tec on i.assigned_to_id = tec.id where i.id =  '$_numTarefa';";
            $resultado_redmine2 = mysqli_query($this->connectRed(), $consulta_redmine2);
            foreach ($resultado_redmine2 as $table_redmine2) {
                $this->setNumTarefa($table_redmine2["id"]);
                $this->setSitTarefa($table_redmine2["status_id"]);
                $this->setiniTarefa($table_redmine2["start_date"]); //data formatadata yyyy-MM-dd padrão BD
                $this->setFimTarefa($table_redmine2["due_date"]); //data formatadata yyyy-MM-dd padrão BD
                $this->setLogin($table_redmine2["login"]);
            }
        }
        return $resultado;
    }

    //retorno 
    function atuTarefas($_consulta) {
        $resultado_redmine2 = mysqli_query($this->connectRed(), $_consulta);
        $resultado = array();
        $i = 0;
        foreach ($resultado_redmine2 as $table_redmine2) {
            $resultado[$i][0] = $table_redmine2["id"];
            $resultado[$i][1] = $table_redmine2["status_id"];
            $resultado[$i][2] = $table_redmine2["start_date"]; //data formatadata yyyy-MM-dd padrão BD
            $resultado[$i][3] = $table_redmine2["due_date"]; //data formatadata yyyy-MM-dd padrão BD
            $resultado[$i][4] = $table_redmine2["login"];
            $i = $i + 1;
        }
        return $resultado;
    }

    function fechaTarefa($_numTarerefa, $_status) {
        $consulta = "UPDATE `bitnami_redmine`.`issues` SET `status_id` = '$_status' WHERE `id` = '$_numTarerefa';";
        $resultado = mysqli_query($this->connectRed(), $consulta);
        return $resultado;
    }
    
    

    function __destruct() {
        
    }

}
