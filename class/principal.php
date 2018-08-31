<?php

include_once '../class/database.php';
include_once '../class/padrao.php';
include_once '../class/redelocal.php';
include_once '../class/servidor.php';
include_once '../class/circuito.php';

/**
 * Description of usuario
 *
 * @author tiagoc
 */
class Usuario extends Database {

    private $codigo;
    private $usuario;
    private $nome;
    private $senha;
    private $ativo;
    private $perfil;
    private $altProxLogin;

    function __construct() {
        
    }

    function setCodigo($_codigo) {
        $this->codigo = $_codigo;
    }

    function getCodigo() {
        return $this->codigo;
    }

    private function setNome($_nome) {
        $this->nome = $_nome;
    }

    function getNome() {
        return $this->nome;
    }

    private function setUsuario($_usuario) {
        $this->usuario = $_usuario;
    }

    function getUsuario() {
        return $this->usuario;
    }

    private function setSenha($_senha) {
        $this->senha = $_senha;
    }

    function getSenha() {
        return $this->senha;
    }

    function getSenhaEncriptada($_senha) {
        $resultado = sha1($_senha);
        return $resultado;
    }

    private function setAtivo($_ativo) {
        $this->ativo = $_ativo;
    }

    function getAtivo() {
        return $this->ativo;
    }

    private function setPerfil($_perfil) {
        $this->perfil = $_perfil;
    }

    function getPerfil() {
        return $this->perfil;
    }

    private function setAltProxLogin($_altProxLogin) {
        $this->altProxLogin = $_altProxLogin;
    }

    function getAltProxLogin() {
        return $this->altProxLogin;
    }

    // 0 - usuario não gravado 1 - usuario existente na Base de Dados
    private function testeUsuarioCadatrado($_usuario) {
        $consulta_usuario1 = "SELECT count(`codigo`) as cont FROM `home_usuario` where usuario = '$_usuario';";
        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1) {
            $resultado = $table_usuario1["cont"];
        }
        return $resultado;
    }

    private function idUsuario($_usuario) {
        $consulta_usuario1 = "SELECT `codigo` FROM `home_usuario` where usuario = '$_usuario';";
        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1) {
            $resultado = $table_usuario1["codigo"];
        }
        return $resultado;
    }

    // 0 - Usuário Novo 1 - Editou Usuário
    function manutUsuario($_usuario, $_nome, $_senhaBranco, $_ativo, $_perfil, $_altProxLogin, $_usuarioAlt, $_dataAlt) {
        $resultado = $this->testeUsuarioCadatrado($_usuario);
        if ($resultado == 0) {
            $consulta_manutUsuario = " INSERT INTO `home_usuario`(`usuario`,`senha`,`nome`,`ativo`,`codigo_perfil`,`altera_senha_login`,`usuario_edit`,`data_edit`) "
                    . " VALUES('" . $_usuario . "' , '" . $this->getSenhaEncriptada($_senhaBranco) . "' , '" . $_nome . "' ,'" . $_ativo . "','" . $_perfil . "','" . $_altProxLogin . "','" . $_usuarioAlt . "','" . $_dataAlt . "'); ";

            $resultado_manutUsuario = mysqli_query($this->connect(), $consulta_manutUsuario);
        } else {
            $consulta_manutUsuario = "UPDATE `home_usuario` SET `usuario` = '" . $_usuario . "' , "
                    . "`senha` = '" . $this->getSenhaEncriptada($_senhaBranco) . "' , `nome` = '" . $_nome . "' "
                    . ",`ativo` = '" . $_ativo . "',`altera_senha_login` = '" . $_altProxLogin . "', `usuario_edit` = '" . $_usuarioAlt . "',"
                    . " `data_edit` = '" . $_dataAlt . "', `codigo_perfil` = '" . $_perfil . "' WHERE `codigo` = '" . $this->idUsuario($_usuario) . "';";
            $resultado_manutUsuario = mysqli_query($this->connect(), $consulta_manutUsuario);
        }
        return $resultado;
    }

    // retorna lista com todos os usuarios cadastrados
    function listaUsuarios($_codigo, $_nome, $_login) {
        $consulta_listaUsuarios = "SELECT u.*, p.descricao as descricao_perfil FROM home_usuario as u join home_perfil as p on p.codigo = u.codigo_perfil"
                . " where u.codigo like '%$_codigo%' and u.usuario like '%$_nome%' and nome like '%$_login%';";
        $resultado_listaUsuarios = mysqli_query($this->connect(), $consulta_listaUsuarios);
        return $resultado_listaUsuarios;
    }

    function listaPerfil() {
        $consulta_listaPerfil = "SELECT * FROM homo_sis_geitec.home_perfil where ativo = '1';";
        $resultado_listaPerfil = mysqli_query($this->connect(), $consulta_listaPerfil);
        return $resultado_listaPerfil;
    }

    // retorno = 1 - usuario cadastrado 0 - usuario não cadastrado
    function iniUsuario($_usuario) {
        $retorno = $this->testeUsuarioCadatrado($_usuario);
        if ($retorno == 1) {
            $consulta_iniUsuario = "SELECT * FROM home_usuario where usuario = '$_usuario';";
            $resultado_iniUsuario = mysqli_query($this->connect(), $consulta_iniUsuario);
            foreach ($resultado_iniUsuario as $table_iniUsuario) {
                $this->setCodigo($table_iniUsuario["codigo"]);
                $this->setUsuario($table_iniUsuario["usuario"]);
                $this->setNome($table_iniUsuario["nome"]);
                $this->setSenha($table_iniUsuario["senha"]);
                $this->setAtivo($table_iniUsuario["ativo"]);
                $this->setPerfil($table_iniUsuario["codigo_perfil"]);
                $this->setAltProxLogin($table_iniUsuario["altera_senha_login"]);
            }
        }
        return $retorno;
    }

    function __destruct() {
        
    }

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

    function __destruct() {
        
    }

}

