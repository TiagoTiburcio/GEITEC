<?php

require '../vendor/autoload.php';

include '../class/principal.php';

$login = filter_input(INPUT_POST, 'login');
$pass_branco = filter_input(INPUT_POST, 'pass');

if (($login != '') || ($pass_branco != '')) {
    if (!session_id()) {
        session_start();
    }
    $u1 = new Usuario();
    $dadosUsuario = $u1->iniUsuario($login);
    foreach ($dadosUsuario as $table) {
        if (($table['cont'] == 1) && ($table['ativo'] == 1)) {
            if ($table['metodo_login'] == '0') {
                // Construct new Adldap instance.
                $user = $login;
                $domain = "seed.se.gov";
                $login = $user . "@" . $domain;
                $senha = $pass_branco;
                $ad = new \Adldap\Adldap();
                $config = [
                    'domain_controllers' => ['172.25.76.51', 'seed-srv-002.seed.se.gov'],
                    'base_dn' => 'DC=seed,DC=se,DC=gov',
                    'admin_username' => $login,
                    'admin_password' => $senha,
                ];
                $ad->addProvider($config);
                try {
                    $provider = $ad->connect();
                    $record = $provider->search()->users()->find($user);
                    $_SESSION['login'] = $record->getAccountName();
                    $_SESSION['pass'] = $table['senha'];
                    $_SESSION['nome_usuario'] = $record->getName();

                    header('location:index.php');
                    
                } catch (\Adldap\Auth\BindException $e) {
                    echo '<META http-equiv="refresh" content="0;../home/login.php?erro=1">';
                }
            } elseif ($table['metodo_login'] == '1') {
                if ($table['senha'] == $u1->getSenhaEncriptada($pass_branco)) {
                    // session_start inicia a sessão
                    $_SESSION['login'] = $table['usuario'];
                    $_SESSION['pass'] = $table['senha'];
                    $_SESSION['nome_usuario'] = $table['nome'];
                    header('location:index.php');
                }
                //Caso contrário redireciona para a página de autenticação
                else {
                    //Destrói                
                    session_destroy();
                    //Limpa
                    if (isset($_SESSION['login'])) {
                        unset($_SESSION['login']);
                    }
                    if (isset($_SESSION['pass'])) {
                        unset($_SESSION['pass']);
                    }
                    if (isset($_SESSION['nome_usuario'])) {
                        unset($_SESSION['nome_usuario']);
                    }
                    unset($u1);

                    //Redireciona para a página de autenticação
                    echo '<META http-equiv="refresh" content="0;../home/login.php?erro=1">';
                }
            } else {
                echo '<META http-equiv="refresh" content="0;../home/login.php?erro=4">';
            }
        } else {
            echo '<META http-equiv="refresh" content="0;../home/login.php?erro=2">';
        }
    }
} else {
    echo '<META http-equiv="refresh" content="0;../home/login.php?erro=3">';
}
