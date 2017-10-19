<?php
    include_once '../class/principal.php';
    
    $principal = new PrincipalFuncoes();
    $principal->validaSessao();

?>
        <div class="col-xs-2">                        
            
        </div>
            <div class="col-xs-10">
                <?php                                               
                    $principal->iniLogin('tiagoc');
                    $u_teste = $principal->usuario;
                    echo "Usuario: ";
                ?>         
            </div>
        </div>
<?php
include ("../class/footer.php");