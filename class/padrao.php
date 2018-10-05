<?php

/**
 * Description of tarefas
 *
 * @author tiagoc
 */
class RotinasPublicas {

    function getTelas($_url, $_nome) {
        //This is the file where we save the    information
        $fp = fopen(".." . "/images/temp/$_nome", 'w+');
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ", "%20", $_url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // get curl response
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    function validaSessao($_teste) {
        session_start();
        //Caso o usuário não esteja autenticado, limpa os dados e redireciona
        if (!isset($_SESSION['login']) and ! isset($_SESSION['pass'])) {
            //Destrói
            session_destroy();
            //Limpa
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            unset($_SESSION['nome_usuario']);
            //Redireciona para a página de autenticação
            echo '<META http-equiv="refresh" content="0;../home/login.php">';
            return 0;
        } else {
            $usuario = new Usuario();
            $usuario->iniUsuario($_SESSION['login']);
            $_SESSION['pagina'] = $_teste;
            include ("../class/header.php");
            if (($_teste == '2') || ($_teste == '4')) {
                
            } else {
                include ("../class/baropc.php");
            }
            return 1;
        }
    }

    function imprimiAtivo($_codigo) {
        if ($_codigo == '0') {
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">NOK</span>';
        } elseif ($_codigo == '1') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">OK</span>';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">N/C</span>';
        }
    }

    function imprimiInverso($_codigo) {
        if ($_codigo == '1') {
            return '<span class="glyphicon glyphicon-remove-circle btn-danger">NOK</span>';
        } elseif ($_codigo == '0') {
            return '<span class="glyphicon glyphicon-ok-circle btn-success">OK</span>';
        } else {
            return '<span class="glyphicon glyphicon-ban-circle">N/C</span>';
        }
    }

    //Upload a blank cookie.txt to the same directory as this file with a CHMOD/Permission to 777
    function login($url, $data, $sistema) {
        $fp = fopen("../temp/$sistema.txt", "w");
        fclose($fp);
        $login = curl_init();
        curl_setopt($login, CURLOPT_COOKIEJAR, "../temp/$sistema.txt");
        curl_setopt($login, CURLOPT_COOKIEFILE, "../temp/$sistema.txt");
        curl_setopt($login, CURLOPT_TIMEOUT, 40000);
        curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($login, CURLOPT_URL, $url);
        curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($login, CURLOPT_POST, TRUE);
        curl_setopt($login, CURLOPT_POSTFIELDS, $data);
        ob_start();
        return curl_exec($login);
        ob_end_clean();
        curl_close($login);
        unset($login);
    }

    function grab_page($site, $_nome, $sistema) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_COOKIEFILE, "../temp/$sistema.txt");
        curl_setopt($ch, CURLOPT_URL, $site);

        $fp = fopen(".." . "/images/temp/$_nome", 'w+');
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        ob_start();
        return curl_exec($ch);
        ob_end_clean();
        curl_close($ch);
    }

    function post_data($site, $data, $sistema) {
        $datapost = curl_init();
        $headers = array("Expect:");
        curl_setopt($datapost, CURLOPT_URL, $site);
        curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
        curl_setopt($datapost, CURLOPT_HEADER, TRUE);
        curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($datapost, CURLOPT_POST, TRUE);
        curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
        curl_setopt($datapost, CURLOPT_COOKIEFILE, "../temp/$sistema.txt");
        ob_start();
        return curl_exec($datapost);
        ob_end_clean();
        curl_close($datapost);
        unset($datapost);
    }

    function logMe($msg) {
        // Abre ou cria o arquivo bloco1.txt
        // "a" representa que o arquivo é aberto para ser escrito
        $fp = fopen("../temp/log.txt", "a");

        // Escreve a mensagem passada através da variável $msg
        $escreve = fwrite($fp, $msg);

        // Fecha o arquivo
        fclose($fp);
    }

}
