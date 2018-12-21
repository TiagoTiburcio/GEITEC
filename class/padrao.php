<?php

/**
 * Description of Rotinas Publicas
 * Classse com rotinas comuns a todo o sistema 
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

    function validaSessao($_teste, $_codigo_pagina) {
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
            $validaSistema = new ValidacaoSistema();
            $_SESSION['pagina'] = $_teste;            
            $retorno = $validaSistema->testePagina($_SESSION['login'], $_codigo_pagina);            
            if (($_teste == '2') || ($_teste == '4')) {              
            } else {
                include ("../class/baropc.php");
            }
            return $retorno;
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

/**
 * Description of Validacao Sistema
 * Classse com rotinas de validação de páginas no banco
 *
 * @author tiagoc
 */
class ValidacaoSistema extends Database {

    function testePagina($_usuario, $_codigo_pagina) {
        $consulta = " SELECT hu.codigo as cod_usuario, hu.usuario, pag.codigo as cod_pagina, pag.descricao, count(pag.codigo) as cont FROM home_pagina AS pag JOIN home_pagina_perfil AS hpp ON hpp.codigo_pagina = pag.codigo JOIN home_usuario AS hu ON hu.codigo_perfil = hpp.codigo_perfil WHERE hu.usuario = '$_usuario' AND pag.codigo = '$_codigo_pagina' AND pag.ativo = '1'; ";
        $resultado = mysqli_query($this->connect(), $consulta);
        foreach ($resultado as $table) {
            if ($table['cont'] == '1') {
                include ("../class/header.php"); 
                return $table['cont'];
            } else {                
               echo '<META http-equiv="refresh" content="0;../home/index.php?erro=1">';             
               return $table['cont'];
            }
        }
    }

}
