<?php

include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('2', '22') == 1) {
    
    $perfil = new Perfil();
    $usr_sessao = $_SESSION['login'];
    if (filter_input(INPUT_POST, 'id') == '' || filter_input(INPUT_POST, 'id') == '0'){
        $id_perfil = $perfil->proxID();
    } else {
        $id_perfil = filter_input(INPUT_POST, 'id');
    }        
    $desc_perfil = filter_input(INPUT_POST, 'descricao');
    $ativo_perfil = filter_input(INPUT_POST, 'ativo');
    echo 'ID: '.$id_perfil.'<br/>Nome Perfil: '.$desc_perfil.'<br/>Ativo: '.$ativo_perfil.'<br/>';
    $sql = array();
    if (isset($_POST["permitidos"])) {
        $sql = array();
        foreach ($_POST["permitidos"] as $opcao) {
            $sql[] = "('$opcao','$id_perfil')";
        }        
    }
    $resutado = $perfil->inserePermissao($id_perfil, $ativo_perfil, $desc_perfil, $sql);
    date_default_timezone_set("America/Bahia");
    $data = date('Y-m-d H:i:s');



//    if ($resultado == '1') {
//        echo '<br/> usuario atualizado!';
//    } else {
//        echo '<br/> usuario novo!';
//    }
    header('location:listarperfil.php');  
}    