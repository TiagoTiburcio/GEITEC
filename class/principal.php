<?php
include_once '../class/database.php';

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
            
    function __construct(){ }

    function setCodigo($_codigo){ $this->codigo = $_codigo; }

    function getCodigo(){ return $this->codigo; }
        
    private function setNome($_nome){ $this->nome = $_nome; }

    function getNome(){ return $this->nome; }
        
    private function setUsuario($_usuario){ $this->usuario = $_usuario; }

    function getUsuario(){ return $this->usuario; }
    
    private function setSenha($_senha){ $this->senha = $_senha; }
            
    function getSenha(){ return $this->senha; }
    
    function getSenhaEncriptada($_senha){ 
        $resultado = sha1($_senha);
        return $resultado;
    }
    
    private function setAtivo($_ativo){ $this->ativo = $_ativo; }
            
    function getAtivo(){ return $this->ativo; }
    
    private function setPerfil($_perfil){ $this->perfil = $_perfil; }
            
    function getPerfil(){ return $this->perfil; }
    
    private function setAltProxLogin($_altProxLogin){ $this->altProxLogin = $_altProxLogin; }
            
    function getAltProxLogin(){ return $this->altProxLogin; }
    
    // 0 - usuario não gravado 1 - usuario existente na Base de Dados
    private function testeUsuarioCadatrado($_usuario){
        $consulta_usuario1 = "SELECT count(`codigo`) as cont FROM `home_usuario` where usuario = '$_usuario';";                                
        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1){                        
           $resultado = $table_usuario1["cont"]; 
        } 
        return $resultado;
    }
    
    // 0 - usuario não gravado 1 - usuario existente na Base de Dados
    private function proxUsuario(){
        $consulta_usuario1 = "SELECT (count(`codigo`) + 1) as cont FROM `home_usuario`";                                
        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1){                        
           $resultado = $table_usuario1["cont"]; 
        } 
        return $resultado;
    }
    private function idUsuario($_usuario){
        $consulta_usuario1 = "SELECT `codigo` FROM `home_usuario` where usuario = '$_usuario';";                                
        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
        foreach ($resultado_usuario1 as $table_usuario1){                        
           $resultado = $table_usuario1["codigo"]; 
        } 
        return $resultado;
    }
    
    // 0 - Usuário Novo 1 - Editou Usuário
    function manutUsuario($_usuario,$_nome,$_senhaBranco, $_ativo, $_perfil, $_altProxLogin, $_usuarioAlt, $_dataAlt){
        $resultado = $this->testeUsuarioCadatrado($_usuario);       
        if( $resultado == 0){            
            $consulta_manutUsuario = " INSERT INTO `home_usuario`(`codigo`,`usuario`,`senha`,`nome`,`ativo`,`codigo_perfil`,`altera_senha_login`,`usuario_edit`,`data_edit`) "
                    . " VALUES( '".$this->proxUsuario()."' , '".$_usuario."' , '". $this->getSenhaEncriptada($_senhaBranco)."' , '".$_nome."' ,'".$_ativo."','".$_perfil."','".$_altProxLogin."','".$_usuarioAlt."','".$_dataAlt."'); ";
            $resultado_manutUsuario = mysqli_query($this->connect(), $consulta_manutUsuario);
            
        } else {               
            $consulta_manutUsuario = "UPDATE `home_usuario` SET `usuario` = '".$_usuario."' , "
                    . "`senha` = '".$this->getSenhaEncriptada($_senhaBranco)."' , `nome` = '".$_nome."' "
                    . ",`ativo` = '".$_ativo."',`altera_senha_login` = '".$_altProxLogin."', `usuario_edit` = '".$_usuarioAlt."',"
                    . " `data_edit` = '".$_dataAlt."', `codigo_perfil` = '".$_perfil."' WHERE `codigo` = '".$this->idUsuario($_usuario)."';";
            $resultado_manutUsuario = mysqli_query($this->connect(), $consulta_manutUsuario);
        }        
        return $resultado;
    }
   
    // retorna lista com todos os usuarios cadastrados
    function listaUsuarios($_codigo, $_nome, $_login){        
        $consulta_listaUsuarios = "SELECT u.*, p.descricao as descricao_perfil FROM home_usuario as u join home_perfil as p on p.codigo = u.codigo_perfil"
                            . " where u.codigo like '%$_codigo%' and u.usuario like '%$_nome%' and nome like '%$_login%';";
        $resultado_listaUsuarios = mysqli_query($this->connect(), $consulta_listaUsuarios);
        return $resultado_listaUsuarios;
    }
    
    function listaPerfil(){
        $consulta_listaPerfil = "SELECT * FROM homo_sis_geitec.home_perfil where ativo = '1';";
        $resultado_listaPerfil = mysqli_query($this->connect(), $consulta_listaPerfil);
        return $resultado_listaPerfil;
    }

    // retorno = 1 - usuario cadastrado 0 - usuario não cadastrado
    function iniUsuario($_usuario){
        $retorno = $this->testeUsuarioCadatrado($_usuario);
        if ($retorno == 1){
            $consulta_iniUsuario = "SELECT * FROM home_usuario where usuario = '$_usuario';";                                
            $resultado_iniUsuario = mysqli_query($this->connect(), $consulta_iniUsuario);
            foreach ($resultado_iniUsuario as $table_iniUsuario){
                $this->setCodigo($table_iniUsuario["codigo"]);
                $this->setUsuario( $table_iniUsuario["usuario"]);
                $this->setNome($table_iniUsuario["nome"]);
                $this->setSenha($table_iniUsuario["senha"]);
                $this->setAtivo($table_iniUsuario["ativo"]);
                $this->setPerfil($table_iniUsuario["codigo_perfil"]);
                $this->setAltProxLogin($table_iniUsuario["altera_senha_login"]);
            }            
        }
        return $retorno;
    }
    
    function validaSessao($_teste){               
        session_start();        
        
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
            return 0;
        } else {
            $this->iniUsuario($_SESSION['login']);
            if($_teste == '1'){
            include ("../class/headerCircuitos.php");
            include ("../class/baropc.php");
            } elseif ($_teste == '2') {
            } else {
            include ("../class/header.php");
            include ("../class/baropc.php");
            }
            return 1;
        }
    }
    
    function imprimiAtivo($_codigo){
        if($_codigo == '0'){
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">';
        }elseif ($_codigo == '1') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">';
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

    function insertImportContas($_linhas){
        $consulta_insertImportContas = "INSERT INTO `circuito_arquivo_import` "
                . " (`nome_arquivo`,`num_linha_arquivo`,`site`,`nome_cliente`, "
                . " `finalidade`,`contrato`,`ciclo_faturamento`,`num_fatura`, "
                . " `num_nota_fiscal`,`cod_ddd`,`num_telefone`,`designacao`, "
                . " `valor_a_pagar`,`nome_local`,`tip_logradouro`,`nome_logradouro`, "
                . " `num_imovel`,`nome_bairro`,`cep`,`uf`,`nome_local2`,`tip_logradouro2`, "
                . " `nome_logradouro2`,`num_imovel2`,`nome_bairro2`,`cep2`,`uf2`, "
                . " `prod_telefone`,`velocidade_circuito`,`num_pagina`,`num_linha`, "
                . " `data_servico`,`cod_servico_descricao_servico`,`degrau`,`num_tel_origem`, "
                . " `cod_selecao`,`ddd_tel_destino`,`tel_destino`,`hr_qtd_chamada`, "
                . " `duracao`,`s`,`valor_servico`,`aliquota_icms`,`conta`,`num_detalhe`, "
                . " `cod_l_origem_chamada`,`cod_l_destino_chamada`,`vencimento`,`contestar`, "
                . " `valor_contestar`,`localidade`,`telefone_origem`,`sigla_orgao_analise`) VALUES "
                . implode(', ', $_linhas) . ";";              
            $resultado_insertImportContas = mysqli_query($this->connect(), $consulta_insertImportContas);
            
            return $resultado_insertImportContas;
    }

    // retorna lista com todos os usuarios cadastrados
    function listaUnidades($_dre,$_unidade){        
        $consulta_listaUnidades = "SELECT u.codigo_siig, u.codigo_inep, u.descricao,"
                . " u.sigla, d.descricao descricao_dre, d.sigla as sigla_dre, "
                . " d.codigo_siig as codigo_siig_dre, e.descricao as cidade "
                . " FROM circuitos_unidades as u "
                . " inner join circuitos_unidades as d on u.codigo_unidade_pai = d.codigo_siig "
                . " inner join EscolasSiteCompleta as e on e.codigo_mec = u.codigo_inep "
                . " where d.sigla like '%$_dre%' and u.descricao like '%$_unidade%' "
                . " order by d.sigla, e.descricao, u.descricao; ";                              
        $resultado_listaUnidades = mysqli_query($this->connect(), $consulta_listaUnidades);
        return $resultado_listaUnidades;
    }
    
    // retorna lista com todos os usuarios cadastrados
    function listaLinhaArquivo($_arquivo,$_num_linha){        
        $consulta_listaLinhaArquivo = "SELECT * FROM circuito_arquivo_import_temp where nome_arquivo = '$_arquivo' and num_linha_arquivo = '$_num_linha'; ";                
        $resultado_listaLinhaArquivo = mysqli_query($this->connect(), $consulta_listaLinhaArquivo);
        return $resultado_listaLinhaArquivo;
    }
    
    // retorna lista com todos os usuarios cadastrados
    function listaUnidadesCadastradas(){        
        $consulta_listaUnidadesCadastradas = "SELECT u_sup.sigla as dre, u.descricao as nome, u.codigo_ut_siig as codigo, u.cidade "
                . " FROM circuitos_unidades as u left join circuitos_unidades as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig where u.ativo = '1' order by u_sup.sigla, u.cidade, u.descricao;";                
        $resultado_listaUnidadesCadastradas = mysqli_query($this->connect(), $consulta_listaUnidadesCadastradas);
        return $resultado_listaUnidadesCadastradas;
    }
    // retorna lista com todos os usuarios cadastrados
    function listaLocalizacao(){        
        $consulta_listaLocalizacao = "SELECT * FROM circuitos_localizacao;";                
        $resultado_listaLocalizacao = mysqli_query($this->connect(), $consulta_listaLocalizacao);
        return $resultado_listaLocalizacao;
    }
    
    // retorna lista com todos os usuarios cadastrados
    function editLinhaArquivo($_arquivo,$_num_linha,$_designacao){ 
        $consulta_editLinhaArquivo0 = " select i.designacao , count(i.designacao) as cont from circuito_arquivo_import_temp as i  where  i.nome_arquivo = '$_arquivo' and i.num_linha_arquivo = '$_num_linha';";
        $resultado_editLinhaArquivo0 = mysqli_query($this->connect(), $consulta_editLinhaArquivo0);
        foreach ($resultado_editLinhaArquivo0 as $cont){
            $teste = $cont['cont'];
            $designacao_antes = $cont['designacao'];            
        }        
        if ($teste > 0){
         $consulta_editLinhaArquivo1 = " UPDATE `circuito_arquivo_import_temp` SET `designacao` = '$_designacao' WHERE `nome_arquivo` = '$_arquivo' AND `num_linha_arquivo` = '$_num_linha'; ";                
         $resultado_editLinhaArquivo1 = mysqli_query($this->connect(), $consulta_editLinhaArquivo1);   
         $consulta_editLinhaArquivo2 = " select count(rc.codigo) as cont, i.contrato from circuito_arquivo_import_temp as i join circuitos_registro_consumo as rc on rc.codigo = i.designacao where i.designacao = '$_designacao' and i.nome_arquivo = '$_arquivo' and i.num_linha_arquivo = '$_num_linha'; ";                
         $resultado_editLinhaArquivo2 = mysqli_query($this->connect(), $consulta_editLinhaArquivo2);
         foreach ($resultado_editLinhaArquivo2 as $valida) {
             $v1 = $valida['cont'];             
             $contrato = $valida['contrato'];
         }         
         if ($v1 > 0){
            $consulta_editLinhaArquivo3 = " INSERT INTO `circuitos_correcao_import`(`contrato`,`designacao_antes`,`designacao_depois`)VALUES('$contrato','$designacao_antes','$_designacao'); ";                
            $resultado_editLinhaArquivo3 = mysqli_query($this->connect(), $consulta_editLinhaArquivo3);
            return $resultado_editLinhaArquivo3;
         } else {
            $consulta_editLinhaArquivo3 = " UPDATE `circuito_arquivo_import_temp` SET `designacao` = '$designacao_antes' WHERE `nome_arquivo` = '$_arquivo' AND `num_linha_arquivo` = '$_num_linha'; ";                
            $resultado_editLinhaArquivo3 = mysqli_query($this->connect(), $consulta_editLinhaArquivo3);   
            return $resultado_editLinhaArquivo3;
         }
        }
        
        
    }
    
    // retorna lista com todos os usuarios cadastrados
    function addRegistroConsumo($_designacao,$_localizacao,$_codigo_unidade){ 
        $data = date_default_timezone_set("America/Bahia");
        $data = date('Y-m-d');
        $consulta_editLinhaArquivo = " INSERT INTO `circuitos_registro_consumo`(`codigo`,`localizacao`,`codigo_unidade`,`data_ativacao`) VALUES('$_designacao','$_localizacao','$_codigo_unidade','$data'); ";                
        $resultado_editLinhaArquivo = mysqli_query($this->connect(), $consulta_editLinhaArquivo);
        return $resultado_editLinhaArquivo;
    }
    
    // retorna lista com todos os usuarios cadastrados
    function listaCircuitos($_mescad,$_fatura){        
        $consulta_circuito1 =  " SELECT c.periodo_ref, c.fatura, rc.localizacao,"
                . " CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(c.valor_conta), 2),'.',';'),',','.'),';',',')) as valor, "
                . " date_format(c.periodo_ref,'%m/%Y') as mes, lo.descricao, "
                . " co.descricao_servico FROM circuitos_contas as c "
                . " join circuitos_registro_consumo as rc on rc.codigo = c.designacao "
                . " join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade "
                . " join circuitos_localizacao as lo on lo.codigo = rc.localizacao "
                . " join circuitos_contrato as co on co.codigo = c.fatura "
                . " where c.periodo_ref = '$_mescad' and c.fatura like '%$_fatura%' "
                . " GROUP BY c.periodo_ref, c.fatura, rc.localizacao "
                . " ORDER BY c.periodo_ref desc, c.fatura , rc.localizacao; ";                              
        $resultado_circuito1 = mysqli_query($this->connect(), $consulta_circuito1);
        return $resultado_circuito1;
    }
    
    function listaPeriodoRef(){        
        $consulta_circuito2 = "SELECT distinct periodo_ref, date_format(periodo_ref,'%m/%Y') as mes FROM circuitos_contas order by periodo_ref desc limit 10";
        $resultado_circuito2 = mysqli_query($this->connect(), $consulta_circuito2);
        return $resultado_circuito2;
    }
    
    function listaRegConsumo(){        
        $consulta_listaRegConsumo = "SELECT rc.codigo , u.descricao as cidade  FROM circuitos_registro_consumo as rc join circuitos_unidades as u on u.codigo_ut_siig = rc.codigo_unidade;";
        $resultado_listaRegConsumo = mysqli_query($this->connect(), $consulta_listaRegConsumo);
        return $resultado_listaRegConsumo;
    }
    
    function listaConsultaDetalhada($_unidade,$_fatura,$_circuito,$_diretoria,$_mescad){        
        $consulta_circuito3 = " SELECT u_sup.sigla as `DRE`, u.cidade as `cidade`,"
                . " c.designacao as `circuito`, u.descricao as `nome_unidade`, "
                . " date_format(c.periodo_ref,'%m/%Y') as `periodo_ref`,c.`fatura`, "
                . " CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(c.valor_conta, 2),'.',';'),',','.'),';',',')) as `valor_conta` "
                . " FROM `circuitos_contas` as c "
                . " join `circuitos_registro_consumo` as rc on rc.codigo = c.designacao "
                . " join `circuitos_unidades` as u on u.codigo_ut_siig = rc.codigo_unidade "
                . " join `circuitos_unidades` as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig "
                . " where u.descricao like '%$_unidade%' "
                . " and c.`fatura` like '%$_fatura%' "
                . " and c.designacao like '%$_circuito%' "
                . " and u_sup.sigla like '%$_diretoria%' "
                . " and c.periodo_ref = '$_mescad' "
                . " order by u_sup.sigla, u.cidade, u.descricao;  ";
        $resultado_circuito3 = mysqli_query($this->connect(), $consulta_circuito3);
        return $resultado_circuito3;
    }
    
    function listaContaZabbix(){        
        $consulta_listaContaZabbix = " select u_sup.sigla as DRE, u.cidade, "
                . " c.designacao as 'circuito', l.descricao, u.descricao as nome_unidade, "
                . " c.periodo_ref, c.fatura, c.valor_conta "
                . " from `circuitos_contas` as c "
                . " join `circuitos_registro_consumo` as rc on rc.codigo = c.designacao "
                . " join `circuitos_unidades` as u on u.codigo_ut_siig = rc.codigo_unidade "
                . " left join `circuitos_unidades` as u_sup on u.codigo_unidade_pai = u_sup.codigo_siig "
                . " join `circuitos_localizacao` as l on l.codigo = rc.localizacao "
                . " join `circuitos_contrato` as cc on cc.codigo = c.fatura "
                . " where c.periodo_ref = '2017-11-01' and cc.descricao_servico = 'Link de Dados'; ";
        $resultado_listaContaZabbix = mysqli_query($this->connect(), $consulta_listaContaZabbix);
        return $resultado_listaContaZabbix;
        
    }
    
    function limpaImport(){
        $consulta_limpaImport = " INSERT INTO `circuito_arquivo_import_temp`(`nome_arquivo`,`num_linha_arquivo`,`contrato`,`num_fatura`,`num_nota_fiscal`,`cod_ddd`,`num_telefone`,`designacao`,`tip_logradouro`,`nome_local`,`nome_logradouro`,`num_imovel`,`nome_bairro`,`cep`,`uf`,`prod_telefone`,`velocidade_circuito`,`num_pagina`,`num_linha`,`data_servico`,`cod_servico_descricao_servico`,`valor_servico`,`conta`,`num_detalhe`,`vencimento`) select * from (select a1.nome_arquivo, a1.num_linha_arquivo, concat('18500' , a1.contrato) as contrato, a1.num_fatura, a1.`num_nota_fiscal`, a1.cod_ddd, a1.num_telefone, (CASE a1.designacao_limpa WHEN '' THEN (CASE a1.num_tel_origem WHEN '' THEN (CASE a1.telefone_origem WHEN '' THEN (select REPLACE(num_tel_origem,'000000','') from `circuito_arquivo_import` where nome_arquivo = a1.nome_arquivo and num_linha_arquivo = (a1.num_linha_arquivo - 1)) else (REPLACE(a1.telefone_origem,'-','')) END)else (REPLACE(num_tel_origem,'000000','')) END)else (a1.designacao_limpa) END) as designacao_limpa, a1.tip_logradouro, a1.nome_local, a1.nome_logradouro, a1.num_imovel, SUBSTR( a1.nome_bairro, 5 ) AS nome_bairro, a1.cep, a1.uf, a1.prod_telefone, a1.velocidade_circuito, a1.num_pagina, a1.num_linha, CONCAT(SUBSTR( a1.data_servico, 7, 4 ),'-', SUBSTR( a1.data_servico, 4, 2 ),'-',SUBSTR( a1.data_servico, 1, 2 )) as data_servico,a1.cod_servico_descricao_servico, CASE a1.s WHEN '+' THEN (CAST(replace(a1.valor_servico,',','.') as DECIMAL(9,2)))  WHEN '-' THEN (-CAST(replace(a1.valor_servico,',','.') as DECIMAL(9,2))) END as valor_servico, CONCAT(SUBSTR( a1.conta, 1, 4 ),'-', SUBSTR( a1.conta, 5, 2 ),'-',SUBSTR( a1.conta, 7, 2 )) as conta,  a1.num_detalhe, CONCAT(SUBSTR( a1.vencimento, 7, 4 ),'-', SUBSTR( a1.vencimento, 4, 2 ),'-',SUBSTR( a1.vencimento, 1, 2 )) as vencimento from (SELECT TRIM(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(designacao,'CONTRATO DE CONTA CUS450', 'Encargos '),'  ', ' '),'   ', ' '),'    ', ' '),'   ', ' '),'  ',' '),'-',''), 'AEB AEB' , 'AEB' ), 'AGUR AGUR' , 'AGUR' ), 'AJU AJU' , 'AJU' ), 'TANQUE NOVO' , '' ), 'APF APF' , 'APF' ), 'TATW TATW' , 'TATW' ), 'AQB AQB' , 'AQB' ), 'TBOC TBOC' , 'TBOC' ), 'AUX AUX' , 'AUX' ), 'TQNV TQNV' , 'TQNV' ), 'BEJ BEJ' , 'BEJ' ), 'SSNV SSNV' , 'SSNV' ), 'BQM BQM' , 'BQM' ), 'TAFA TAFA' , 'TAFA' ), 'BQS BQS' , 'BQS' ), 'SREO SREO' , 'SREO' ), 'CAI CAI' , 'CAI' ), 'SRAW SRAW' , 'SRAW' ), 'CBE CBE' , 'CBE' ), 'SMCD SMCD' , 'SMCD' ), 'CDB CDB' , 'CDB' ), 'SMAP SMAP' , 'SMAP' ), 'CEJ CEJ' , 'CEJ' ), 'SITIOS NOVOS' , '' ), 'CFY CFY' , 'CFY' ), 'SERK SERK' , 'SERK' ), 'CHB CHB' , 'CHB' ), 'RPED RPED' , 'RPED' ), 'CPL CPL' , 'CPL' ), 'PRBR PRBR' , 'PRBR' ), 'CSP CSP' , 'CSP' ), 'POXM POXM' , 'POXM' ), 'CYR CYR' , 'CYR' ), 'PIDB PIDB' , 'PIDB' ), 'DNP DNP' , 'DNP' ), 'MUCE MUCE' , 'MUCE' ), 'ETC ETC' , 'ETC' ), 'MTGD MTGD' , 'MTGD' ), 'FVA FVA' , 'FVA' ), 'MCAM MCAM' , 'MCAM' ), 'GAPO GAPO' , 'GAPO' ), 'LGDR LGDR' , 'LGDR' ), 'GCH GCH' , 'GCH' ), 'LDHS LDHS' , 'LDHS' ), 'GRX GRX' , 'GRX' ), 'INT MLD' , 'INT' ), 'GYD GYD' , 'GYD' ), 'ENHO ENHO' , 'ENHO' ), 'IBI IBI' , 'IBI' ), 'IHF IHF' , 'IHF' ), 'IJD IJD' , 'IJD' ), 'ILHV ILHV' , 'ILHV' ), 'IND IND' , 'IND' ), 'INN INN' , 'INN' ), 'INT INT' , 'INT' ), 'JPO JPO' , 'JPO' ), 'JUB JUB' , 'JUB' ), 'LAT LAT' , 'LAT' ), 'LNJ LNJ' , 'LNJ' ), 'MHR MHR' , 'MHR' ), 'MLD MLD' , 'MLD' ), 'MMB MMB' , 'MMB' ), 'MOB MOB' , 'MOB' ), 'MRM MRM' , 'MRM' ), 'MSG MSG' , 'MSG' ), 'MUB MUB' , 'MUB' ), 'NHG NHG' , 'NHG' ), 'NNL NNL' , 'NNL' ), 'NOS NOS' , 'NOS' ), 'NRA NRA' , 'NRA' ), 'NRO NRO' , 'NRO' ), 'NSD NSD' , 'NSD' ), 'PAB PAB' , 'PAB' ), 'PDK PDK' , 'PDK' ), 'PEH PEH' , 'PEH' ), 'PFH PFH' , 'PFH' ), 'PKT PKT' , 'PKT' ), 'POV POV' , 'POV' ), 'PPI PPI' , 'PPI' ), 'PXM PXM' , 'PXM' ), 'PYO PYO' , 'PYO' ), 'RCH RCH' , 'RCH' ), 'REE REE' , 'REE' ), 'RHT RHT' , 'RHT' ), 'RRO RRO' , 'RRO' ), 'SAX SAX' , 'SAX' ), 'SCV SCV' , 'SCV' ), 'SDS SDS' , 'SDS' ), 'SFW SFW' , 'SFW' ), 'SFY SFY' , 'SFY' ), 'SHY SHY' , 'SHY' ), 'SLM SLM' , 'SLM' ), 'SMB SMB' , 'SMB' ), 'SXO SXO' , 'SXO' ), 'SXN SXN' , 'SXN' ), 'SYR SYR' , 'SYR' ), 'TBB TBB' , 'TBB' ), 'TGU TGU' , 'TGU' ), 'TLH TLH' , 'TLH' ), 'UUB UUB' , 'UUB' ), 'ASGG ASGG' , 'ASGG' ), 'MGBI MGBI' , 'MGBI' ), 'PCBS PCBS' , 'PCBS' ), 'TRIO TRIO' , 'TRIO' ), 'FIP FIP' , 'FIP' ), 'AGUA FRIA' , '' ), 'BNSU BNSU' , 'BNSU' ), 'ATALAIA NOVA' , '' ), 'FEIRA NOVA' , '' ), 'ASS QUEIMADA GRANDE' , '' ), 'ALAGADICO' , '' ), 'ALTO DO SANTO ANTONIO' , '' ), 'AMPARO DE SAO FRANCI' , '' ), 'AQUIDABA' , '' ), 'ARACAJU' , '' ), 'ARAUA' , '' ), 'AREIA BRANCA' , '' ), 'ATALAIA DEZA' , '' ), 'BARRA DOS COQUEIROS' , '' ), 'BONSUCESSO' , '' ), 'BOQUIM' , '' ), 'BRAVO URUBU' , '' ), 'BREJAO' , '' ), 'BREJO GRANDE' , '' ), 'BREJO' , '' ), 'CABRITA' , '' ), 'CAMPO DO BRITO' , '' ), 'CANHOBA' , '' ), 'CANINDE DE SAO FRANC' , '' ), 'CAPELA' , '' ), 'CARIRA' , '' ), 'CARMOPOLIS' , '' ), 'CEDRO DE SAO JOAO' , '' ), 'COLONIA MIRANDA' , '' ), 'COLONIA TREZE' , '' ), 'COLONIA' , '' ), 'CRISTINAPOLIS' , '' ), 'CRUZ DAS GRACAS' , '' ), 'CUMBE' , '' ), 'DIVINA PASTORA' , '' ), 'ESCURIAL' , '' ), 'ESPINHEIRO' , '' ), 'ESTANCIA' , '' ), 'FAZENDA DEZA' , '' ), 'FEIRA DEZA' , '' ), 'FREI PAULO' , '' ), 'GARARU' , '' ), 'GENERAL MAYNARD' , '' ), 'GENIPAPO' , '' ), 'GRACHO CARDOSO' , '' ), 'ILHA DAS FLORES' , '' ), 'INDIAROBA' , '' ), 'ITABAIANA' , '' ), 'ITABAIANINHA' , '' ), 'ITABI' , '' ), 'ITAPORANGA DAJUDA' , '' ), 'JAPARATUBA' , '' ), 'JAPOATA' , '' ), 'LADEIRA' , '' ), 'LADEIRINHAS' , '' ), 'LAGARTO' , '' ), 'LAGOA DA VOLTA' , '' ), 'LARANJEIRAS' , '' ), 'MACAMBIRA' , '' ), 'MALHADA DOS BOIS' , '' ), 'MALHADOR' , '' ), 'MANGABEIRAS' , '' ), 'MARUIM' , '' ), 'MATA GRANDE' , '' ), 'MATAPOA' , '' ), 'MIRANDA' , '' ), 'MOCAMBO' , '' ), 'MOITA BONITA' , '' ), 'MONTE ALEGRE DE SERG' , '' ), 'MURIBECA' , '' ), 'MUSSUCA' , '' ), 'NEOPOLIS' , '' ), 'NOSSA SENHORA APAREC' , '' ), 'NOSSA SENHORA DA GLO' , '' ), 'NOSSA SENHORA DAS DO' , '' ), 'NOSSA SENHORA DE LOU' , '' ), 'NOSSA SENHORA DO SOC' , '' ), 'OITEIROS' , '' ), 'PACATUBA' , '' ), 'PAU DE COLHER' , '' ), 'PEDRA BRANCA' , '' ), 'PEDRA MOLE' , '' ), 'PEDRINHAS' , '' ), 'PINDOBA' , '' ), 'PINHAO' , '' ), 'PIRAMBU' , '' ), 'PIRUNGA' , '' ), 'POCO REDONDO' , '' ), 'POCO VERDE' , '' ), 'POCOS DOS BOIS' , '' ), 'PORTO DA FOLHA' , '' ), 'POXIM' , '' ), 'PROPRIA' , '' ), 'RIACHAO DO DANTAS' , '' ), 'RIACHUELO' , '' ), 'RIBEIROPOLIS' , '' ), 'RIO DAS PEDRAS' , '' ), 'ROSARIO DO CATETE' , '' ), 'SALGADO' , '' ), 'SANTA LUZIA DO ITANH' , '' ), 'SANTA ROSA DE LIMA' , '' ), 'SANTA ROSA DO ERMIRI' , '' ), 'SANTANA DO SAO FRANC' , '' ), 'SANTO AMARO DAS BROT' , '' ), 'SACO TORTO' , '' ), 'SAO CRISTOVAO' , '' ), 'SAO DOMINGOS' , '' ), 'SAO FRANCISCO' , '' ), 'SAO JOSE' , '' ), 'SAO MATEUS DA PALEST' , '' ), 'SAO MIGUEL DO ALEIXO' , '' ), 'SERRA DO MACHADO' , '' ), 'SERRAO' , '' ), 'SIMAO DIAS' , '' ), 'SIRIRI' , '' ), 'SITIOS DEZOS' , '' ), 'TAICOCA DE FORA' , '' ), 'TANQUE DEZO' , '' ), 'TATU' , '' ), 'TELHA' , '' ), 'TOBIAS BARRETO' , '' ), 'TOMAR DO GERU' , '' ), 'TRIUNFO' , '' ), 'UMBAUBA' , '' ), 'TIPO DE LINHA' , '' ), ' 800' , '' )) AS designacao_limpa , ai.* FROM `circuito_arquivo_import` as ai) AS a1 left join circuito_arquivo_import_temp as i on a1.nome_arquivo = i.nome_arquivo and a1.num_linha_arquivo = i.num_linha_arquivo where i.num_linha_arquivo is null) as c1 ; ";
        $resultado_limpaImport = mysqli_query($this->connect(), $consulta_limpaImport);
        $consulta_limpaImport1 = " select distinct nome_arquivo from circuito_arquivo_import_temp;  ";
        $resultado_limpaImport1 = mysqli_query($this->connect(), $consulta_limpaImport1);
        foreach ($resultado_limpaImport1 as $table1){
            $this->corrigeArquivo($table1['nome_arquivo']);
        }
        return $resultado_limpaImport;
    }
    
    function corrigeArquivo($_arquivo){    
        $consulta_corrigeArquivo = " UPDATE `circuito_arquivo_import_temp` AS t1 JOIN `circuitos_correcao_import` AS t2 ON t1.`contrato` = t2.`contrato` and t1.`designacao` = t2.`designacao_antes` SET t1.`designacao` = t2.`designacao_depois` where t1.nome_arquivo = '$_arquivo' and t1.num_linha_arquivo > 0; ";
        $resultado_corrigeArquivo = mysqli_query($this->connect(), $consulta_corrigeArquivo);
        return $resultado_corrigeArquivo;
    }
    
    function excluiImport($_arquivo){
        $consulta_excluiImport = " delete FROM circuito_arquivo_import where nome_arquivo = '$_arquivo' and num_linha_arquivo > '0'; ";
        $resultado_excluiImport = mysqli_query($this->connect(), $consulta_excluiImport);
        
        $consulta_excluiImport2 = " delete FROM circuito_arquivo_import_temp where nome_arquivo = '$_arquivo' and num_linha_arquivo > '0'; ";
        $resultado_excluiImport2 = mysqli_query($this->connect(), $consulta_excluiImport2);
        return $resultado_excluiImport.$resultado_excluiImport2;
    }
    function excluiDadosContas($_contrato, $_conta){
        $consulta_excluiDadosContas = " delete FROM circuitos_contas where fatura = '$_contrato' and periodo_ref = '$_conta' ";
        $resultado_excluiDadosContas = mysqli_query($this->connect(), $consulta_excluiDadosContas);
        return $resultado_excluiDadosContas;
    }
    
    function listaProblemaImport(){        
        $consulta_listaProblemaImport = "SELECT ai.* , date_format(ai.conta, '%m/%Y') as conta, date_format(ai.vencimento, '%d/%m') as vencimento FROM circuito_arquivo_import_temp as ai left join circuitos_registro_consumo as rc on rc.codigo = ai.designacao where rc.codigo is null;";
        $resultado_listaProblemaImport = mysqli_query($this->connect(), $consulta_listaProblemaImport);
        return $resultado_listaProblemaImport;
    }
    function listaContasImport(){        
        $consulta_listaContasImport = " SELECT ai.nome_arquivo , ai.contrato, date_format(ai.conta, '%m/%Y') as conta, c.periodo_ref, (case when c.periodo_ref is null then  CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(SUM(ai.valor_servico), 2),'.',';'),',','.'),';',',')) ELSE ''  END) as valor_total  FROM circuito_arquivo_import_temp as ai left join circuitos_contas as c on c.fatura = ai.contrato and c.periodo_ref = ai.conta group by ai.contrato,ai.conta, c.periodo_ref; ";
        $resultado_listaContasImport = mysqli_query($this->connect(), $consulta_listaContasImport);
        return $resultado_listaContasImport;
    }
    
    function insertContasImport($_nom_arquivo){        
        $consulta_insertContasImport = "  INSERT INTO `circuitos_contas` (`designacao`, `periodo_ref`, `fatura`,`valor_conta`, `nome_arquivo`,`num_linha_arquivo`,`vencimento` ) select designacao,conta,contrato,sum(valor_servico) as valor_conta,nome_arquivo, num_linha_arquivo,vencimento from circuito_arquivo_import_temp where `nome_arquivo` = '$_nom_arquivo'  group by designacao,conta,contrato; ";
        $resultado_insertContasImport = mysqli_query($this->connect(), $consulta_insertContasImport);
        return $resultado_insertContasImport;
    }
    
    function editRegistroConsumo($_nom_arquivo){         
        $consulta_editRegistroConsumo = " update `circuitos_registro_consumo` as t1 join `circuito_arquivo_import_temp` as t2  on t2.`designacao` = t1.`codigo` set t1.`velocidade` = t2.`velocidade_circuito`, t1.`tipo_servico` = t2.`prod_telefone`, t1.`tip_logradouro` = t2.`tip_logradouro`, t1.`nome_logradouro` = t2.`nome_logradouro`, t1.`nome_cidade` = t2.`nome_local`, t1.`num_imovel` = t2.`num_imovel`, t1.`nome_bairro` = t2.`nome_bairro`, t1.`data_ult_ref` = t2.`conta` where t2.`nome_arquivo` = '$_nom_arquivo'; ";
        $resultado_editRegistroConsumo = mysqli_query($this->connect(), $consulta_editRegistroConsumo);
        return $resultado_editRegistroConsumo;
    }
    
    function testeImport($_nom_arquivo){
        $resultado_analitico2 = $this->listaProblemaImport();
        $resultado_listaProblemaImport = $this->listaContasImport();
        foreach ($resultado_listaProblemaImport as $table1){
            $aviso = '';
            foreach ($resultado_analitico2 as $table){
                if(($table["contrato"] == $table1["contrato"])&&($table1['nome_arquivo'] == $_nom_arquivo)){
                    $aviso = '1';
                }
            }
            if (($table1["periodo_ref"] == '')&&($table1['nome_arquivo'] == $_nom_arquivo)){
                $aviso = '' .$aviso;        
            } else {
                $aviso = '2'.$aviso;        
            }
            if($aviso == ''){
                return '1';
            } else {
                return '0';
            }
        }
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
    //retorno 
    function atuTarefas($_consulta){
        $resultado_redmine2 = mysqli_query($this->connectRed(), $_consulta);
        $resultado = array();
        $i = 0;
        foreach ($resultado_redmine2 as $table_redmine2){
            $resultado[$i][0] = $table_redmine2["id"];
            $resultado[$i][1] = $table_redmine2["status_id"];                 
            $resultado[$i][2] = $table_redmine2["start_date"]; //data formatadata yyyy-MM-dd padrão BD
            $resultado[$i][3] = $table_redmine2["due_date"]; //data formatadata yyyy-MM-dd padrão BD
            $resultado[$i][4] = $table_redmine2["login"];
            $i = $i + 1;
        }
        return $resultado;
    }
    function __destruct() {}
}

/**
 * Description of servico
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
        return count($resultado_servicos6);        
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
    
    function atuAutoRed($_qtdTarefas){
        $this->iniEvento(1);
        $tarefa = array();       
        $i = 0;
        $consulta_atuAutoRed = "SELECT s.id, t.cod_tarefa_redmine, c.nome_redu_servico, c.repeticao  FROM servicos_eventos as s inner join servicos_tarefas as t on t.codigo_tarefa = s.id inner join servicos_cadastro as c on c.codigo_servico = t.codigo_sevico where t.cod_tarefa_redmine is not null order by id desc limit $_qtdTarefas;";      
        $resultado_atuAutoRed = mysqli_query($this->connect(), $consulta_atuAutoRed);
        foreach ($resultado_atuAutoRed as $table_atuAutoRed){
            $tarefa[$i][0] =  $table_atuAutoRed["id"];
            $tarefa[$i][1] =  $table_atuAutoRed["cod_tarefa_redmine"];
            $tarefa[$i][2] = $table_atuAutoRed["nome_redu_servico"];
            $tarefa[$i][3] = $table_atuAutoRed["repeticao"];
            $i = $i + 1;
        }       
        $i = 0;
        while (count($tarefa)> $i){
            if ($i != 0){$consulta = $consulta.",";}
            else { $consulta = "SELECT i.id ,tec.login ,i.due_date ,i.start_date ,i.status_id  from issues as i left join users as tec on i.assigned_to_id = tec.id where i.id in (";}
            $consulta = $consulta." '".$tarefa[$i][1]."'";
            $i = $i + 1;
        }
        $consulta = $consulta.");";        
        $redmine = $this->tarefaRedmine->atuTarefas($consulta);        
        $situacao = $this->consSituacao();
        $i = 0;
        while (count($tarefa)> $i){
            $k1 = $i;
            $i2 = 0;
            while (count($redmine) > $i2 ){                
                if ($tarefa[$i][1] == $redmine[$i2][0]){$k2 = $i2;}
                $i2 = $i2 + 1;
            }
            $i2 = 0;
            while (count($situacao) > $i2 ){                
                if ($redmine[$k2][1] == $situacao[$i2][0]){$k3 = $i2;}
                $i2 = $i2 + 1;
            }            
            $update1 = " UPDATE `servicos_tarefas` SET `cod_tarefa_redmine` = '".$tarefa[$k1][1]."', `situacao` = '".$redmine[$k2][1]."' WHERE `codigo_tarefa` = '".$tarefa[$k1][0]."'; ";        
            $resultado_update112 = mysqli_query($this->connect(), $update1);
            $update1 = " UPDATE `servicos_eventos` SET `start` = '".$redmine[$k2][2]."',`title` ='".$tarefa[$k1][2]." - ".$redmine[$k2][4]." - ".$tarefa[$k1][3]."', `end` = '".$redmine[$k2][3]."', `color` = '".$situacao[$k3][2]."', `textColor` = '".$situacao[$k3][1]."' WHERE `id` = '".$tarefa[$k1][0]."'; ";        
            $resultado_update112 = mysqli_query($this->connect(), $update1);            
            $i = $i + 1;            
        }
        $resultado_update112 = mysqli_query($this->connect(), $update1);
        return $resultado_update112;
        
    }
    
    function consSituacao(){
        $situacao = array();       
        $i = 0;
        $consulta_consSituacao = "SELECT * FROM servicos_sit_tarefa;";      
        $resultado_consSituacao = mysqli_query($this->connect(), $consulta_consSituacao);
        foreach ($resultado_consSituacao as $table_consSituacao){
            $situacao[$i][0] =  $table_consSituacao["codigo"];
            $situacao[$i][1] =  $table_consSituacao["cor_texto"];
            $situacao[$i][2] =  $table_consSituacao["cor"];
            $i = $i + 1;
        }
        return $situacao;
    }
            
    function atualizaAutomaticoTarefasRedmine(){
        $consulta_servicos10 = "SELECT * FROM servicos_eventos as s inner join servicos_tarefas as t on t.codigo_tarefa = s.id where t.cod_tarefa_redmine is not null order by id desc limit 100;";      
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
    function cunsultaProxAntUlt($_tarefa){
        $consulta_cunsultaProxAntUlt = "select st.id_evento , st.id_evento_anterior ,pt.id_evento as id_prox_evento , sc.id_ultimo_evento from `servicos_tarefas` as st inner join `servicos_cadastro` as sc on st.codigo_sevico = sc.codigo_servico left join `servicos_tarefas` as pt on st.id_evento = pt.id_evento_anterior where st.id_evento = '$_tarefa';";
        $resultado_cunsultaProxAntUlt = mysqli_query($this->connect(), $consulta_cunsultaProxAntUlt);
        return $resultado_cunsultaProxAntUlt;
    }
    
    function formataDataBR($_data){
       return date('d/m/Y',strtotime($_data));
    }
    
    function __destruct() {}
    
}


class Servico extends Database {
    private $codigo;
    
    private $nomeRedu;
    
    private $descricaoComp;
    
    private $repeticao;
    
    private $dataProxExec;
    
    private $dataUltExec;
    
    private $falhou;
    
    private $idEventoAnt;
    
    function getCodigo(){ return $this->codigo; }
    
    function setCodigo($_codigo){ $this->codigo = $_codigo; }
    
    function getNomeRedu(){ return $this->nomeRedu; }
    
    function setNomeRedu($_nomeRedu){ $this->nomeRedu = $_nomeRedu; }
    
    function getDescricaoComp(){ return $this->descricaoComp; }
    
    function setDescricaoComp($_descricaoComp){ $this->descricaoComp = $_descricaoComp; }
    
    function getRepeticao(){ return $this->repeticao; }
    
    function setRepeticao($_repeticao){ $this->repeticao = $_repeticao; }
    
    function getDataProxExec(){ return $this->dataProxExec;}
    
    function setDataProxExec($_data){ $this->dataProxExec = $_data; }
    
    function getDataUltExec(){ return $this->dataUltExec;}
    
    function setDataUltExec($_data){ $this->dataUltExec = $_data; }
    
    function getFalhou(){ return $this->falhou;}
    
    function setFalhou ($_falhou){ $this->falhou = $_falhou; }
    
    function getidEventoAnt(){ return $this->idEventoAnt;}
        
    function setIdEventoAnt ($_id){ $this->idEventoAnt = $_id; }
    
    function listaServicos($_id, $_nome){
        $consulta_listaServicos = "SELECT * FROM servicos_cadastro "
                            . " where codigo_servico like '%$_id%' and nome_redu_servico like '%$_nome%';";
        $resultado_listaServicos = mysqli_query($this->connect(), $consulta_listaServicos);
        return $resultado_listaServicos;
    }
    function iniServico($_codigo){
        $consulta_iniServico = "SELECT * FROM servicos_cadastro where codigo_servico = '$_codigo';";
        $resultado_iniServico = mysqli_query($this->connect(), $consulta_iniServico);
        foreach ($resultado_iniServico as $table_iniServico){
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
    function manutServico($_codigo, $_nome, $_descricao, $_repeticao){        
        $consulta_manutServico = "UPDATE `servicos_cadastro` SET `nome_redu_servico` = '".$_nome."', `descricao_tipo_servico` = '".$_descricao."', `repeticao` = '".$_repeticao."' WHERE `codigo_servico` = '".$_codigo."'";
        $resultado_manutServico = mysqli_query($this->connect(), $consulta_manutServico);
    }
            
    function formataDataBR($_data){
       return date('d/m/Y',strtotime($_data));
    }
}

/**
 * Description of Zabbix SEED
 *
 * @author tiagoc
 */
class ZabbixSEED extends DatabaseZbx {
    function listLinksPagos(){
        
        $consulta_listLinksPagos = " SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, "
                                ." FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(day, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, " 
                                ." g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a, h.status "
                                ." FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid "
                                ." LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid "
                                ." WHERE g.groupid IN ('28', '31', '29', '32', '30', '33', '392', '394', '395', '396') AND t.templateid IN ('19524' , '13554') AND inte.main = '1'; ";                
        $resultado_listLinksPagos = mysqli_query($this->connectZbx(), $consulta_listLinksPagos);
        
        return $resultado_listLinksPagos;
    }
    
    function listLinksPBLE(){
        $consulta_listLinksPBLE = " SELECT h.name, t.value, (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, "
                                ." FROM_UNIXTIME(t.lastchange) AS data, TIMESTAMPDIFF(day, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, " 
                                ." g.name AS grupo, hi.os AS diretoria, hi.name AS escola, inte.ip, hi.serialno_a, h.status "
                                ." FROM zabbix3.hosts h JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid "
                                ." LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid JOIN zabbix3.items i ON i.hostid = h.hostid JOIN zabbix3.functions f ON f.itemid = i.itemid JOIN zabbix3.triggers t ON t.triggerid = f.triggerid "
                                ." WHERE g.groupid IN ('28') AND t.templateid IN ('19524' , '13554') AND inte.main = '1'; ";                
        $resultado_listLinksPBLE = mysqli_query($this->connectZbx(), $consulta_listLinksPBLE);
        
        return $resultado_listLinksPBLE;
    }
    function listImpr(){
        $consulta_listImpr = " SELECT h.hostid, h.host, h.name, t.value, "
                . " (CASE t.value WHEN 1 THEN 'Down(1)' ELSE 'Up(0)' END) AS situacao, "
                . " FROM_UNIXTIME(t.lastchange) AS data, "
                . " TIMESTAMPDIFF(day, FROM_UNIXTIME(t.lastchange), NOW()) AS tempo_inativo, "
                . " g.name AS grupo, inte.ip, h.status FROM zabbix3.hosts h "
                . " JOIN zabbix3.hosts_groups hg ON h.hostid = hg.hostid "
                . " JOIN zabbix3.groups g ON hg.groupid = g.groupid LEFT "
                . " JOIN zabbix3.host_inventory hi ON hi.hostid = h.hostid "
                . " LEFT JOIN zabbix3.interface inte ON inte.hostid = h.hostid "
                . " JOIN zabbix3.items i ON i.hostid = h.hostid "
                . " JOIN zabbix3.functions f ON f.itemid = i.itemid "
                . " JOIN zabbix3.triggers t ON t.triggerid = f.triggerid "
                . " WHERE g.groupid IN ('15') AND t.templateid IN ('19524' , '13554') AND inte.main = '1' and h.name like '%%' order by ip;  ";                
        $resultado_listImpr = mysqli_query($this->connectZbx(), $consulta_listImpr);
        
        return $resultado_listImpr;
    }
    
    function imprimiAtivo($_codigo){
        if($_codigo == '1'){
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">';
        }elseif ($_codigo == '0') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">';
        }
    }
    
    function imprimiSitu($_codigo){
        if($_codigo == '1'){
            return 'Não';
        }elseif ($_codigo == '0') {
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
    function listArquivosExcluidos($_data){        
        if($_data == ''){
            $_data = '2010-01-01 00:00:00';
        }
        $consulta_listArquivosExcluidos = "   select * from (SELECT * , FROM_UNIXTIME(timestamp) AS data_hora FROM zabbixcofre.history_log) as a1 where a1.value like '%Access Mask:		0x10000%' and a1.logeventid = '4663' and a1.data_hora > '$_data' order by  a1.id asc ; ";                
        $resultado_listArquivosExcluidos = mysqli_query($this->connectZbxCofre(), $consulta_listArquivosExcluidos);        
        return $resultado_listArquivosExcluidos;
    }
    function listArquivosAdicionados($_data){        
        if($_data == ''){
            $_data = '2010-01-01 00:00:00';
        }
        $consulta_listArquivosExcluidos = "   select * from (SELECT * , FROM_UNIXTIME(timestamp) AS data_hora FROM zabbixcofre.history_log) as a1 where a1.value like '%Access Mask:		0x2%' and a1.logeventid = '4663' and a1.data_hora > '$_data' order by  a1.id asc ; ";                
        $resultado_listArquivosExcluidos = mysqli_query($this->connectZbxCofre(), $consulta_listArquivosExcluidos);        
        return $resultado_listArquivosExcluidos;
    }        
}

/**
 * Description of Log Arquivos Rede Local
 *
 * @author tiagoc
 */
class LogArquivos extends Database {
    function insertImportLogArquivo($_linhas){
    $consulta_insertImportLogArquivo = " INSERT INTO `redelocal_log_arquivos` (`codigo_acao`,`data_hora`,`usuario`,`arquivo`,`descricao_acao`) VALUES "
            . implode(',', $_linhas) . ";";                 
    $resultado_insertImportLogArquivo = mysqli_query($this->connect(), $consulta_insertImportLogArquivo);        
    $consulta_insertImportLogArquivo1 = " delete FROM redelocal_log_arquivos where arquivo like '%.tmp%' and codigo > 0";    
    $resultado_insertImportLogArquivo1 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo1);
    $consulta_insertImportLogArquivo2 = " delete FROM redelocal_log_arquivos where arquivo like '%~$%' and codigo > 0";    
    $resultado_insertImportLogArquivo2 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo2);
    $consulta_insertImportLogArquivo3 = " delete FROM redelocal_log_arquivos where arquivo like '%DFSR%' and codigo > 0";    
    $resultado_insertImportLogArquivo3 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo3);  
    $consulta_insertImportLogArquivo4 = " delete FROM redelocal_log_arquivos where arquivo like '%RECYCLE.BIN%' and codigo > 0";    
    $resultado_insertImportLogArquivo4 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo4); 
    $consulta_insertImportLogArquivo5 = " delete FROM redelocal_log_arquivos where arquivo like '%Thumbs.db%' and codigo > 0";    
    $resultado_insertImportLogArquivo5 = mysqli_query($this->connect(), $consulta_insertImportLogArquivo5); 
    return $resultado_insertImportLogArquivo5.$resultado_insertImportLogArquivo.$resultado_insertImportLogArquivo1.$resultado_insertImportLogArquivo2.$resultado_insertImportLogArquivo3.$resultado_insertImportLogArquivo4;
    }
    
    function consArquivos($_data_inicio, $_data_fim, $_usuario, $_arquivo, $_acao){
        $consulta_consArquivos = " select codigo_acao, data_hora, usuario, arquivo, descricao_acao, count(arquivo) as cont_arq "
                . " FROM redelocal_log_arquivos "
                . " where data_hora >= '$_data_inicio' and data_hora <= '$_data_fim' "
                . " and usuario like '%$_usuario%' and arquivo like '%$_arquivo%' and descricao_acao like '%$_acao%' "
                . " group by  codigo_acao, data_hora, usuario, arquivo "
                . " order by  data_hora desc, usuario ,arquivo, codigo_acao; ";           
        $resultado_consArquivos = mysqli_query($this->connect(), $consulta_consArquivos);                
        return $resultado_consArquivos;
    }
    
    function consUltDataDel(){
        $consulta_consUltDataDel = " SELECT max(data_hora) as ult_data FROM homo_sis_geitec.redelocal_log_arquivos where codigo_acao = '0x10000'; ";           
        $resultado_consUltDataDel = mysqli_query($this->connect(), $consulta_consUltDataDel);        
        foreach ($resultado_consUltDataDel as $value) {
            $data_Del = $value['ult_data'];
        }
        return $data_Del;
    }
    
    function consUltDataAdd(){
        $consulta_consUltDataAdd = " SELECT max(data_hora) as ult_data FROM homo_sis_geitec.redelocal_log_arquivos where codigo_acao = '0x2'; ";           
        $resultado_consUltDataAdd = mysqli_query($this->connect(), $consulta_consUltDataAdd);        
        foreach ($resultado_consUltDataAdd as $value1) {
            $data_Add = $value1['ult_data'];
        }
        return $data_Add;
    }
    
    function convert_data_BR_US($_data){
        $dataEN = DateTime::createFromFormat('d/m/Y H:i:s', $_data);
        return $dataEN->format('Y-m-d H:i:s');
    }
    
    function convert_data_US_BR($_data){
        $dataBR = new DateTime($_data);
        return $dataBR->format('d/m/Y H:i:s');
    }    
}

