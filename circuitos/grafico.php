<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4') == 1) {

    $filtro_ckt = filter_input(INPUT_GET, 'ckt');
    $filtro_period = filter_input(INPUT_GET, 'period');

    $zabbix = new ZabbixSEED();
    $circuitos = new Circuitos();

    if (($filtro_period == NULL) || ($filtro_period == "")) {
        $filtro_period = "3600";
    }

    $grafico = "";
    $consulta_grafico = $zabbix->buscaDadosCircuito($filtro_ckt);
    foreach ($consulta_grafico as $table) {
        $grafico = $table['graphid'];
    }
    if ($grafico != "") {
        $zbx = 'http://10.24.0.59/zabbix/index.php';
        $data = 'name=redmine&password=74123698seed&autologin=1&enter=Sign+in';
        $s = "http://10.24.0.59/zabbix/chart2.php?graphid=$grafico&period=$filtro_period&width=960";
        $rotina->login($zbx, $data, "zabbix_seed");
        $rotina->grab_page($s, $filtro_ckt . ".png", "zabbix_seed");
    }

    if ($grafico != "") {
        ?>
        <form class="form-inline" id="filtro_diretoria_circuito" name="filtro_diretoria_circuito" method="get" action=""> 
            <label for="period">Periodo Grafico</label>
            <select class="form-control" id="period" name="period" onchange="submitFormRelPorTipo()">                                    
                <?php
                $options_period = array("3600", "7200", "21600", "86400");
                $options_periodn = array("Ult. Hora", "Ult. 2 Horas", "Ult. 6 Horas", "Ult. Dia");
                foreach ($options_period as $key => $value) {
                    echo '<option value="' . $options_period[$key] . '" ';
                    if ($filtro_period == $options_period[$key]) {
                        echo 'selected=""';
                    }
                    echo ' >' . $options_periodn[$key] . '</option>';
                }
                ?>
            </select>
            <input id="ckt" name="ckt" value="<?php echo $filtro_ckt; ?>" hidden="">
            <img src="../images/temp/<?php echo $filtro_ckt; ?>.png" width="100%"/>
        </form>
        <?php
    }
}
    