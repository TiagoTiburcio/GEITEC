<?php

/**
 * Description of principal
 *
 * @author tiagoc
 * 
 * Conjunto de classes responsável por controle e manutenção de Usuários, Páginas, Perfis e Módulos
 */
include_once '../class/database.php';
/**
 * 
 */
class PrincipalFuncoes extends Database {
    
    private $usuario;
    private $perfil;
    private $pagina;
    private $modulo;
    private $permissao;
    
    function __construct(){
        $this->usuario = new Usuario();
        $this->perfil = new Perfil();                
        $this->modulo = new Modulo();
        $this->pagina = new Pagina();
        $this->permissao = []; 
    }
        
    function getUsuario(){
        return $this->usuario;
    }
    function getPerfil(){
        return $this->perfil;
    }
    function getPagina(){
        return $this->pagina;
    }
    function getModulo(){
        return $this->modulo;  
    }
    
    function getPermissao(){
        return $this->permissao;  
    }
        
    /**   
//    // 0 - usuario não gravado 1 - usuario existente na Base de Dados
//    private function testeUsuarioCadatrado($_usuario){
//        $consulta_usuario1 = "SELECT count(`usuario`.`id`) as cont FROM `home_usuario` where usuario = '$_usuario';";                                
//        $resultado_usuario1 = mysqli_query($this->connect(), $consulta_usuario1);
//        foreach ($resultado_usuario1 as $table_usuario1){                        
//           $resultado = $table_usuario1["cont"]; 
//        } 
//        return $resultado;
//    }
//    
//    // 0 - usuario não gravado 1 - usuario gravado com sucesso na Base de Dados
//    function insereUsuario($_usuario,$_nome,$_senha){
//        $resultado = '0';
//        if($this->testeUsuarioCadatrado($_usuario) == 0){            
//            $this->setNome($_nome);
//            $this->setUsuario($_usuario);
//            $this->setSenha($this->getSenhaEncriptada($_senha));
//            $this->setAtivo(1);
//            $this->setPerfil(0);
//            $consulta_usuario2 = "INSERT INTO `usuario`(`usuario`,`senha`,`nome_usuario`,`ativo`,`perfil`)VALUES( '".$this->getUsuario()."' , '".$this->getSenha()."' , '".$this->getNome()."' ,".$this->getAtivo().",".$this->getPerfil().");";
//            $resultado_usuario2 = mysqli_query($this->connect(), $consulta_usuario2);            
//            $resultado = '1';
//        }        
//        return $resultado;
//    }
//   
//    // retorna lista com todos os usuarios cadastrados
//    function listaUsuarios(){        
//        $consulta_usuario3 = "SELECT * FROM usuario;";                                
//        $resultado_usuario3 = mysqli_query($this->connect(), $consulta_usuario3);
//        return $resultado_usuario3;
//    }
//    
//    // retorno = 1 - usuario cadastrado 0 - usuario não cadastrado
//    function iniUsuario($_usuario){
//        if ($this->testeUsuarioCadatrado($_usuario) == 1){
//            $consulta_usuario4 = "SELECT * FROM usuario where usuario = '$_usuario';";                                
//            $resultado_usuario4 = mysqli_query($this->connect(), $consulta_usuario4);
//            foreach ($resultado_usuario4 as $table_usuario4){
//                $this->setId($table_usuario4["id"]);
//                $this->setUsuario( $table_usuario4["usuario"]);
//                $this->setNome($table_usuario4["nome_usuario"]);
//                $this->setSenha($table_usuario4["senha"]);
//                $this->setAtivo($table_usuario4["ativo"]);
//                $this->setPerfil($table_usuario4["perfil"]);
//            }            
//        }
//        return $this->testeUsuarioCadatrado($_usuario);
//    }       
//    
//    //Retorno == 0 - erro gravar nova senha na base de dados | == 1 - nova senha gravada com sucesso
//    function gravaNovaSenha($_usuario,$_novaSenha){        
//        if ($this->iniUsuario($_usuario) == 1){            
//            $consulta_usuario5 = "UPDATE `usuario` SET `senha` = '".$this->getSenhaEncriptada($_novaSenha)."' WHERE `id` = '".$this->getId()."';";                                
//            $resultado_usuario5 = mysqli_query($this->connect(), $consulta_usuario5);
//        }
//        return $this->iniUsuario($_usuario);
//    }
//
//    //Retorno == 0 - erro gravar nova senha na base de dados | == 1 - nova senha gravada com sucesso
//    function verificaUsuario($_usuario,$_senha){        
//        $resultado = 0;
//        if ($this->iniUsuario($_usuario) == 1){            
//            if($this->getSenhaEncriptada($_senha) == $this->getSenha()){
//                $resultado = 1;
//            }            
//        }
//        return $resultado;
//    }
//    
//     // 0 - usuario não gravado 1 - usuario gravado com sucesso na Base de Dados
//    function editUsuario($_usuario,$_nome,$_senha){
//        $resultado = '0';
//        if($this->testeUsuarioCadatrado($_usuario) == 1){            
//            $this->iniUsuario($_usuario);
//            $this->setNome($_nome);
//            $this->setUsuario($_usuario);
//            $this->setSenha($this->getSenhaEncriptada($_senha));
//            $this->setAtivo(1);
//            $this->setPerfil(0);                        
//            $consulta_usuario6 = "UPDATE `usuario` SET `usuario` = '".$this->getUsuario()."' , `senha` = '".$this->getSenha()."' , `nome_usuario` = '".$this->getNome()."' ,`ativo` = ".$this->getAtivo()." , `perfil` = ".$this->getPerfil()." WHERE `id` = ".$this->getId().";";
//            $resultado_usuario6 = mysqli_query($this->connect(), $consulta_usuario6);            
//            $resultado = '1';
//        }        
//        return $resultado;
//    }
//    
**/
    private function consultaIniLogin($_usuario){
        $consulta_iniLogin = "SELECT u.codigo as u_codigo "
                . " ,u.usuario as u_usuario ,u.senha as u_senha "
                . " ,u.nome as u_nome ,u.ativo as u_ativo "
                . " ,pe.codigo as pe_codigo ,pe.descricao as pe_descricao "
                . " ,pe.ativo as pe_ativo ,pa.codigo as pa_codigo "
                . " ,pa.descricao as pa_codigo ,pa.caminho as pa_caminho "
                . " ,pa.ativo as pa_ativo ,m.codigo as m_codigo "
                . " ,m.descricao as m_descricao ,m.ativo as m_ativo "
                . " FROM home_usuario as u "
                . " join home_perfil as pe on pe.codigo = u.codigo_perfil "
                . " join home_pagina_perfil as pape on pape.codigo_perfil = pe.codigo "
                . " join home_pagina as pa on pape.codigo_pagina = pa.codigo "
                . " join home_modulo as m on pa.codigo_modulo =  m.codigo "
                . " where usuario = '$_usuario' and u.ativo = '1' and pe.ativo = '1' and pa.ativo = '1' and m.ativo = '1'; ";
        $resultado_iniLogin = mysqli_query($this->connect(), $consulta_iniLogin);
        return $resultado_iniLogin;
    }
      
