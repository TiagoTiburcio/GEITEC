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

}
