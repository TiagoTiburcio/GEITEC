<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();    
    $servicos = new Servicos();
    $redmine = new Redmine();
    
    $usuario->validaSessao();

?>                
    <div class="col-xs-12">
          
    <?php
        echo "Numeros tarefas: ".$servicos->iniTarefaHoje();
    ?>
        
    </div>
    </div>
<?php
include ("../class/footer.php");
