<?php
require '../vendor/autoload.php';
// Construct new Adldap instance.
include '../class/principal.php';
$login = $_POST['login'];
$pass_branco = $_POST['pass'];
$user = $login;
$domain = "seed.se.gov";
$login = $user."@".$domain;
$senha = $pass_branco;

$u1 = new Usuario();

$teste = $u1->iniUsuario($user);

if ($teste == 1 ){        
    $ad = new \Adldap\Adldap();
    $config = [  
      'domain_controllers'    => ['seed-srv-001.seed.se.gov', 'seed-srv-002.seed.se.gov'],
      'base_dn'               => 'DC=seed,DC=se,DC=gov',
      'admin_username'        => $login,
      'admin_password'        => $senha,
    ];
    $ad->addProvider($config);
    try {
        $provider = $ad->connect();   
        $record = $provider->search()->users()->find($user);        
    	session_start();
	
	$_SESSION['login'] = $record->getAccountName();
	$_SESSION['pass'] = $u1->getSenha();
        $_SESSION['nome_usuario'] = $record->getName();
        
	echo '<META http-equiv="refresh" content="0;../home/index.php">';//$record->getName().'<br/>'.$record->getAccountName()
      
    } catch (\Adldap\Auth\BindException $e) {
        echo '<META http-equiv="refresh" content="0;../home/login.php">';
    }
} else {
    echo '<META http-equiv="refresh" content="0;../home/login.php">';
}