<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {

    $grafico = (empty(filter_input(INPUT_GET, 'grafico'))) ? '' : filter_input(INPUT_GET, 'grafico');
    $filtro_period = (empty(filter_input(INPUT_GET, 'period'))) ? '3600' : filter_input(INPUT_GET, 'period');
    if ($grafico != '') {
        $zbx = 'http://172.25.76.61/zabbix/index.php';
        $data = 'name=redmine&password=74123698seed&autologin=1&enter=Sign+in';
        $rotina->login($zbx, $data, "zabbix_cofre");
        $s = "http://172.25.76.61/zabbix/chart2.php?graphid=$grafico&period=$filtro_period&width=960";
        $rotina->grab_page($s, $grafico . ".png", "zabbix_cofre");
    }
    ?>
    <form class="form-inline" id="filtro_diretoria_circuito" name="filtro_diretoria_circuito" method="get" action=""> 
        <label for="period">Periodo Grafico</label>
        <select class="form-control" id="period" name="period" onchange="submitFormRelPorTipo()">                                    
            <?php
            $options_period = array( "3600", "7200", "21600", "86400","7776000");
            $options_periodn = array( "Ult. Hora", "Ult. 2 Horas", "Ult. 6 Horas", "Ult. Dia","3 Meses");
            foreach ($options_period as $key => $value) {
                echo '<option value="' . $options_period[$key] . '" ';
                if ($filtro_period == $options_period[$key]) {
                    echo 'selected=""';
                }
                echo ' >' . $options_periodn[$key] . '</option>';
            }
            ?>
        </select>
        <input type="hidden" id="grafico" name="grafico" value="<?php echo $grafico;?>"/>        
        <?php
        echo '<img src="../images/temp/' . $grafico . '.png" width="100%"/><br/>';
        ?>

    </form>
    <?php
}
    