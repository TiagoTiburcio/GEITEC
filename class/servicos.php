<?php

/**
 * Description of usuario
 *
 * @author tiagoc
 */
include_once '../class/database.php';
include_once '../class/redmine.php';
class Servicos extends database {
       
    private $evento;
    
    private $tarefaRedmine;
    
    private $situacaoEvento;
    
    private $codSitEvento;
    
    private $descRes;
    
    private $descComp; 
    
    private $inicioEvento;
    
    private $fimEvento;
    
    private $dtLimiteInicio;
    
    private $dtLimiteFim;
    
    private $corEvento;
     
    private $corTextoEvento;
    
    private $eventoAnt;
            
    function __construct(){ }
    
    function setEvento($_evento){ $this->evento = $_evento;}
    
    function getEvento(){return $this->evento;}
    
    function setEventoAnt($_eventoAnt){ $this->eventoAnt = $_eventoAnt;}
    
    function getEventoAnt(){return $this->eventoAnt;}
    
    function getTarefaRedmine(){return $this->tarefaRedmine;}
    
    function setTarefaRedmine($_numTarefaRedmine){ 
        $this->tarefaRedmine = new Redmine();
        $this->tarefaRedmine->iniTarefaRedmine($_numTarefaRedmine);
    }
    
    function setSituacaoEvento($_situacaoEvento){ $this->situacaoEvento = $_situacaoEvento;}
    
    function getLimiteInicio(){ return $this->dtLimiteInicio;}
    
    function setLimiteInicio($_limiteInicio){ $this->dtLimiteInicio = $_limiteInicio;}
    
    function getLimiteFim(){ return $this->dtLimiteFim;}
    
    function setLimiteFim($_limiteFim){ $this->dtLimiteFim = $_limiteFim;}
    
    function getCodSitEvento(){ return $this->codSitEvento;}
    
    function setCodSitEvento($_codSitEvento){ $this->codSitEvento = $_codSitEvento;}
    
    function getSituacaoEvento(){ return $this->situacaoEvento;}
    
    function setDescRes($_descRes){ $this->descRes = $_descRes;}
    
    function getDescRes(){ return $this->descRes;}
    
    function setDescComp($_descComp){$this->descComp = $_descComp;}
    
    function getDescComp(){return $this->descComp;}
    
    function setInicioEvento($_inicioEvento){$this->inicioEvento = $_inicioEvento;}
    
    function getInicioEvento(){return $this->inicioEvento;}
    
    function setFimEvento($_fimEvento){$this->fimEvento = $_fimEvento;}
    
    function getFimEvento(){return $this->fimEvento;}
    
    function setCorEvento($_corEvento){ $this->corEvento = $_corEvento;}
    
    function getCorEvento(){return $this->corEvento;}
    
    function setCorTextoEvento($_corTextoEvento){ $this->corTextoEvento = $_corTextoEvento;}
    
    function getCorTextoEvento(){return $this->corTextoEvento;}
                
    //    Y | Ano //    M | Mês //    D | Dias //    W | Semanas //    H | Horas //    M | Minutos //    S | Segundos  
    function calculaDataRepeticao($_dataInicio,$_repeticao){
        $data = DateTime::createFromFormat('Y-m-d', $_dataInicio);
            if($_repeticao == 'D'){
                $data->add(new DateInterval('P1D'));
            }elseif ($_repeticao == 'S') {
                $data->add(new DateInterval('P1W'));
            }elseif ($_repeticao == 'M') {
                $data->add(new DateInterval('P1M'));
            }elseif ($_repeticao == 'T') {
                $data->add(new DateInterval('P3M'));
            }
        return $data->format('Y-m-d');    
    }
    
    // retorno = 0 - Evento não cadastrado | 1 - Evento cadastrado
    private function testeEventoCadastrado($_evento){
        $consulta_servicos2 = "SELECT count(`id`) as cont FROM `servicos_eventos` where `id` = '$_evento';";                                
        $resultado_servicos2 = mysqli_query($this->connect(), $consulta_servicos2);
        foreach ($resultado_servicos2 as $table_servicos2){
           $resultado = $table_servicos2["cont"]; 
        } 
        return $resultado;
    }
    
    // retorno = 0 - Evento Atrasado | 1 - Evento Normal
    function testeEventoVencido(){
        $retorno = "0";
        $dataHOJE = date('Y-m-d');
        if (   $this->getLimiteInicio() != "" 
            && $this->getInicioEvento() != "" 
            && $this->getLimiteFim() != "" 
            && $this->getFimEvento() != ""){ 
            if ($this->getLimiteInicio() <= $this->getTarefaRedmine()->getIniTarefa() 
                    && $this->getLimiteFim() >= $this->getTarefaRedmine()->getFimTarefa()){
                    $retorno = "1";                
            }            
        }
        return $retorno;
    }
    
