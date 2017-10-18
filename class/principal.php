<?php

/**
 * Description of usuario
 *
 * @author tiagoc
 */
include_once '../class/database.php';

class Usuario extends database {
    private $codigo;
    
    private $usuario;
    
    private $nome;
    
    private $senha;
    
    private $ativo;
    
    private $perfil;
    
    function __construct(){ }

    function setCodigo($_codigo){
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
        $_perfil = new Perfil();
        $this->perfil = $_perfil;
    }
            
    function getPerfil(){
        return $this->perfil;
    }
    
    private function getSenhaEncriptada($_senha){
        $resultado = sha1($_senha);
        return $resultado;
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
    
    function __destruct() {}
}

class Perfil extends database {
    private $codigo;
    private $descricao;
    private $ativo;
}

class Modulo extends database {
    private $codigo;
    private $descricao;
    private $ativo;
}

class Pagina extends database {
    private $codigo;
    private $descricao;
    private $ativo;
    private $caminho;
    private $modulo;
}

class Seguranca extends database {
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
}    