/**
 * Description of servicos
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

    function __construct() {
        
    }

    function setEvento($_evento) {
        $this->evento = $_evento;
    }

    function getEvento() {
        return $this->evento;
    }

    function setEventoAnt($_eventoAnt) {
        $this->eventoAnt = $_eventoAnt;
    }

    function getEventoAnt() {
        return $this->eventoAnt;
    }

    function getTarefaRedmine() {
        return $this->tarefaRedmine;
    }

    function setTarefaRedmine($_numTarefaRedmine) {
        $this->tarefaRedmine = new Redmine();
        $this->tarefaRedmine->iniTarefaRedmine($_numTarefaRedmine);
    }

    function setSituacaoEvento($_situacaoEvento) {
        $this->situacaoEvento = $_situacaoEvento;
    }

    function getLimiteInicio() {
        return $this->dtLimiteInicio;
    }

    function setLimiteInicio($_limiteInicio) {
        $this->dtLimiteInicio = $_limiteInicio;
    }

    function getLimiteFim() {
        return $this->dtLimiteFim;
    }

    function setLimiteFim($_limiteFim) {
        $this->dtLimiteFim = $_limiteFim;
    }

    function getCodSitEvento() {
        return $this->codSitEvento;
    }

    function setCodSitEvento($_codSitEvento) {
        $this->codSitEvento = $_codSitEvento;
    }

    function getSituacaoEvento() {
        return $this->situacaoEvento;
    }

    function setDescRes($_descRes) {
        $this->descRes = $_descRes;
    }

    function getDescRes() {
        return $this->descRes;
    }

    function setDescComp($_descComp) {
        $this->descComp = $_descComp;
    }

    function getDescComp() {
        return $this->descComp;
    }

    function setInicioEvento($_inicioEvento) {
        $this->inicioEvento = $_inicioEvento;
    }

    function getInicioEvento() {
        return $this->inicioEvento;
    }

    function setFimEvento($_fimEvento) {
        $this->fimEvento = $_fimEvento;
    }

    function getFimEvento() {
        return $this->fimEvento;
    }

    function setCorEvento($_corEvento) {
        $this->corEvento = $_corEvento;
    }

    function getCorEvento() {
        return $this->corEvento;
    }

    function setCorTextoEvento($_corTextoEvento) {
        $this->corTextoEvento = $_corTextoEvento;
    }

    function getCorTextoEvento() {
        return $this->corTextoEvento;
    }

    //    Y | Ano //    M | Mês //    D | Dias //    W | Semanas //    H | Horas //    M | Minutos //    S | Segundos  
    function calculaDataRepeticao($_dataInicio, $_repeticao) {
        $data = DateTime::createFromFormat('Y-m-d', $_dataInicio);
        if ($_repeticao == 'D') {
            $data->add(new DateInterval('P1D'));
        } elseif ($_repeticao == 'S') {
            $data->add(new DateInterval('P1W'));
        } elseif ($_repeticao == 'M') {
            $data->add(new DateInterval('P1M'));
        } elseif ($_repeticao == 'T') {
            $data->add(new DateInterval('P3M'));
        }
        return $data->format('Y-m-d');
    }

    // retorno = 0 - Evento não cadastrado | 1 - Evento cadastrado
    private function testeEventoCadastrado($_evento) {
        $consulta_servicos2 = "SELECT count(`id`) as cont FROM `servicos_eventos` where `id` = '$_evento';";
        $resultado_servicos2 = mysqli_query($this->connect(), $consulta_servicos2);
        foreach ($resultado_servicos2 as $table_servicos2) {
            $resultado = $table_servicos2["cont"];
        }
        return $resultado;
    }

    // retorno = 0 - Evento Atrasado | 1 - Evento Normal
    function testeEventoVencido() {
        $retorno = "0";
        $dataHOJE = date('Y-m-d');
        if ($this->getLimiteInicio() != "" && $this->getInicioEvento() != "" && $this->getLimiteFim() != "" && $this->getFimEvento() != "") {
            if ($this->getLimiteInicio() <= $this->getTarefaRedmine()->getIniTarefa() && $this->getLimiteFim() >= $this->getTarefaRedmine()->getFimTarefa()) {
                $retorno = "1";
            }
        }
        return $retorno;
    }

    function testeEventoAnteriorVencido() {
        
    }

    function iniEvento($_evento) {
        if ($this->testeEventoCadastrado($_evento) == '1') {
            $consulta_servicos1 = " SELECT t.`cod_tarefa_redmine` ,c.`nome_redu_servico` ,c.`descricao_tipo_servico`,e.`start`as 'inicio_evento' ,e.`end` as 'fim_evento' "
                    . ",t.`id_evento_anterior` ,t.`inicio_tarefa_padrao` ,t.`fim_tarefa_padrao` ,st.`codigo` as 'cod_sit' ,st.`descricao` as 'descricao_situacao_tarefa' FROM `servicos_tarefas` as t inner join `servicos_sit_tarefa` as st on t.`situacao` = st.`codigo` inner join `servicos_cadastro` as c on t.`codigo_sevico` = c.`codigo_servico` "
                    . " inner join `servicos_eventos` as e on t.`id_evento` = e.`id` where t.`codigo_tarefa` = '$_evento'; ";
            $resultado_servicos1 = mysqli_query($this->connect(), $consulta_servicos1);
            foreach ($resultado_servicos1 as $table_servicos1) {
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

    function iniSituacaoEvento($_codSit) {
        $consulta_servicos3 = "SELECT * FROM servicos_sit_tarefa where codigo = '$_codSit';";
        $resultado_servicos3 = mysqli_query($this->connect(), $consulta_servicos3);
        foreach ($resultado_servicos3 as $table_servicos3) {
            $this->setCodSitEvento($table_servicos3["codigo"]);
            $this->setSituacaoEvento($table_servicos3["descricao"]);
            $this->setCorEvento($table_servicos3["cor"]);
            $this->setCorTextoEvento($table_servicos3["cor_texto"]);
        }
    }

    function iniTarefaHoje() {
        $consulta_servicos6 = "select codigo_servico, repeticao, concat(nome_redu_servico,' - ',repeticao) as title, date_format(now(), '%Y-%m-%d') as start, '0' as cod_situacao_tarefa from servicos_cadastro as s where data_prox_exec = date_format(now(), '%Y-%m-%d');";
        $resultado_servicos6 = mysqli_query($this->connect(), $consulta_servicos6);
        foreach ($resultado_servicos6 as $table_servicos6) {
            $valor = $this->consultaIdUltimaTarefa() + 1;
            $data_fim = $this->calculaDataRepeticao($table_servicos6["start"], $table_servicos6["repeticao"]);
            $url = "edittarefa.php?evento=$valor";
            $this->inserirNovoEvento($valor, $table_servicos6["title"], $table_servicos6["start"], $data_fim, $url, $table_servicos6["codigo_servico"], $table_servicos6["cod_situacao_tarefa"]);
        }
        return count($resultado_servicos6);
    }

    function testeTelaCentralArquivos($_codigo) {
        $consulta_testeTelaCentralArquivos = "SELECT count(`servicos_valida`.`codigo`) as cont , `servicos_valida`.`codigo` ,  `servicos_valida`.`resultado` FROM `servicos_valida` where `servicos_valida`.`codigo` = '$_codigo';";
        $resultado_testeTelaCentralArquivos = mysqli_query($this->connect(), $consulta_testeTelaCentralArquivos);
        foreach ($resultado_testeTelaCentralArquivos as $table_testeTelaCentralArquivos) {
            if ($table_testeTelaCentralArquivos['cont'] == '1') {
                $resultado = $table_testeTelaCentralArquivos['resultado'];
            }
        }
        return $resultado;
    }

    function editTelaCentralArquivos($_codigo, $_resultado) {
        $consulta_testeTelaCentralArquivos = " UPDATE `servicos_valida` SET `resultado` = '$_resultado' WHERE `codigo` = '$_codigo'; ";
        $resultado_testeTelaCentralArquivos = mysqli_query($this->connect(), $consulta_testeTelaCentralArquivos);
        return $resultado_testeTelaCentralArquivos;
    }

    function iniTarefas($_data) {
        $consulta_servicos6 = "select codigo_servico, repeticao, concat(nome_redu_servico,' - ',repeticao) as title, date_format(now(), '%Y-%m-%d') as start, '0' as cod_situacao_tarefa from servicos_cadastro as s where data_prox_exec = '$_data';";
        $resultado_servicos6 = mysqli_query($this->connect(), $consulta_servicos6);
        foreach ($resultado_servicos6 as $table_servicos6) {
            $valor = $this->consultaIdUltimaTarefa() + 1;
            $data_fim = $this->calculaDataRepeticao($table_servicos6["start"], $table_servicos6["repeticao"]);
            $url = "edittarefa.php?evento=$valor";
            $this->inserirNovoEvento($valor, $table_servicos6["title"], $table_servicos6["start"], $data_fim, $url, $table_servicos6["codigo_servico"], $table_servicos6["cod_situacao_tarefa"]);
        }
        return count($table_servicos6);
    }

    function consultaIdUltimaTarefa() {
        $consulta_servicos7 = "SELECT max(codigo_tarefa) as ult_tarefa_criada FROM sis_geitec.servicos_tarefas;";
        $resultado_servicos7 = mysqli_query($this->connect(), $consulta_servicos7);
        foreach ($resultado_servicos7 as $table_servicos7) {
            $resultado = $table_servicos7["ult_tarefa_criada"];
        }
        return $resultado;
    }

    function consultaUltimaTarefaServico($_codigoServico) {
        $consulta_servicos11 = "SELECT id_ultimo_evento FROM sis_geitec.servicos_cadastro where codigo_servico = '$_codigoServico';";
        $resultado_servicos11 = mysqli_query($this->connect(), $consulta_servicos11);
        foreach ($resultado_servicos11 as $table_servicos11) {
            $resultado = $table_servicos11["id_ultimo_evento"];
        }
        return $resultado;
    }

    private function inserirNovoEvento($_numTarefa, $_tituloEvento, $_dataInicio, $_dataFim, $_url, $_codigoServico, $_codSitTarefa) {
        $ultimaTarefaServico = $this->consultaUltimaTarefaServico($_codigoServico);
        $consulta_servicos7 = "INSERT INTO `servicos_eventos` (`id`,`title`,`start`,`end`,`url`) VALUES ('$_numTarefa','$_tituloEvento','$_dataInicio','$_dataFim','$_url');";
        $resultado_servicos7 = mysqli_query($this->connect(), $consulta_servicos7);
        $consulta_servicos8 = "INSERT INTO `servicos_tarefas` (`codigo_tarefa`,`id_evento`,`codigo_sevico`,`situacao`,`inicio_tarefa_padrao`,`fim_tarefa_padrao`,`id_evento_anterior`) VALUES ('$_numTarefa', '$_numTarefa','$_codigoServico','$_codSitTarefa','$_dataInicio','$_dataFim','$ultimaTarefaServico');";
        $resultado_servicos8 = mysqli_query($this->connect(), $consulta_servicos8);
        $consulta_servicos9 = "UPDATE `servicos_cadastro` SET `data_prox_exec` = '$_dataFim', `data_ult_criacao` = '$_dataInicio', `id_ultimo_evento` = '$_numTarefa'  WHERE `codigo_servico` = '$_codigoServico';";
        $resultado_servicos9 = mysqli_query($this->connect(), $consulta_servicos9);
    }

    function atuAutoRed($_qtdTarefas) {
        $this->iniEvento(1);
        $tarefa = array();
        $i = 0;
        $consulta_atuAutoRed = "SELECT s.id, t.cod_tarefa_redmine, c.nome_redu_servico, c.repeticao  FROM servicos_eventos as s inner join servicos_tarefas as t on t.codigo_tarefa = s.id inner join servicos_cadastro as c on c.codigo_servico = t.codigo_sevico where t.cod_tarefa_redmine is not null order by id desc limit $_qtdTarefas;";
        $resultado_atuAutoRed = mysqli_query($this->connect(), $consulta_atuAutoRed);
        foreach ($resultado_atuAutoRed as $table_atuAutoRed) {
            $tarefa[$i][0] = $table_atuAutoRed["id"];
            $tarefa[$i][1] = $table_atuAutoRed["cod_tarefa_redmine"];
            $tarefa[$i][2] = $table_atuAutoRed["nome_redu_servico"];
            $tarefa[$i][3] = $table_atuAutoRed["repeticao"];
            $i = $i + 1;
        }
        $i = 0;
        while (count($tarefa) > $i) {
            if ($i != 0) {
                $consulta = $consulta . ",";
            } else {
                $consulta = "SELECT i.id ,tec.login ,i.due_date ,i.start_date ,i.status_id  from issues as i left join users as tec on i.assigned_to_id = tec.id where i.id in (";
            }
            $consulta = $consulta . " '" . $tarefa[$i][1] . "'";
            $i = $i + 1;
        }
        $consulta = $consulta . ");";
        $redmine = $this->tarefaRedmine->atuTarefas($consulta);
        $situacao = $this->consSituacao();
        $i = 0;
        while (count($tarefa) > $i) {
            $k1 = $i;
            $i2 = 0;
            while (count($redmine) > $i2) {
                if ($tarefa[$i][1] == $redmine[$i2][0]) {
                    $k2 = $i2;
                }
                $i2 = $i2 + 1;
            }
            $i2 = 0;
            while (count($situacao) > $i2) {
                if ($redmine[$k2][1] == $situacao[$i2][0]) {
                    $k3 = $i2;
                }
                $i2 = $i2 + 1;
            }
            $update1 = " UPDATE `servicos_tarefas` SET `cod_tarefa_redmine` = '" . $tarefa[$k1][1] . "', `situacao` = '" . $redmine[$k2][1] . "' WHERE `codigo_tarefa` = '" . $tarefa[$k1][0] . "'; ";
            $resultado_update112 = mysqli_query($this->connect(), $update1);
            $update1 = " UPDATE `servicos_eventos` SET `start` = '" . $redmine[$k2][2] . "',`title` ='" . $tarefa[$k1][2] . " - " . $redmine[$k2][4] . " - " . $tarefa[$k1][3] . "', `end` = '" . $redmine[$k2][3] . "', `color` = '" . $situacao[$k3][2] . "', `textColor` = '" . $situacao[$k3][1] . "' WHERE `id` = '" . $tarefa[$k1][0] . "'; ";
            $resultado_update112 = mysqli_query($this->connect(), $update1);
            $i = $i + 1;
        }
        $resultado_update112 = mysqli_query($this->connect(), $update1);
        return $resultado_update112;
    }

    function consSituacao() {
        $situacao = array();
        $i = 0;
        $consulta_consSituacao = "SELECT * FROM servicos_sit_tarefa;";
        $resultado_consSituacao = mysqli_query($this->connect(), $consulta_consSituacao);
        foreach ($resultado_consSituacao as $table_consSituacao) {
            $situacao[$i][0] = $table_consSituacao["codigo"];
            $situacao[$i][1] = $table_consSituacao["cor_texto"];
            $situacao[$i][2] = $table_consSituacao["cor"];
            $i = $i + 1;
        }
        return $situacao;
    }

    function atualizaAutomaticoTarefasRedmine() {
        $consulta_servicos10 = "SELECT * FROM servicos_eventos as s inner join servicos_tarefas as t on t.codigo_tarefa = s.id where t.cod_tarefa_redmine is not null order by id desc limit 100;";
        $resultado_servicos10 = mysqli_query($this->connect(), $consulta_servicos10);
        foreach ($resultado_servicos10 as $table_servicos10) {
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

    function atualizaTarefaRedimine() {
        $this->iniSituacaoEvento($this->getTarefaRedmine()->getSitTarefa());
        $this->setInicioEvento($this->getTarefaRedmine()->getIniTarefa());
        $this->setFimEvento($this->getTarefaRedmine()->getFimTarefa());
    }

    function atualizaEventoBD() {
        $retorno = 0;
        if ($this->testeEventoCadastrado($this->getEvento()) == "1" && $this->testeEventoVencido() == "1") {
            $consulta_servicos14 = "UPDATE `servicos_tarefas` SET `cod_tarefa_redmine` = '" . $this->getTarefaRedmine()->getNumTarefa() . "', `situacao` = '" . $this->getCodSitEvento() . "' WHERE `codigo_tarefa` = '" . $this->getEvento() . "';";
            $resultado_servicos14 = mysqli_query($this->connect(), $consulta_servicos14);
            $consulta_servicos15 = "UPDATE `servicos_eventos` SET `start` = '" . $this->getInicioEvento() . "', `end` = '" . $this->getFimEvento() . "', `color` = '" . $this->getCorEvento() . "', `textColor` = '" . $this->getCorTextoEvento() . "' WHERE `id` = '" . $this->getEvento() . "';";
            $resultado_servicos15 = mysqli_query($this->connect(), $consulta_servicos15);
            $retorno = 1;
        }
        return $retorno;
    }

    function cunsultaProxAntUlt($_tarefa) {
        $consulta_cunsultaProxAntUlt = "select st.id_evento , st.id_evento_anterior ,pt.id_evento as id_prox_evento , sc.id_ultimo_evento from `servicos_tarefas` as st inner join `servicos_cadastro` as sc on st.codigo_sevico = sc.codigo_servico left join `servicos_tarefas` as pt on st.id_evento = pt.id_evento_anterior where st.id_evento = '$_tarefa';";
        $resultado_cunsultaProxAntUlt = mysqli_query($this->connect(), $consulta_cunsultaProxAntUlt);
        return $resultado_cunsultaProxAntUlt;
    }

    function formataDataBR($_data) {
        return date('d/m/Y', strtotime($_data));
    }

    function __destruct() {
        
    }

}

/**
 * Description of servico
 *
 * @author tiagoc
 */
