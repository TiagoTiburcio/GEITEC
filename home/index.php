<?php
    include_once '../class/usuario.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
?>
        <div class="col-xs-2">                        
            
        </div>
            <div class="col-xs-10">
              <?php
            //$teste = $usuario->insereUsuario('testando','asdsaddadadadadadad','12345678');
            //echo " Resultado teste: ".$teste;
//            $usarios = $usuario->listaUsuarios();
//            foreach ($usarios as $table_usuario){                        
//                $login_usuario = $table_usuario["usuario"];
//                $nome_usuario = $table_usuario["nome_usuario"];
//                $senha_usuario = $table_usuario["senha"];
//                $ativo_usuario = $table_usuario["ativo"];
//                $perfil_usuario = $table_usuario["perfil"];
//                echo "Login: ".$login_usuario."Nome: ".$nome_usuario." Senha: ".$senha_usuario." Ativo: ".$ativo_usuario." Senha: ".$perfil_usuario."<br/>";
//            }

            $usuario->iniUsuario('tiagoc');
            
//            $teste = $usuario->gravaNovaSenha('tiagoc', '12345');
//            
//            echo "Login: ".$usuario->getId()."Nome: ".$usuario->getNome()."<br/>".$teste;
//            
            $teste1 = $usuario->verificaUsuario('tiagoc', '12345');
            
            echo "Login: ".$usuario->getId()."Nome: ".$usuario->getNome()." Senha: ".$usuario->getSenha()."<br/>".$teste1;
            
        ?>         
            </div>
        </div>
<?php
include ("../class/footer.php");