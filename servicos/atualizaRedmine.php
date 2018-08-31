<?php
include_once '../class/principal.php';
$rotina = new RotinasPublicas();
if ($rotina->validaSessao('1') == 1) {
    $servicos = new Servicos();
    $redmine = new Redmine();
    ?>                
    <div class="col-xs-12">
        <?php
        echo "Atualiza as utilams 1.000 tarefas: " . $servicos->atuAutoRed(1000);
        ?>
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}