class Servico extends Database {

    private $codigo;
    private $nomeRedu;
    private $descricaoComp;
    private $repeticao;
    private $dataProxExec;
    private $dataUltExec;
    private $falhou;
    private $idEventoAnt;

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($_codigo) {
        $this->codigo = $_codigo;
    }

    function getNomeRedu() {
        return $this->nomeRedu;
    }

    function setNomeRedu($_nomeRedu) {
        $this->nomeRedu = $_nomeRedu;
    }

    function getDescricaoComp() {
        return $this->descricaoComp;
    }

    function setDescricaoComp($_descricaoComp) {
        $this->descricaoComp = $_descricaoComp;
    }

    function getRepeticao() {
        return $this->repeticao;
    }

    function setRepeticao($_repeticao) {
        $this->repeticao = $_repeticao;
    }

    function getDataProxExec() {
        return $this->dataProxExec;
    }

    function setDataProxExec($_data) {
        $this->dataProxExec = $_data;
    }

    function getDataUltExec() {
        return $this->dataUltExec;
    }

    function setDataUltExec($_data) {
        $this->dataUltExec = $_data;
    }

    function getFalhou() {
        return $this->falhou;
    }

    function setFalhou($_falhou) {
        $this->falhou = $_falhou;
    }

    function getidEventoAnt() {
        return $this->idEventoAnt;
    }

