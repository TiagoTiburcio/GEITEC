<?php
    include_once '../class/principal.php';
    
    $rotina = new RotinasPublicas();
    if ($rotina->validaSessao('') == 1){
        
    $servicos = new Servicos();
    $redmine = new Redmine();

?>                
    <div class="col-xs-12">
          
    <?php
        echo "Numeros tarefas: ".$servicos->iniTarefaHoje();
    ?>
        
    </div>
    </div>
<?php
    include ("../class/footer.php");
    }