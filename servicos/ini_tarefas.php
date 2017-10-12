<?php
    include_once '../class/usuario.php';     
    include_once '../class/servicos.php';
    include_once '../class/redmine.php';
    
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
