<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('2', '0') == 1) {
?>
    <div class="col-xs-12">
        <canvas id="chart-0" style="display: block; width: 800px; height: 600px;"></canvas>
    </div>

    </div>
    <link rel="stylesheet" type="text/css" href="../css/chart-style.css">
    <script src="../js/Chart.bundle.js"></script>
    <script src="../js/chart-utils.js"></script>
    <script src="../js/charts_area_analyser.js"></script>
    <script src="../js/grafico.js" type="text/javascript"></script>
    <script>
        var presets = window.chartColors;
        var utils = Samples.utils;
        var inputs = {
            min: 20,
            max: 80,
            count: 8,
            decimals: 2,
            continuity: 1
        };

        function generateData() {
            return utils.numbers(inputs);
        }

        function generateLabels() {
            return utils.months({
                count: inputs.count
            });
        }

        utils.srand(42);

        var data = {
            <?php
           
            $graficos = new GraficosDiscosDC();

            $meses = $graficos->listaMeses();
            foreach ($meses as $meses_table) {
                $meses_graph[] = $meses_table['mes'];
            }
            $vms = $graficos->listaVM();
            $dados = $graficos->listaEspacoPorVM();

            foreach ($vms as $vms_table) {
                $vms_graph[] = $vms_table['host'];
            }
            $cores = array("red", "orange", "yellow", "green", "blue", "grey", "purple");
            $ind_cor = "0";
            echo "labels: ";
            echo '["' . implode('", "', $meses_graph) . '"],  datasets:';
            foreach ($vms_graph as $key_vm => $vm_atual) {
                if ($key_vm == 0) {
                    echo '[';
                } else {
                    echo ',';
                }
                foreach ($dados as $dados_table) {
                    if ($vm_atual == $dados_table['host']) {
                        switch ($dados_table['name_pool']) {
                            case 'PoolProd':
                                $ind_cor = 2;
                                break;
                            case 'PoolHomo':
                                $ind_cor = 0;
                                break;
                            case 'PoolBanco':
                                $ind_cor = 3;
                                break;
                        }
                    }
                }
                echo "{ backgroundColor: utils.transparentize(presets.$cores[$ind_cor]), borderColor: presets.$cores[$ind_cor], data: ";
                foreach ($meses_graph as $key_mes => $mes_atual) {
                    $vm = $vm_atual;
                    $val = '0.00';
                    $mes = $mes_atual;
                    if ($key_mes == 0) {
                        echo '[';
                    } else {
                        echo ',';
                    }
                    foreach ($dados as $dados_table) {
                        if (($vm_atual == $dados_table['host']) && ($mes_atual == $dados_table['mes'])) {
                            $vm = $dados_table['host'];
                            $val = $dados_table['total_disco'];
                            $mes = $dados_table['mes'];
                        }
                    }
                    echo ' ' . number_format($val, 2, '.', '');
                }
                if ($ind_cor < 6) {
                    $ind_cor = $ind_cor + 1;
                } else {
                    $ind_cor = 0;
                }
                echo "],  hidden: false,  label: '$vm_atual',  fill: true} ";
            }
            echo ']';
            ?>
        }

        var options = {
            maintainAspectRatio: false,
            spanGaps: false,
            elements: {
                line: {
                    tension: 0.0001
                }
            },
            scales: {
                yAxes: [{
                    stacked: true
                }]
            },
            plugins: {
                filler: {
                    propagate: false
                }
            }
        };

        var chart1 = new Chart('chart-0', {
            type: 'line',
            data: data,
            options: options
        });
    </script>

<div class="col-xs-12">
  <h2>Dados Discos Servidores Data Center</h2>
  <p>Dados de Discos Servidores Zabbix Sala Cofre.</p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Pool VM</th>
        <th>Nome</th>
        <?php 
            foreach ($meses_graph as $mes) {
                echo "<th>$mes</th>";    
            }             
        ?>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($vms as $vms_table) {
            echo "<tr><td>".$vms_table['name_pool']."</td>";
            echo "<td>".$vms_table['host']."</td>";
            foreach ($meses_graph as $mes) {
                $imprime = '-';
                foreach ($dados as $dados_table){
                    if(($dados_table['mes'] == $mes) && ($dados_table['host'] == $vms_table['host'])){
                        $imprime = $dados_table['total_disco_format'];
                    }                        
                }
                echo "<td>".$imprime."</td>";                                      
            }
            echo "</tr>";
        }
    
      ?>  
    </tbody>
  </table>
</div>
<?php

}
