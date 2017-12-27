<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
?>
        <div class="col-xs-2">                        
            
        </div>
            <div class="col-xs-10">
              <?php 
                $servicos = new Servicos();
               
              ?>
            </div>
        </div>
<?php
include ("../class/footer.php");