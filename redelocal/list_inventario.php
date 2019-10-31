<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('', '25') == 1) {
    $glpi = new Glpi();
    $lista_computadores = $glpi->listaComputadores();
    ?>
    <div class="col-lg-12">
        <div class="col-xs-6 col-xs-3">
            <br /><a id="linkprint" type="button" class="btn btn-info" target="_blank" href="../circuitos/relatorios/inventario.php">Imprimir Relatório Computadores<span class="glyphicon glyphicon-print"></span></a>           
        </div>
        <iframe src="inventario.php" width="100%" height="90%" style="border: 0px;"></iframe>
    </div>
<?php
}