    function setIdEventoAnt($_id) {
        $this->idEventoAnt = $_id;
    }

    function listaServicos($_id, $_nome) {
        $consulta_listaServicos = "SELECT * FROM servicos_cadastro "
                . " where codigo_servico like '%$_id%' and nome_redu_servico like '%$_nome%';";
        $resultado_listaServicos = mysqli_query($this->connect(), $consulta_listaServicos);
        return $resultado_listaServicos;
    }

    function iniServico($_codigo) {
        $consulta_iniServico = "SELECT * FROM servicos_cadastro where codigo_servico = '$_codigo';";
        $resultado_iniServico = mysqli_query($this->connect(), $consulta_iniServico);
        foreach ($resultado_iniServico as $table_iniServico) {
            $this->setCodigo($table_iniServico["codigo_servico"]);
            $this->setNomeRedu($table_iniServico["nome_redu_servico"]);
            $this->setDescricaoComp($table_iniServico["descricao_tipo_servico"]);
            $this->setRepeticao($table_iniServico["repeticao"]);
            $this->setdataProxExec($table_iniServico["data_prox_exec"]);
            $this->setdataUltExec($table_iniServico["data_ult_criacao"]);
            $this->setfalhou($table_iniServico["falhou"]);
            $this->setidEventoAnt($table_iniServico["id_ultimo_evento"]);
        }
    }

