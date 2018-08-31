<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('') == 1) {
    if (!isset($_GET ['dre'])) {
        $_GET ['dre'] = 'Todas';
    }
    if (!isset($_GET ['sit'])) {
        $_GET ['sit'] = '2';
    }
    if (!isset($_GET ['unidade'])) {
        $_GET ['unidade'] = '';
    }
    if (!isset($_GET ['tpckt'])) {
        $_GET ['tpckt'] = '0';
    }
    $filtro_diretoria = $_GET ['dre'];
    $filtro_situacao = $_GET ['sit'];
    $filtro_tp_ckt = $_GET ['tpckt'];
    $filtro_unidade = $_GET ['unidade'];
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