/**
 * Description of Switchs Ativos Rede Local
 *
 * @author tiagoc
 */
class Switchs extends Database {
    
    function listaSwitch($_marca, $_modelo,$_ip,$_bloco,$_setor){
        $consulta_listSwitch = " SELECT sw.codigo as codigo_sw, sw.ip,"
                . " sw.empilhado, sw.numero_empilhamento, sw.ativo as ativo_sw, "
                . " sw.vlan_padrao, sw.data_incl as data_alt_sw, "
                . " msw.descricao as modelo_sw, msw.qtd_portas_eth, "
                . " msw.qtd_portas_fc, msw.gerenciavel, m.descricao as marca_sw, "
                . " r.descricao as descricao_rack, r.setor as setor_rack, "
                . " b.nome as nome_bloco, b.descricao as descricao_bloco "
                . " FROM redelocal_switch as sw "
                . " join redelocal_modelo_switch as msw on msw.codigo = sw.codigo_modelo "
                . " join redelocal_marca as m on m.codigo =  msw.codigo_marca "
                . " join redelocal_rack as r on r.codigo = sw.codigo_rack "
                . " join redelocal_bloco as b on b.codigo = r.codigo_bloco "
                . " where m.descricao like '%$_marca%' and msw.descricao like '%$_modelo%' "
                . " and sw.ip like '%$_ip%' and b.nome like '%$_bloco%' and r.setor like '%$_setor%' order by b.nome asc, r.descricao asc, msw.descricao ;";
        $resultado_listSwitch = mysqli_query($this->connect(), $consulta_listSwitch);
        
        return $resultado_listSwitch;
    }
    function limpaPortaSwitch($_switch, $_porta, $_tipo_porta){
        $consulta_limpaPortaSwitch = " DELETE FROM `redelocal_porta_switch` "
                . " WHERE codigo_switch = '$_switch' and codigo_porta_switch = '$_porta' and tipo_porta = '$_tipo_porta'; ";
        $resultado_limpaPortaSwitch = mysqli_query($this->connect(), $consulta_limpaPortaSwitch);        
        return $resultado_limpaPortaSwitch;
    }
    