    function manutServico($_codigo, $_nome, $_descricao, $_repeticao) {
        $consulta_manutServico = "UPDATE `servicos_cadastro` SET `nome_redu_servico` = '" . $_nome . "', `descricao_tipo_servico` = '" . $_descricao . "', `repeticao` = '" . $_repeticao . "' WHERE `codigo_servico` = '" . $_codigo . "'";
        $resultado_manutServico = mysqli_query($this->connect(), $consulta_manutServico);
    }

    function formataDataBR($_data) {
        return date('d/m/Y', strtotime($_data));
    }

}

/**
 * Description of Zabbix SEED
 *
 * @author tiagoc
 */
class ZabbixSEED extends DatabaseZbx {

    function listGraphTempoResposta() {
        $consulta_listGraphTempoResposta = " SELECT g.graphid, i.hostid FROM graphs as g join graphs_items as gi on g.graphid = gi.graphid join items as i on gi.itemid = i.itemid WHERE g.name = 'Tempo de Resposta'; ";
        $resultado_listGraphTempoResposta = mysqli_query($this->connectZbx(), $consulta_listGraphTempoResposta);
        return $resultado_listGraphTempoResposta;
    }

    function listTodosLinks() {
        $consulta = "SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status FROM hosts h JOIN hosts_groups hg ON h.hostid = hg.hostid JOIN groups g ON hg.groupid = g.groupid LEFT JOIN host_inventory hi ON hi.hostid = h.hostid LEFT JOIN interface inte ON inte.hostid = h.hostid JOIN items i ON i.hostid = h.hostid JOIN functions f ON f.itemid = i.itemid JOIN triggers t ON t.triggerid = f.triggerid WHERE g.groupid IN ('28','29','30','31','32','33','392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1';";
        $resposta = mysqli_query($this->connectZbx(), $consulta);
        return $resposta;
    }

