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
abstract class databaseRed {
    
    private static $host     = "172.25.76.76";   
    private static $user     = "painel";
    private static $password = "painel74123698";
    private static $db       = "bitnami_redmine";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$host;}   
    private function getUser()    {return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB()      {return self::$db;}
     
    function connectRed(){
        $conexaoRed = mysqli_connect($this->getHost(), $this->getUser(), $this->getPassword(), $this->getDB());
        if (mysqli_connect_errno()){
                echo "Falha na conexão: ". mysqli_connect_errno() ;
        }
        if (!mysqli_set_charset($conexaoRed, "utf8")) {
            printf("Error loading character set utf8: %s\n", mysqli_error($conexao));
            exit();
        } else {
            mysqli_character_set_name($conexaoRed);
        }
        return $conexaoRed;
    }
    function close(){              
    } 
}
