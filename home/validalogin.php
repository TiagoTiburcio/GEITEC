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
    $teste = $u1->iniUsuario($login);
    if (($teste == 1) && ($u1->getAtivo() == 1)) {
        if ($u1->getTipoLogin() == '0') {
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
                $_SESSION['pass'] = $u1->getSenha();
                $_SESSION['nome_usuario'] = $record->getName();

                echo '<META http-equiv="refresh" content="0;../home/index.php">';
            } catch (\Adldap\Auth\BindException $e) {
                echo '<META http-equiv="refresh" content="0;../home/login.php?erro=1">';
            }
        } elseif ($u1->getTipoLogin() == '1') {
            if ($u1->getSenha() == $u1->getSenhaEncriptada($pass_branco)) {
                // session_start inicia a sessão
                $_SESSION['login'] = $u1->getUsuario();
                $_SESSION['pass'] = $u1->getSenha();
                $_SESSION['nome_usuario'] = $u1->getNome();
                echo '<META http-equiv="refresh" content="0;../home/index.php">';
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
} else {
    echo '<META http-equiv="refresh" content="0;../home/login.php?erro=3">';
}