    function limpaImpPorta($_hostZabbix){
        $consulta_limpaImpPorta = " DELETE FROM `redelocal_impressora` WHERE `codigo_host_zabbix` = '$_hostZabbix'; ";
        $resultado_limpaImpPorta = mysqli_query($this->connect(), $consulta_limpaImpPorta);        
        return $resultado_limpaImpPorta;
    }
    
    function consImpressoraPorta($_switch, $_porta, $_tipo_porta ){
        $consulta_consImpressoraPorta = " SELECT count(codigo_modelo) as contador, `codigo_modelo`, `codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`codigo_host_zabbix`,`setor` "
                . " FROM `redelocal_impressora` where `codigo_switch` = '$_switch' and `codigo_porta_switch` = '$_porta' and `tipo_porta` = '$_tipo_porta'; ";
        $resultado_consImpressoraPorta = mysqli_query($this->connect(), $consulta_consImpressoraPorta);        
        return $resultado_consImpressoraPorta;
    }
    
    function consImpressoraZbx($_hostZabbix ){
        $consulta_consImpressoraZbx = " SELECT count(codigo_modelo) as contador, `codigo_modelo`, `codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`codigo_host_zabbix`,`setor` "
                . " FROM `redelocal_impressora` where `codigo_host_zabbix` = '$_hostZabbix'; ";
        $resultado_consImpressoraZbx = mysqli_query($this->connect(), $consulta_consImpressoraZbx);
        return $resultado_consImpressoraZbx;
    }
    
