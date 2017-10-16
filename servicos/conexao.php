<?php

$hostname = '10.24.0.59';
$username = 'root';
$password = 'seedqawsed';
$database = 'homo_sis_geitec';
 
try {
    $conexao = new PDO("mysql:host=$hostname;dbname=$database", $username, $password,
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    //echo 'Conexao efetuada com sucesso!';
    }
catch(PDOException $e)
    {
    	echo $e->getMessage();
    }