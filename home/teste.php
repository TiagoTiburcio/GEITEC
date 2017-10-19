<?php
    include '../class/principal.php';
    
    $principal = new PrincipalFuncoes();
    $principal->validaSessao();
      
    $usuario = new Usuario();
    $perfil = new Perfil();  
    $pagina = new Pagina();
    $modulo = new Modulo();
?>
        <div class="col-xs-2">                        
            
        </div>
            <div class="col-xs-10">
                <?php                                               
                    $retorno = $principal->iniLogin('tiagoc');                
                $usuario =  $principal->getUsuario();
                $perfil = $usuario->getPerfil(); 
                    echo "Qtd Linhas: ".$retorno;
                    echo "<br/>Usuario Nome: ".$usuario->getNome();
                    echo "<br/>Descricao Perfil: ".$perfil->getDescricao();
                    echo "<br/>Usuario: ".$usuario->getNome();
                    $permissao = $principal->getPermissao();
                    for ( $a=0; count($permissao)<$a; $a++ ) {
                        $pagina = $permissao[$a];                        
                        echo "<br/> Pagina: ".$pagina->getDescricao().$a;
                    }
                ?>         
            </div>
        </div>
<?php
include ("../class/footer.php");