    function listLinksPagos() {
        $consulta_listLinksPagos = " SELECT h.hostid, h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, "
                . " FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(day, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, "
                . " g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a, h.status "
                . " FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid "
                . " LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid "
                . " WHERE g.groupid IN ('28', '31', '29', '32', '30', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1'; ";
        $resultado_listLinksPagos = mysqli_query($this->connectZbx(), $consulta_listLinksPagos);

        return $resultado_listLinksPagos;
    }

    function listLinksPBLE() {
        $consulta_listLinksPBLE = " SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, "
                . " FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(DAY, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, g.name AS grupo, "
                . " hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a AS inep, h.status "
                . " FROM  hosts h JOIN hosts_groups hg ON h.hostid = hg.hostid "
                . " JOIN groups g ON hg.groupid = g.groupid LEFT JOIN host_inventory hi ON hi.hostid = h.hostid LEFT "
                . " JOIN interface inte ON inte.hostid = h.hostid JOIN items i ON i.hostid = h.hostid "
                . " JOIN functions f ON f.itemid = i.itemid JOIN triggers t ON t.triggerid = f.triggerid "
                . " WHERE g.groupid IN ('28') AND t.templateid IN ('19524' , '13554') AND inte.main = '1'; ";
        $resultado_listLinksPBLE = mysqli_query($this->connectZbx(), $consulta_listLinksPBLE);

        return $resultado_listLinksPBLE;
    }

