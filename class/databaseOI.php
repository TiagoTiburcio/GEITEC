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
abstract class databaseOI {
    

    private static $host     = "10.24.0.59";   
    private static $user     = "contas";
    private static $password = "74123698contas";
    private static $db       = "Circuitos_OI";
     
    /*Metodos que trazem o conteudo da variavel desejada
    @return   $xxx = conteudo da variavel solicitada*/
    
    private function getHost()    {return self::$host;}   
    private function getUser()    {return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB()      {return self::$db;}
     
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
