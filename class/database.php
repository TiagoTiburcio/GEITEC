<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author tiagoc
 */
abstract class Database {
           
    private static $host     = "172.25.76.85";   
    private static $user     = "geitec";
    private static $password = "seedqawsed";
    private static $db       = "homo_sis_geitec";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$host;}   
    private function getUser()    {return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB()      {return self::$db;}
     
    function connect(){
        $conexao = mysqli_connect($this->getHost(), $this->getUser(), $this->getPassword(), $this->getDB());
        if (mysqli_connect_errno()){
                echo "Falha na conexão: ". mysqli_connect_errno() ;
        }        
        if (!mysqli_set_charset($conexao, "utf8")) {
            printf("Error loading character set utf8: %s\n", mysqli_error($conexao));
            exit();
        } else {
            mysqli_character_set_name($conexao);
        }
        return $conexao;
    }
    
    function close(){              
    } 
}

abstract class DatabaseOI {
    

    private static $hostOI     = "10.24.0.59";   
    private static $userOI     = "contas";
    private static $passwordOI = "74123698contas";
    private static $dbOI       = "Circuitos_OI";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$hostOI;}   
    private function getUser()    {return self::$userOI;}
    private function getPassword(){return self::$passwordOI;}
    private function getDB()      {return self::$dbOI;}
     
    function connectOI(){
        $conexaoOI = mysqli_connect($this->getHost(), $this->getUser(), $this->getPassword(), $this->getDB());
        if (mysqli_connect_errno()){
                echo "Falha na conexão: ". mysqli_connect_errno() ;
        }
        return $conexaoOI;
    }
    function close(){              
    } 
}

abstract class DatabaseRed {
    
    private static $hostRed     = "172.25.76.76";   
    private static $userRed     = "painel";
    private static $passwordRed = "painel74123698";
    private static $dbRed       = "bitnami_redmine";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$hostRed;}   
    private function getUser()    {return self::$userRed;}
    private function getPassword(){return self::$passwordRed;}
    private function getDB()      {return self::$dbRed;}
     
    function connectRed(){
        $conexaoRed = mysqli_connect($this->getHost(), $this->getUser(), $this->getPassword(), $this->getDB());
        if (mysqli_connect_errno()){
                echo "Falha na conexão: ". mysqli_connect_errno() ;
        }
        if (!mysqli_set_charset($conexaoRed, "utf8")) {
            printf("Error loading character set utf8: %s\n", mysqli_error($conexaoRed));
            exit();
        } else {
            mysqli_character_set_name($conexaoRed);
        }
        return $conexaoRed;
    }
    function close(){              
    } 
}

abstract class DatabaseZbx {
    
    private static $hostzbx     = "172.25.76.85";  
    private static $userzbx     = "geitec";
    private static $passwordzbx = "seedqawsed";
    private static $dbzbx       = "zabbix3";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$hostzbx;}   
    private function getUser()    {return self::$userzbx;}
    private function getPassword(){return self::$passwordzbx;}
    private function getDB()      {return self::$dbzbx;}
     
    function connectZbx(){
        $conexaoZbx = mysqli_connect($this->getHost(), $this->getUser(), $this->getPassword(), $this->getDB());
        if (mysqli_connect_errno()){
                echo "Falha na conexão: ". mysqli_connect_errno() ;
        }
        if (!mysqli_set_charset($conexaoZbx, "utf8")) {
            printf("Error loading character set utf8: %s\n", mysqli_error($conexaoZbx));
            exit();
        } else {
            mysqli_character_set_name($conexaoZbx);
        }
        return $conexaoZbx;
    }
    function close(){              
    } 
}

abstract class DatabaseZbxCofre {
    
    private static $hostZbxCofre     = "172.25.76.85";  
    private static $userZbxCofre     = "geitec";
    private static $passwordZbxCofre = "seedqawsed";
    private static $dbZbxCofre       = "zabbixcofre";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$hostZbxCofre;}   
    private function getUser()    {return self::$userZbxCofre;}
    private function getPassword(){return self::$passwordZbxCofre;}
    private function getDB()      {return self::$dbZbxCofre;}
     
    function connectZbxCofre(){
        $conexaoZbxCofre = mysqli_connect($this->getHost(), $this->getUser(), $this->getPassword(), $this->getDB());
        if (mysqli_connect_errno()){
                echo "Falha na conexão: ". mysqli_connect_errno() ;
        }
        if (!mysqli_set_charset($conexaoZbxCofre, "utf8")) {
            printf("Error loading character set utf8: %s\n", mysqli_error($conexaoZbxCofre));
            exit();
        } else {
            mysqli_character_set_name($conexaoZbxCofre);
        }
        return $conexaoZbxCofre;
    }
    function close(){              
    } 
}