    function consultAtividadeGraficoPortaSW($_ip, $_porta, $_empilha) {
        if ($_empilha == '0') {
            $_empilha = '1';
        }
        $consulta_consultTrafegoGraficoPortaSW = " SELECT count(i.itemid) as cont, i.itemid "
                . " FROM hosts as h join items as i on h.hostid = i.hostid "
                . " join interface as ip on ip.hostid = h.hostid "
                . " where ip.ip = '$_ip' and i.status = '0' and i.key_ like '%ifOperStatus[Unit: $_empilha Slot: 0 Port: $_porta %';  ";
        $resultado_consultTrafegoGraficoPortaSW = mysqli_query($this->connectZbx(), $consulta_consultTrafegoGraficoPortaSW);
        foreach ($resultado_consultTrafegoGraficoPortaSW as $value) {
            if ($value["itemid"] == '0') {
                $resultado = '0';
            } else {
                $resultado = $value["itemid"];
            }
        }
        return $resultado;
    }

    function consultTrafegoGraficoPortaSW($_ip, $_porta, $_empilha) {
        if ($_empilha == '0') {
            $_empilha = '1';
        }
        $consulta_consultAtividadeGraficoPortaSW = " SELECT count(g.graphid) as cont, g.graphid FROM hosts as h"
                . " join items as i on h.hostid = i.hostid "
                . " join interface as ip on ip.hostid = h.hostid "
                . " join graphs_items as gi on gi.itemid = i.itemid "
                . " join graphs as g on g.graphid = gi.graphid "
                . " where ip.ip = '$_ip' and i.status = '0'  and g.name like '%Trafego na interface Unit: $_empilha Slot: 0 Port: $_porta %'  limit 1;";
        $resultado_consultAtividadeGraficoPortaSW = mysqli_query($this->connectZbx(), $consulta_consultAtividadeGraficoPortaSW);
        foreach ($resultado_consultAtividadeGraficoPortaSW as $value) {
            if ($value["graphid"] == '0') {
                $resultado = '0';
            } else {
                $resultado = $value["graphid"];
            }
        }
        return $resultado;
    }