    function dadosSwitch($_codigo){
        $consulta_listSwitch = " SELECT sw.codigo as codigo_sw, sw.ip,"
                . " sw.empilhado, sw.numero_empilhamento, sw.ativo as ativo_sw, "
                . " sw.vlan_padrao, sw.data_incl as data_alt_sw, "
                . " msw.descricao as modelo_sw, msw.qtd_portas_eth, "
                . " msw.qtd_portas_fc, msw.gerenciavel, m.descricao as marca_sw, "
                . " r.descricao as descricao_rack, r.setor as setor_rack, "
                . " b.nome as nome_bloco, b.descricao as descricao_bloco "
                . " FROM redelocal_switch as sw "
                . " join redelocal_modelo_switch as msw on msw.codigo = sw.codigo_modelo "
                . " join redelocal_marca as m on m.codigo =  msw.codigo_marca "
                . " join redelocal_rack as r on r.codigo = sw.codigo_rack "
                . " join redelocal_bloco as b on b.codigo = r.codigo_bloco "
                . " where sw.codigo = '$_codigo'; ";
        $resultado_listSwitch = mysqli_query($this->connect(), $consulta_listSwitch);
        
        return $resultado_listSwitch;
    }
    
    function listImprCad(){
        $consulta_listImprCad = " SELECT * FROM `redelocal_impressora` as i; ";
        $resultado_listImprCad = mysqli_query($this->connect(), $consulta_listImprCad);        
        return $resultado_listImprCad;
    }
    