    function iniLogin($_usuario){
    
        $resultado_iniLogin = $this->consultaIniLogin($_usuario);
        
        $retorno = mysqli_num_rows($resultado_iniLogin);
        if (mysqli_num_rows($resultado_iniLogin) > 0) {
            $retorno = 1;
            $cont = 0;            
            foreach ($resultado_iniLogin as $table_iniLogin){
                $this->perfil->iniPerfil($table_iniLogin["pe_codigo"], $table_iniLogin["pe_descricao"], $table_iniLogin["pe_ativo"]);
                $this->usuario->iniUsuario($table_iniLogin["u_codigo"], $table_iniLogin["u_usuario"], $table_iniLogin["u_senha"], $table_iniLogin["u_nome"], $table_iniLogin["u_ativo"], $this->perfil);
                //$this->modulo->iniModulo($table_iniLogin["m_codigo"], $table_iniLogin["m_descricao"], $table_iniLogin["m_ativo"]);
                //$this->pagina->iniPagina($table_iniLogin["pa_codigo"], $table_iniLogin["pa_descricao"], $table_iniLogin["pa_ativo"], $table_iniLogin["pa_caminho"], $this->modulo);
                $this->permissao[$cont] = [$table_iniLogin["pa_codigo"], $table_iniLogin["pa_descricao"], $table_iniLogin["pa_ativo"], $table_iniLogin["pa_caminho"],$table_iniLogin["m_codigo"], $table_iniLogin["m_descricao"], $table_iniLogin["m_ativo"]];
                $cont = $cont + 1;
            } 
        }        
        return $retorno;
    }
    