    function listImpr() {
        $consulta_listImpr = " SELECT h.hostid, h.host, h.name, t.value, "
                . " (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, "
                . " FROM_UNIXTIME(t.lastchange) AS data, "
                . " TIMESTAMPDIFF(day, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, "
                . " g.name AS grupo, inte.ip, h.status FROM zabbix3.hosts h "
                . " JOIN hosts_groups hg ON h.hostid = hg.hostid "
                . " JOIN groups g ON hg.groupid = g.groupid LEFT "
                . " JOIN host_inventory hi ON hi.hostid = h.hostid "
                . " LEFT JOIN interface inte ON inte.hostid = h.hostid "
                . " JOIN items i ON i.hostid = h.hostid "
                . " JOIN functions f ON f.itemid = i.itemid "
                . " JOIN triggers t ON t.triggerid = f.triggerid "
                . " WHERE g.groupid IN ('15') AND t.templateid IN ('19524' , '13554') AND inte.main = '1' and h.name like '%%' order by ip;  ";
        $resultado_listImpr = mysqli_query($this->connectZbx(), $consulta_listImpr);

        return $resultado_listImpr;
    }

    function imprimiAtivo($_codigo) {
        if ($_codigo == '1') {
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">NOK</span>';
        } elseif ($_codigo == '0') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">OK</span>';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">N/C</span>';
        }
    }

    function imprimiSitu($_codigo) {
        if ($_codigo == '1') {
            return 'Não';
        } elseif ($_codigo == '0') {
            return 'Sim';
        } else {
            return 'N/C';
        }
    }

}

/**
 * Description of Zabbix Cofre
 *
 * @author tiagoc
 */
class ZabbixCofre extends DatabaseZbxCofre {

    function listArquivosLog($_data) {
        if ($_data == '') {
            $_data = '2010-01-01 00:00:00';
        }
        $consulta_listArquivosExcluidos = " select * from (SELECT * , FROM_UNIXTIME(timestamp) AS data_hora FROM history_log) as a1 where (a1.value like '%Access Mask:		0x10000%' or a1.value like '%Access Mask:		0x2%' ) and a1.logeventid = '4663' and a1.data_hora > '$_data' order by  a1.timestamp asc ;";
        $resultado_listArquivosExcluidos = mysqli_query($this->connectZbxCofre(), $consulta_listArquivosExcluidos);
        return $resultado_listArquivosExcluidos;
    }

}
