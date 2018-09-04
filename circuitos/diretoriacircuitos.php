<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('') == 1) {

    $filtro_diretoria = filter_input(INPUT_GET, 'dre');
    $filtro_situacao = filter_input(INPUT_GET, 'sit');
    $filtro_tp_ckt = filter_input(INPUT_GET, 'tpckt');
    $filtro_unidade = filter_input(INPUT_GET, 'unidade');
    if (!isset($filtro_diretoria)) {
        $filtro_diretoria = 'Todas';
    }
    if (!isset($filtro_situacao)) {
        $filtro_situacao = '2';
    }
    if (!isset($filtro_tp_ckt)) {
        $filtro_tp_ckt = '0';
    }
    $relatorio = new RelatorioCircuitos();
    $nomesDiretorias = $relatorio->listaNomesDiretorias();
    ?>
    <div class="col-lg-6">        
        <iframe src="tabela_circuitos.php?dre=<?php echo $filtro_diretoria; ?>&sit=<?php echo $filtro_situacao; ?>&tpckt=<?php echo $filtro_tp_ckt; ?>" width="100%" height="74%" style="border: 0px;"></iframe> 
    </div>   
    <div class="col-lg-6">
        <iframe src="grafico_diretorias.php?dre=<?php echo $filtro_diretoria; ?>&graf=1" width="95%" height="35%" style="border: 0px;"></iframe> 
    </div>   
    <div class="col-lg-6">
        <iframe src="grafico_diretorias.php?dre=<?php echo $filtro_diretoria; ?>&graf=2" width="95%" height="35%" style="border: 0px;"></iframe> 
    </div>    
    </div>
    </div>    
    <?php
    include ("../class/footer.php");
}