    function validaSessao(){        
//            session_start();
            include ("../class/header.php");

//            //Caso o usuário não esteja autenticado, limpa os dados e redireciona
//            if ( !isset($_SESSION['login']) and !isset($_SESSION['pass']) ) {
//                //Destrói
//                session_destroy();
//
//                //Limpa
//                unset ($_SESSION['login']);
//                unset ($_SESSION['pass']);
//                unset ($_SESSION['nome_usuario']);
//
//                //Redireciona para a página de autenticação
//                echo '<META http-equiv="refresh" content="0;../home/login.php">';
//            }        
        }
}    

class Usuario {
    private $codigo;
    
    private $usuario;
    
    private $nome;
    
    private $senha;
    
    private $ativo;
    
    private $perfil;
    
    function __construct(){ }

    private function setCodigo($_codigo){
        $this->codigo = $_codigo;
    }

    function getCodigo(){
        return $this->codigo;
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
    
    private function setAtivo($_ativo){
        $this->ativo = $_ativo;
    }
            
    function getAtivo(){
        return $this->ativo;
    }
    
    private function setPerfil($_perfil){
        $this->perfil = new Perfil();
        $this->perfil = $_perfil;
    }
            
    function getPerfil(){
        return $this->perfil;
    }
    
    function getSenhaEncriptada($_senha){
        $resultado = sha1($_senha);
        return $resultado;
    }
    
    function iniUsuario($_codigo, $_usuario, $_senha, $_nome, $_ativo,$_perfil){
        $this->setCodigo($_codigo);
        $this->setUsuario($_usuario);
        $this->setSenha($_senha);
        $this->setNome($_nome);
        $this->setAtivo($_ativo);
        $this->setPerfil($_perfil);
    }
    
    function __destruct() {}
}

class Perfil {
    private $codigo;
    private $descricao;
    private $ativo;
    function __construct(){ }
    private function setCodigo($_codigo){
        $this->codigo = $_codigo;
    }

    function getCodigo(){
        return $this->codigo;
    }
    
    private function setDescricao($_descricao){
        $this->descricao = $_descricao;
    }

    function getDescricao(){
        return $this->descricao;
    }
    
     private function setAtivo($_ativo){
        $this->ativo = $_ativo;
    }

    function getAtivo(){
        return $this->ativo;
    }
    
    function iniPerfil($_codigo, $_descricao, $_ativo){
        $this->setCodigo($_codigo);
        $this->setDescricao($_descricao);
        $this->setAtivo($_ativo);
    }
    
    function __destruct() {}
}

class Modulo {
    private $codigo;
    private $descricao;
    private $ativo;
    function __construct(){ }
    private function setCodigo($_codigo){
        $this->codigo = $_codigo;
    }

    function getCodigo(){
        return $this->codigo;
    }
    
    private function setDescricao($_descricao){
        $this->descricao = $_descricao;
    }

    function getDescricao(){
        return $this->descricao;
    }
    
     private function setAtivo($_ativo){
        $this->ativo = $_ativo;
    }

    function getAtivo(){
        return $this->ativo;
    }
    
    function iniModulo($_codigo, $_descricao, $_ativo){
        $this->setCodigo($_codigo);
        $this->setDescricao($_descricao);
        $this->setAtivo($_ativo);
    }
    function __destruct() {}
}

class Pagina {
    private $codigo;
    private $descricao;
    private $ativo;
    private $caminho;
    private $modulo;
    function __construct(){ }
    private function setCodigo($_codigo){
        $this->codigo = $_codigo;
    }

    function getCodigo(){
        return $this->codigo;
    }
    
    private function setDescricao($_descricao){
        $this->descricao = $_descricao;
    }

    function getDescricao(){
        return $this->descricao;
    }
    
    private function setAtivo($_ativo){
        $this->ativo = $_ativo;
    }

    function getAtivo(){
        return $this->ativo;
    }
    
    private function setCaminho($_caminho){
        $this->caminho = $_caminho;
    }

    function getCaminho(){
        return $this->caminho;
    }
    
    private function setModulo($_modulo){
        $this->modulo = $_modulo;
    }

    function getModulo(){
        return $this->modulo;
    }
    
    function iniPagina($_codigo, $_descricao, $_ativo, $_caminho, $_modulo){
        $this->setCodigo($_codigo);
        $this->setDescricao($_descricao);
        $this->setAtivo($_ativo);
        $this->setCaminho($_caminho);
        $this->setModulo($_modulo);
    }
    
    function __destruct() {}
}