    function listModImpr(){
        $consulta_listModImpr = " SELECT mi.*, mi.descricao as modelo, m.descricao as marca FROM redelocal_modelo_impressora as mi join redelocal_marca as m on m.codigo = mi.codigo_marca; ";
        $resultado_listModImpr = mysqli_query($this->connect(), $consulta_listModImpr);        
        return $resultado_listModImpr;
    }
    
    function listPortasSwitch(){
        $consulta_listPortaSwitch = " SELECT `codigo_switch`, `codigo_porta_switch`, "
                . " `tipo_porta`, `velocidade`, `codigo_vlan`, `observacao`, "
                . " `texto_tela`, `data_alt`, cor, fonte  FROM `redelocal_porta_switch` as psw  inner join redelocal_vlan as v on psw.codigo_vlan = v.codigo; ";
        $resultado_listPortaSwitch = mysqli_query($this->connect(), $consulta_listPortaSwitch);        
        return $resultado_listPortaSwitch;
    }
    
    function listVlan(){
        $consulta_listVlan = " SELECT `codigo`, `nome`, `qtd_hosts`, `descricao`, `rede`, `mascara`, `gateway`,`cor`,`fonte` FROM `redelocal_vlan`; ";
        $resultado_listVlan = mysqli_query($this->connect(), $consulta_listVlan);        
        return $resultado_listVlan;
    }
    function listImpressoras($_bloco, $_rack){
        $consulta_listImpressoras = " select c0.*, c1.codigo_host_zabbix, c1.marca, c1.modelo, c1.colorida, c1.laser, c1.tinta, c1.rede, c1.scanner from (SELECT tpsw.descricao AS 'tipo_porta_desc', r.descricao AS 'rack', b.nome AS 'bloco', b.descricao AS 'bloco_descricao', sw.numero_empilhamento, sw.ip, psw.codigo_switch, psw.codigo_porta_switch, psw.codigo_vlan, psw.tipo_porta FROM redelocal_porta_switch AS psw JOIN redelocal_switch AS sw ON psw.codigo_switch = sw.codigo JOIN redelocal_rack AS r ON sw.codigo_rack = r.codigo JOIN redelocal_bloco AS b ON r.codigo_bloco = b.codigo JOIN redelocal_tipo_porta_sw AS tpsw ON tpsw.codigo = psw.tipo_porta) as c0 left join (SELECT i.codigo_host_zabbix, mi.descricao AS 'modelo', m.descricao AS 'marca', tpsw.descricao AS 'tipo_porta_desc', mi.colorida, mi.laser, mi.tinta, mi.rede, mi.scanner, psw.codigo_switch, psw.codigo_porta_switch, psw.codigo_vlan, psw.tipo_porta FROM redelocal_impressora AS i JOIN redelocal_modelo_impressora AS mi ON mi.codigo = i.codigo_modelo JOIN redelocal_marca AS m ON m.codigo = mi.codigo_marca JOIN redelocal_switch AS sw ON i.codigo_switch = sw.codigo JOIN redelocal_porta_switch AS psw ON psw.codigo_switch = i.codigo_switch AND psw.codigo_porta_switch = i.codigo_porta_switch AND psw.tipo_porta = i.tipo_porta JOIN redelocal_rack AS r ON sw.codigo_rack = r.codigo JOIN redelocal_bloco AS b ON r.codigo_bloco = b.codigo JOIN redelocal_tipo_porta_sw AS tpsw ON tpsw.codigo = psw.tipo_porta) as c1 on c1.codigo_switch = c0.codigo_switch and c0.codigo_porta_switch = c1.codigo_porta_switch and c0.tipo_porta = c1.tipo_porta where c0.codigo_vlan = '300' and c0.bloco like '%$_bloco%' and c0.rack like '%$_rack%' order by c0.bloco, c0.rack, c0.ip; ";
        $resultado_listImpressoras = mysqli_query($this->connect(), $consulta_listImpressoras);        
        return $resultado_listImpressoras;
    }
    function testePorta($_porta, $_switch, $_tipoPorta){
        $consulta_testePorta = " SELECT count(codigo_switch) as cont FROM redelocal_porta_switch "
                . " where codigo_switch = '$_switch' and codigo_porta_switch = '$_porta' and tipo_porta = '$_tipoPorta'; ";
        $resultado_testePorta = mysqli_query($this->connect(), $consulta_testePorta);
        foreach ($resultado_testePorta as $table_testePorta){
            $resutaldo = $table_testePorta["cont"];
        }
        return $resutaldo;
    }
    
