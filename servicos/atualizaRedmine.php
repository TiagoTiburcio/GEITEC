<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();    
    $servicos = new Servicos();
    $redmine = new Redmine();
    
    $usuario->validaSessao();

?>                
    <div class="col-xs-12">
          
    <?php
        echo "Atualiza as utilams 10.000 tarefas: ".$servicos->atuAutoRed(10000);
    ?>
        
    </div>
    </div>
<?php
include ("../class/footer.php");
