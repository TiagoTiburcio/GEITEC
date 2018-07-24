<?php
include_once '../class/principal.php';
$conec = new DatabaseCalendar();
$hostname = $conec::$host;
$username = $conec::$user;
$password = $conec::$password;
$database = $conec::$db;
 
try {
    $conexao = new PDO("mysql:host=$hostname;dbname=$database", $username, $password,
	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    //echo 'Conexao efetuada com sucesso!';
    }
catch(PDOException $e)
    {
    	echo $e->getMessage();
    }