    function testeEventoAnteriorVencido(){
        
    }       
          
    function iniEvento($_evento){        
        if($this->testeEventoCadastrado($_evento) == '1'){
            $consulta_servicos1 = " SELECT t.`cod_tarefa_redmine` ,c.`nome_redu_servico` ,c.`descricao_tipo_servico`,e.`start`as 'inicio_evento' ,e.`end` as 'fim_evento' "
                    . ",t.`id_evento_anterior` ,t.`inicio_tarefa_padrao` ,t.`fim_tarefa_padrao` ,st.`codigo` as 'cod_sit' ,st.`descricao` as 'descricao_situacao_tarefa' FROM `servicos_tarefas` as t inner join `servicos_sit_tarefa` as st on t.`situacao` = st.`codigo` inner join `servicos_cadastro` as c on t.`codigo_sevico` = c.`codigo_servico` "
                    . " inner join `servicos_eventos` as e on t.`id_evento` = e.`id` where t.`codigo_tarefa` = '$_evento'; ";
            $resultado_servicos1 = mysqli_query($this->connect(), $consulta_servicos1);
            foreach ($resultado_servicos1 as $table_servicos1){                        
                $this->setTarefaRedmine($table_servicos1["cod_tarefa_redmine"]);
                $this->setSituacaoEvento($table_servicos1["descricao_situacao_tarefa"]);
                $this->setDescRes($table_servicos1["nome_redu_servico"]);
                $this->setDescComp($table_servicos1["descricao_tipo_servico"]);
                $this->setInicioEvento($table_servicos1["inicio_evento"]);
                $this->setFimEvento($table_servicos1["fim_evento"]);
                $this->setLimiteInicio($table_servicos1["inicio_tarefa_padrao"]);
                $this->setLimiteFim($table_servicos1["fim_tarefa_padrao"]);
                $this->setEventoAnt($table_servicos1["id_evento_anterior"]);
                if ($table_servicos1["cod_sit"] != '99') {                    
                    $this->iniSituacaoEvento($this->getTarefaRedmine()->getSitTarefa());
                } else {                    
                    $this->iniSituacaoEvento($table_servicos1["cod_sit"]);                    
                }            
            }
            $this->setEvento($_evento);
            
        }
        return $this->testeEventoCadastrado($_evento);
    }        
       
    function iniSituacaoEvento($_codSit){
        $consulta_servicos3 = "SELECT * FROM servicos_sit_tarefa where codigo = '$_codSit';";      
        $resultado_servicos3 = mysqli_query($this->connect(), $consulta_servicos3);
        foreach ($resultado_servicos3 as $table_servicos3){
            $this->setCodSitEvento($table_servicos3["codigo"]);
            $this->setSituacaoEvento($table_servicos3["descricao"]);
            $this->setCorEvento($table_servicos3["cor"]);
            $this->setCorTextoEvento($table_servicos3["cor_texto"]);            
        }   
    }
        
    function iniTarefaHoje(){
        $consulta_servicos6 = "select codigo_servico, repeticao, concat(nome_redu_servico,' - ',repeticao) as title, date_format(now(), '%Y-%m-%d') as start, '0' as cod_situacao_tarefa from servicos_cadastro as s where data_prox_exec = date_format(now(), '%Y-%m-%d');";      
        $resultado_servicos6 = mysqli_query($this->connect(), $consulta_servicos6);
        foreach ($resultado_servicos6 as $table_servicos6){            
            $valor = $this->consultaIdUltimaTarefa() + 1;           
            $data_fim = $this->calculaDataRepeticao($table_servicos6["start"], $table_servicos6["repeticao"]);
            $url = "edittarefa.php?evento=$valor";            
            $this->inserirNovoEvento($valor, $table_servicos6["title"], $table_servicos6["start"], $data_fim, $url, $table_servicos6["codigo_servico"], $table_servicos6["cod_situacao_tarefa"]);
        }
        return count($table_servicos6);        
    }
    
    function iniTarefas($_data){
        $consulta_servicos6 = "select codigo_servico, repeticao, concat(nome_redu_servico,' - ',repeticao) as title, date_format(now(), '%Y-%m-%d') as start, '0' as cod_situacao_tarefa from servicos_cadastro as s where data_prox_exec = '$_data';";      
        $resultado_servicos6 = mysqli_query($this->connect(), $consulta_servicos6);
        foreach ($resultado_servicos6 as $table_servicos6){            
            $valor = $this->consultaIdUltimaTarefa() + 1;           
            $data_fim = $this->calculaDataRepeticao($table_servicos6["start"], $table_servicos6["repeticao"]);
            $url = "edittarefa.php?evento=$valor";            
            $this->inserirNovoEvento($valor, $table_servicos6["title"], $table_servicos6["start"], $data_fim, $url, $table_servicos6["codigo_servico"], $table_servicos6["cod_situacao_tarefa"]);
        }
        return count($table_servicos6);        
    }
    