    function cadImpressora($_porta, $_switch, $_tipoPorta, $_setor, $_codigo_zabbix, $_codigo_modelo ){
        $consulta_cadImpressora = " INSERT INTO `redelocal_impressora` "
                . " (`codigo_modelo`,`codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`codigo_host_zabbix`,`setor`) "
                . " VALUES ('$_codigo_modelo','$_switch','$_porta','$_tipoPorta','$_codigo_zabbix','$_setor'); ";
        $resultado_cadImpressora = mysqli_query($this->connect(), $consulta_cadImpressora);
        return $resultado_cadImpressora;
    }
    
    function iniPorta($_porta, $_switch, $_tipoPorta){
        $resultado = $this->testePorta($_porta, $_switch, $_tipoPorta);        
        if ($resultado == '1'){
            $consulta_iniPorta = " SELECT p_sw.*, imp.codigo_modelo, imp.setor , imp.codigo_host_zabbix as cod_imp FROM redelocal_porta_switch as p_sw "
                    . " left join redelocal_impressora as imp on imp.codigo_porta_switch = p_sw.codigo_porta_switch and imp.codigo_switch = p_sw.codigo_switch and imp.tipo_porta = p_sw.tipo_porta "
                    . " where p_sw.codigo_switch = '$_switch' and p_sw.codigo_porta_switch = '$_porta' and p_sw.tipo_porta = '$_tipoPorta'; ";
            $resultado_iniPorta = mysqli_query($this->connect(), $consulta_iniPorta);        
        } else {
                $consulta_iniPorta = " SELECT sw.codigo as 'codigo_switch', '$_porta' as 'codigo_porta_switch', '$_tipoPorta' as 'tipo_porta',  msw.velocidade_padrao_portas as 'velocidade', sw.vlan_padrao as 'codigo_vlan', '' as 'observacao' , sw.vlan_padrao as 'texto_tela', now() as 'data_alt', ' ' as cod_imp, '' as codigo_modelo, '' as setor FROM redelocal_switch as sw join redelocal_modelo_switch as msw on msw.codigo = sw.codigo_modelo where sw.codigo = '$_switch'; ";
            $resultado_iniPorta = mysqli_query($this->connect(), $consulta_iniPorta);        
        }
        return $resultado_iniPorta;
    }
    
