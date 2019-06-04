<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {

    $filtro_ckt = filter_input(INPUT_GET, 'ckt');
    $filtro_period = filter_input(INPUT_GET, 'period');

    // $zabbix = new ZabbixSEED();
    //  $circuitos = new Circuitos();

    if (($filtro_period == NULL) || ($filtro_period == "")) {
        $filtro_period = "3600";
    }

    // $grafico = "";
    //$consulta_grafico = $zabbix->buscaDadosCircuito($filtro_ckt);
    // foreach ($consulta_grafico as $table) {
    //    $grafico = $table['graphid'];
    // }
    $zbx = 'http://172.25.76.61/zabbix/index.php';
    $data = 'name=redmine&password=74123698seed&autologin=1&enter=Sign+in';
    $rotina->login($zbx, $data, "zabbix_cofre");
    $options_graph = array("1439", "1748", "1759", "2052", "1446", "1451", "1464", "1774", "2043", "2256", "1958", "2184");
    foreach ($options_graph as $key => $value) {
        $s = "http://172.25.76.61/zabbix/chart2.php?graphid=$value&period=$filtro_period&width=960";

        $rotina->grab_page($s, $value . ".png", "zabbix_cofre");
    }
    ?>
    <form class="form-inline" id="filtro_diretoria_circuito" name="filtro_diretoria_circuito" method="get" action=""> 
        <label for="period">Periodo Grafico</label>
        <select class="form-control" id="period" name="period" onchange="submitFormRelPorTipo()">                                    
            <?php
            $options_period = array("7776000", "3600", "7200", "21600", "86400");
            $options_periodn = array("3 Meses", "Ult. Hora", "Ult. 2 Horas", "Ult. 6 Horas", "Ult. Dia");
            foreach ($options_period as $key => $value) {
                echo '<option value="' . $options_period[$key] . '" ';
                if ($filtro_period == $options_period[$key]) {
                    echo 'selected=""';
                }
                echo ' >' . $options_periodn[$key] . '</option>';
            }
            ?>
        </select>        
        <?php
        foreach ($options_graph as $key => $value) {
            echo '<img src="../images/temp/' . $value . '.png" width="100%"/><br/>';
        }
        
        ?>
        
    </form>
    <?php
}
    