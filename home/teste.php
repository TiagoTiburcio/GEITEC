<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include_once '../class/principal.php';
            $usuario = new Usuario();
            echo $usuario->iniUsuario("tiagoc");
            echo "<br/> Usuário: ".$usuario->getCodigo();
            echo "<br/> Nome: ".$usuario->getNome();
            echo "<br/> Senha: ".$usuario->getSenha();
        ?>
    </body>
</html>
