<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if($usuario->validaSessao('1') == 1){
    
    
?>
    <div class="col-xs-offset-1 col-xs-10">                        
        <div id='calendario'>        
        </div>
    </div>
    <div class="col-xs-1">

    </div>
    </div>
<?php
include ("../class/footer.php");
    }