    function consultaIdUltimaTarefa(){
        $consulta_servicos7 = "SELECT max(codigo_tarefa) as ult_tarefa_criada FROM sis_geitec.servicos_tarefas;";      
        $resultado_servicos7 = mysqli_query($this->connect(), $consulta_servicos7);
        foreach ($resultado_servicos7 as $table_servicos7){
            $resultado = $table_servicos7["ult_tarefa_criada"];
        }
        return $resultado;
    }
    
    function consultaUltimaTarefaServico($_codigoServico){
        $consulta_servicos11 = "SELECT id_ultimo_evento FROM sis_geitec.servicos_cadastro where codigo_servico = '$_codigoServico';";      
        $resultado_servicos11 = mysqli_query($this->connect(), $consulta_servicos11);
        foreach ($resultado_servicos11 as $table_servicos11){
            $resultado = $table_servicos11["id_ultimo_evento"];
        }
        return $resultado;
    }
        
    private function inserirNovoEvento($_numTarefa,$_tituloEvento,$_dataInicio,$_dataFim,$_url,$_codigoServico,$_codSitTarefa){
        $ultimaTarefaServico = $this->consultaUltimaTarefaServico($_codigoServico);
        $consulta_servicos7 = "INSERT INTO `servicos_eventos` (`id`,`title`,`start`,`end`,`url`) VALUES ('$_numTarefa','$_tituloEvento','$_dataInicio','$_dataFim','$_url');";      
        $resultado_servicos7= mysqli_query($this->connect(), $consulta_servicos7);
        $consulta_servicos8 = "INSERT INTO `servicos_tarefas` (`codigo_tarefa`,`id_evento`,`codigo_sevico`,`situacao`,`inicio_tarefa_padrao`,`fim_tarefa_padrao`,`id_evento_anterior`) VALUES ('$_numTarefa', '$_numTarefa','$_codigoServico','$_codSitTarefa','$_dataInicio','$_dataFim','$ultimaTarefaServico');";
        $resultado_servicos8 = mysqli_query($this->connect(), $consulta_servicos8);
        $consulta_servicos9 = "UPDATE `servicos_cadastro` SET `data_prox_exec` = '$_dataFim', `data_ult_criacao` = '$_dataInicio', `id_ultimo_evento` = '$_numTarefa'  WHERE `codigo_servico` = '$_codigoServico';";
        $resultado_servicos9 = mysqli_query($this->connect(), $consulta_servicos9);                
    }
                    
    function atualizaAutomaticoTarefasRedmine(){
        $consulta_servicos10 = "SELECT * FROM servicos_eventos as s inner join servicos_tarefas as t on t.codigo_tarefa = s.id where t.cod_tarefa_redmine is not null;";      
        $resultado_servicos10 = mysqli_query($this->connect(), $consulta_servicos10);
        foreach ($resultado_servicos10 as $table_servicos10){
            $this->iniEvento($table_servicos10["id"]);
            $this->atualizaTarefaRedimine();            
            if ($this->testeEventoVencido() != "1") {
                
                $this->iniSituacaoEvento("99");
                $this->setInicioEvento($this->getLimiteInicio());
                $this->setFimEvento($this->getLimiteFim());
            }
            $this->atualizaEventoBD();
        }
    }
    
    function atualizaTarefaRedimine(){        
        $this->iniSituacaoEvento($this->getTarefaRedmine()->getSitTarefa());
        $this->setInicioEvento($this->getTarefaRedmine()->getIniTarefa());
        $this->setFimEvento($this->getTarefaRedmine()->getFimTarefa());                  
    }
            
    function atualizaEventoBD(){
        $retorno = 0; 
        if ($this->testeEventoCadastrado($this->getEvento()) == "1" && $this->testeEventoVencido() == "1"){            
            $consulta_servicos14 = "UPDATE `servicos_tarefas` SET `cod_tarefa_redmine` = '".$this->getTarefaRedmine()->getNumTarefa()."', `situacao` = '".$this->getCodSitEvento()."' WHERE `codigo_tarefa` = '".$this->getEvento()."';";
            $resultado_servicos14 = mysqli_query($this->connect(), $consulta_servicos14);
            $consulta_servicos15 = "UPDATE `servicos_eventos` SET `start` = '".$this->getInicioEvento()."', `end` = '".$this->getFimEvento()."', `color` = '".$this->getCorEvento()."', `textColor` = '".$this->getCorTextoEvento()."' WHERE `id` = '".$this->getEvento()."';";
            $resultado_servicos15 = mysqli_query($this->connect(), $consulta_servicos15);
            $retorno = 1; 
        }
        return $retorno;
    }
    
    function formataDataBR($_data){
       return date('d/m/Y',strtotime($_data));
    }
    
    function __destruct() {}
    
}
