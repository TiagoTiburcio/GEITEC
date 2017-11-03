<?php
include_once '../class/database.php';
/**
 * Description of usuario
 *
 * @author tiagoc
 */
class Usuario extends Database {
    private $id;
    
    private $usuario;
    
    private $nome;
    
    private $senha;
    
    private $ativo;
    
    private $perfil;
    
    function __construct(){ }

    function setId($_id){
        $this->id = $_id;
    }

    function getId(){
        return $this->id;
    }
        
    private function setNome($_nome){
        $this->nome = $_nome;
    }

    function getNome(){
        return $this->nome;
    }
        
    private function setUsuario($_usuario){
        $this->usuario = $_usuario;
    }

    function getUsuario(){
        return $this->usuario;
    }
    
    private function setSenha($_senha){
        $this->senha = $_senha;
    }
            
    function getSenha(){
        return $this->senha;
    }
    
    private function getSenhaEncriptada($_senha){
        $resultado = sha1($_senha);
        return $resultado;
    }
    
    private function setAtivo($_ativo){
        $this->ativo = $_ativo;
    }
            
    function getAtivo(){
        return $this->ativo;
    }
    
    private function setPerfil($_perfil){
        $this->perfil = $_perfil;
    }
            
    function getPerfil(){
        return $this->perfil;
    }
    
    // 0 - usuario não gravado 1 - usuario existente na Base de Dados
    private function testeUsuarioCadatrado($_usuario){
        $consulta_usuario1 = "SELECT count(`usuario`.`id`) as cont FROM `usuario` where usuario = '$_usuario';";                                
        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1){                        
           $resultado = $table_usuario1["cont"]; 
        } 
        return $resultado;
    }
    
    // 0 - usuario não gravado 1 - usuario gravado com sucesso na Base de Dados
    function insereUsuario($_usuario,$_nome,$_senha){
        $resultado = '0';
        if($this->testeUsuarioCadatrado($_usuario) == 0){            
            $this->setNome($_nome);
            $this->setUsuario($_usuario);
            $this->setSenha($this->getSenhaEncriptada($_senha));
            $this->setAtivo(1);
            $this->setPerfil(0);
            $consulta_usuario2 = "INSERT INTO `usuario`(`usuario`,`senha`,`nome_usuario`,`ativo`,`perfil`)VALUES( '".$this->getUsuario()."' , '".$this->getSenha()."' , '".$this->getNome()."' ,".$this->getAtivo().",".$this->getPerfil().");";
            $resultado_usuario2 = mysqli_query($this->connect(), $consulta_usuario2);            
            $resultado = '1';
        }        
        return $resultado;
    }
   
    // retorna lista com todos os usuarios cadastrados
    function listaUsuarios(){        
        $consulta_usuario3 = "SELECT * FROM usuario;";                                
        $resultado_usuario3 = mysqli_query($this->connect(), $consulta_usuario3);
        return $resultado_usuario3;
    }
    
    // retorno = 1 - usuario cadastrado 0 - usuario não cadastrado
    function iniUsuario($_usuario){
        if ($this->testeUsuarioCadatrado($_usuario) == 1){
            $consulta_usuario4 = "SELECT * FROM usuario where usuario = '$_usuario';";                                
            $resultado_usuario4 = mysqli_query($this->connect(), $consulta_usuario4);
            foreach ($resultado_usuario4 as $table_usuario4){
                $this->setId($table_usuario4["id"]);
                $this->setUsuario( $table_usuario4["usuario"]);
                $this->setNome($table_usuario4["nome_usuario"]);
                $this->setSenha($table_usuario4["senha"]);
                $this->setAtivo($table_usuario4["ativo"]);
                $this->setPerfil($table_usuario4["perfil"]);
            }            
        }
        return $this->testeUsuarioCadatrado($_usuario);
    }       
    
    //Retorno == 0 - erro gravar nova senha na base de dados | == 1 - nova senha gravada com sucesso
    function gravaNovaSenha($_usuario,$_novaSenha){        
        if ($this->iniUsuario($_usuario) == 1){            
            $consulta_usuario5 = "UPDATE `usuario` SET `senha` = '".$this->getSenhaEncriptada($_novaSenha)."' WHERE `id` = '".$this->getId()."';";                                
            $resultado_usuario5 = mysqli_query($this->connect(), $consulta_usuario5);
        }
        return $this->iniUsuario($_usuario);
    }

    //Retorno == 0 - erro gravar nova senha na base de dados | == 1 - nova senha gravada com sucesso
    function verificaUsuario($_usuario,$_senha){        
        $resultado = 0;
        if ($this->iniUsuario($_usuario) == 1){            
            if($this->getSenhaEncriptada($_senha) == $this->getSenha()){
                $resultado = 1;
            }            
        }
        return $resultado;
    }
    
     // 0 - usuario não gravado 1 - usuario gravado com sucesso na Base de Dados
    function editUsuario($_usuario,$_nome,$_senha){
        $resultado = '0';
        if($this->testeUsuarioCadatrado($_usuario) == 1){            
            $this->iniUsuario($_usuario);
            $this->setNome($_nome);
            $this->setUsuario($_usuario);
            $this->setSenha($this->getSenhaEncriptada($_senha));
            $this->setAtivo(1);
            $this->setPerfil(0);                        
            $consulta_usuario6 = "UPDATE `usuario` SET `usuario` = '".$this->getUsuario()."' , `senha` = '".$this->getSenha()."' , `nome_usuario` = '".$this->getNome()."' ,`ativo` = ".$this->getAtivo()." , `perfil` = ".$this->getPerfil()." WHERE `id` = ".$this->getId().";";
            $resultado_usuario6 = mysqli_query($this->connect(), $consulta_usuario6);            
            $resultado = '1';
        }        
        return $resultado;
    }
    

    function validaSessao(){        
        session_start();
        include ("../class/header.php");

        //Caso o usuário não esteja autenticado, limpa os dados e redireciona
        if ( !isset($_SESSION['login']) and !isset($_SESSION['pass']) ) {
            //Destrói
            session_destroy();

            //Limpa
            unset ($_SESSION['login']);
            unset ($_SESSION['pass']);
            unset ($_SESSION['nome_usuario']);

            //Redireciona para a página de autenticação
            echo '<META http-equiv="refresh" content="0;../home/login.php">';
        }        
    }
    
    function __destruct() {}
}

/**
 * Description of Servidores
 *
 * @author tiagoc
 */
class Servidores extends Database {
       
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


/**
 * Description of Circuitos
 *
 * @author tiagoc
 */
class Circuitos extends Database {
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

/**
 * Description of usuario
 *
 * @author tiagoc
 */
class Servicos extends Database {
       
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


