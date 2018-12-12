<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('') == 1) {

    $zabbix = new ZabbixSEED();
    $relCircuito = new RelatorioCircuitos();
    $relatorio = new RelatorioCircuitos();
    $diretorias = $relatorio->listaNomesDiretorias();
    $qtdCircContas = $relatorio->listaQtdCircuitosUpDownContasPorDRE();
    $qtdCircPBLE = $relatorio->listaQtdPbleUpDownContasPorDRE();
    foreach ($diretorias as $diretoriasTable) {
        $diretoriasGraph[] = $diretoriasTable['sigla_dre'];
    }
    $tipoSituacao = array('Links UP', 'Links DOWN');
    $tipoSituacaoPBLE = array('PBLE UP', 'PBLE DOWN');
    $cores = array("blue", "red", "green", "purple", "blue", "grey", "purple");
    ?>
    <div class="col-lg-6">
        <canvas id="chart-0" style="display: block; width: 800px; height: 300px;" ></canvas> 
        <canvas id="chart-1" style="display: block; width: 800px; height: 300px;" ></canvas> 
    </div>
    <div class="col-lg-6">
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Diretoria</th>
                    <th>Links Up</th>
                    <th>Links Down</th>
                    <th>PBLE Up</th>
                    <th>PBLE Down</th>
                    <th>Total CKT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalLinkUP = 0;
                $totalLinkDown = 0;
                $totalPbleUP = 0;
                $totalPbleDown = 0;
                $totalGeral = 0;
                foreach ($diretorias as $nomesTable) {
                    $qLinkUp = 0;
                    $qLinkDown = 0;
                    $qPbleUp = 0;
                    $qPbleDown = 0;
                    $siglaDRE = $nomesTable['sigla_dre'];
                    foreach ($qtdCircPBLE as $pbleTable) {
                        if (($siglaDRE == $pbleTable['sigla_dre']) && ($pbleTable['situacao'] == "Up(0)")) {
                            $qPbleUp = $pbleTable['qtd_circ_dir_sit'];
                        } elseif (($siglaDRE == $pbleTable['sigla_dre']) && ($pbleTable['situacao'] == "Down(1)")) {
                            $qPbleDown = $pbleTable['qtd_circ_dir_sit'];
                        }
                    }
                    foreach ($qtdCircContas as $linksTable) {
                        if (($siglaDRE == $linksTable['sigla_dre']) && ($linksTable['situacao'] == "Up(0)")) {
                            $qLinkUp = $linksTable['qtd_circ_dir_sit'];
                        } elseif (($siglaDRE == $linksTable['sigla_dre']) && ($linksTable['situacao'] == "Down(1)")) {
                            $qLinkDown = $linksTable['qtd_circ_dir_sit'];
                        }
                    }
                    $totalLinks = $qLinkUp + $qLinkDown + $qPbleUp + $qPbleDown;
                    ?>                
                    <tr>
                        <td><?php echo'<a href="../circuitos/diretoriacircuitos.php?dre=' . $siglaDRE . '">' . $siglaDRE . '</a>'; ?></td>
                        <td style="background: rgb(54, 162, 235); color: white; "><?php echo '<a href="../circuitos/diretoriacircuitos.php?dre=' . $siglaDRE . '&sit=0&tpckt=1">' . $qLinkUp; ?></td>
                        <td style="background: rgb(255, 99, 132); color: white; "><?php echo '<a href="../circuitos/diretoriacircuitos.php?dre=' . $siglaDRE . '&sit=1&tpckt=1">' . $qLinkDown; ?></td>
                        <td style="background: rgb(75, 192, 192); color: white; "><?php echo '<a href="../circuitos/diretoriacircuitos.php?dre=' . $siglaDRE . '&sit=0&tpckt=2">' . $qPbleUp; ?></td>
                        <td style="background: rgb(153, 102, 255); color: white; " ><?php echo '<a href="../circuitos/diretoriacircuitos.php?dre=' . $siglaDRE . '&sit=1&tpckt=2">' . $qPbleDown; ?></td>
                        <td><?php echo '<a href="../circuitos/diretoriacircuitos.php?dre=' . $siglaDRE . '">' . $totalLinks . '</a>'; ?></td>

                    </tr> 
                    <?php
                    $totalLinkUP = $totalLinkUP + $qLinkUp;
                    $totalLinkDown = $totalLinkDown + $qLinkDown;
                    $totalPbleUP = $totalPbleUP + $qPbleUp;
                    $totalPbleDown = $totalPbleDown + $qPbleDown;
                    $totalGeral = $totalGeral + $totalLinks;
                }
                ?> 
                <tr>                       
                    <td><?php echo '<a href="../circuitos/diretoriacircuitos.php"> TOTAL GERAL </a>' ?></td>
                    <td><?php echo '<a href="../circuitos/diretoriacircuitos.php?sit=0&tpckt=1">' . $totalLinkUP . '</a>'; ?></td>
                    <td><?php echo '<a href="../circuitos/diretoriacircuitos.php?sit=1&tpckt=1">' . $totalLinkDown . '</a>'; ?></td>
                    <td><?php echo '<a href="../circuitos/diretoriacircuitos.php?sit=0&tpckt=2">' . $totalPbleUP . '</a>'; ?></td>
                    <td><?php echo '<a href="../circuitos/diretoriacircuitos.php?sit=1&tpckt=2">' . $totalPbleDown . '</a>'; ?></td>
                    <td><?php echo '<a href="../circuitos/diretoriacircuitos.php">' . $totalGeral . '</a>'; ?></td>
                </tr> 
            </tbody>
        </table>
    </div>
    </div>

    </div>
    <link rel="stylesheet" type="text/css" href="../css/chart-style.css">
    <script src="../js/Chart.bundle.js"></script>
    <script src="../js/chart-utils.js"></script>
    <script src="../js/charts_area_analyser.js"></script>
   
    <style>
        a {
            color: black;
        }
        th {
            text-align: center;
        }
        td{
            text-align: center;
        }
    </style>
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
            return utils.months({count: inputs.count});
        }

        utils.srand(42);

        var data = {
    <?php
    $ind_cor = "0";
    echo "labels: ";
    echo '["' . implode('", "', $diretoriasGraph) . '"],  datasets:';
    foreach ($tipoSituacao as $key => $value) {
        if ($key == 0) {
            echo '[';
        } else {
            echo ',';
        }
        echo "{ backgroundColor: presets.$cores[$ind_cor], borderColor: presets.$cores[$ind_cor], data: ";
        foreach ($diretoriasGraph as $key1 => $value1) {
            $sitAtual = $value;
            $val = '0.00';
            $diretoria = $value1;
            if ($key1 == 0) {
                echo '[';
            } else {
                echo ',';
            }
            if ($key == 0) {
                foreach ($qtdCircContas as $qtdCircContas_table) {
                    if (($diretoria == $qtdCircContas_table['sigla_dre']) && ($qtdCircContas_table['situacao'] == 'Up(0)')) {
                        $val = $qtdCircContas_table['qtd_circ_dir_sit'];
                    }
                }
            } elseif ($key == 1) {
                foreach ($qtdCircContas as $qtdCircContas_table) {
                    if (($diretoria == $qtdCircContas_table['sigla_dre']) && ($qtdCircContas_table['situacao'] == 'Down(1)')) {
                        $val = $qtdCircContas_table['qtd_circ_dir_sit'];
                    }
                }
            }
            echo ' ' . number_format($val, 2, '.', '');
        }
        if ($ind_cor < 6) {
            $ind_cor = $ind_cor + 1;
        } else {
            $ind_cor = 0;
        }

        echo "],  hidden: false,  label: '$value',  fill: true} ";
    }
    echo ']';
    ?>
        };

        var options = {
            title: {
                display: true,
                text: 'Links por Diretoria'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                        stacked: true,
                    }],
                yAxes: [{
                        stacked: true
                    }]
            }
        };

        var chart1 = new Chart('chart-0', {
            type: 'bar',
            data: data,
            options: options
        });
    </script>
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
            return utils.months({count: inputs.count});
        }

        utils.srand(42);

        var data = {
    <?php
    echo "labels: ";
    echo '["' . implode('", "', $diretoriasGraph) . '"],  datasets:';
    foreach ($tipoSituacaoPBLE as $key => $value) {
        if ($key == 0) {
            echo '[';
        } else {
            echo ',';
        }
        echo "{ backgroundColor: presets.$cores[$ind_cor], borderColor: presets.$cores[$ind_cor], data: ";
        foreach ($diretoriasGraph as $key1 => $value1) {
            $sitAtual = $value;
            $val = '0.00';
            $diretoria = $value1;
            if ($key1 == 0) {
                echo '[';
            } else {
                echo ',';
            }
            if ($key == 0) {
                foreach ($qtdCircPBLE as $qtdCircContas_table) {
                    if (($diretoria == $qtdCircContas_table['sigla_dre']) && ($qtdCircContas_table['situacao'] == 'Up(0)')) {
                        $val = $qtdCircContas_table['qtd_circ_dir_sit'];
                    }
                }
            } elseif ($key == 1) {
                foreach ($qtdCircPBLE as $qtdCircContas_table) {
                    if (($diretoria == $qtdCircContas_table['sigla_dre']) && ($qtdCircContas_table['situacao'] == 'Down(1)')) {
                        $val = $qtdCircContas_table['qtd_circ_dir_sit'];
                    }
                }
            }
            echo ' ' . number_format($val, 2, '.', '');
        }
        if ($ind_cor < 6) {
            $ind_cor = $ind_cor + 1;
        } else {
            $ind_cor = 0;
        }
        echo "],  hidden: false,  label: '$value',  fill: true} ";
    }
    echo ']';
    ?>
        };

        var options = {
            title: {
                display: true,
                text: 'PBLE por Diretoria'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                        stacked: true,
                    }],
                yAxes: [{
                        stacked: true
                    }]
            }
        };

        var chart1 = new Chart('chart-1', {
            type: 'bar',
            data: data,
            options: options
        });
    </script>
    <?php
    include ("../class/footer.php");
}