    function manutPortaSwitch($_porta, $_switch, $_tipoPorta, $_velocidade, $_codigoVlan, $_observacao, $_textoTela, $_dataAlt){
        $resultado = $this->testePorta($_porta, $_switch, $_tipoPorta);        
        if ($resultado == '1'){
            $consulta_manutPortaSwitch2 = " UPDATE `redelocal_porta_switch` SET "
                . "`velocidade` = '$_velocidade', `codigo_vlan` = '$_codigoVlan', "
                . "`observacao` = '$_observacao', `texto_tela` = '$_textoTela', `data_alt` = '$_dataAlt' "
                . " where codigo_switch = '$_switch' and codigo_porta_switch = '$_porta' and tipo_porta = '$_tipoPorta'; ";
        $resultado_manutPortaSwitch2 = mysqli_query($this->connect(), $consulta_manutPortaSwitch2);            
        } elseif ($resultado == '0'){
            $consulta_manutPortaSwitch2 = " INSERT INTO `redelocal_porta_switch` "
                    . " (`codigo_switch`,`codigo_porta_switch`,`tipo_porta`,`velocidade`,`codigo_vlan`,`observacao`,`texto_tela`,`data_alt`)"
                    . " VALUES('$_switch','$_porta','$_tipoPorta','$_velocidade','$_codigoVlan','$_observacao','$_textoTela','$_dataAlt'); ";
        $resultado_manutPortaSwitch2 = mysqli_query($this->connect(), $consulta_manutPortaSwitch2);
        }
        
    }
            function imprimiAtivo($_codigo){
        if($_codigo == '1'){
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">';
        }elseif ($_codigo == '0') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">';
        }
    }
}
