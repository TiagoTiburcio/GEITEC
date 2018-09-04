<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4') == 1) {    
    $filtro_diretoria = filter_input(INPUT_GET, 'dre');
    $filtro_grafico = filter_input(INPUT_GET, 'graf');
    if (!isset($filtro_diretoria)) {
        $filtro_diretoria = 'Todas';
    }
    $cores = array("blue", "red", "green", "purple", "blue", "grey", "purple");
    $relatorio = new RelatorioCircuitos();
    $diretorias = $relatorio->listaNomesTiposUnid($filtro_diretoria);
    foreach ($diretorias as $diretoriasTable) {
        $diretoriasGraph[] = $diretoriasTable['desc_localizacao'];
    }
    if ($filtro_grafico == 1) { //grafico Circuitos Faturados
        $tipoSituacao = array('Links UP', 'Links DOWN');
        $qtdCircContas = $relatorio->listaCircTipoUnid($filtro_diretoria);
        $ind_cor = "0";
        ?>
        <div class="col-lg-12">
            <canvas id="chart-0" style="display: block; width: 100%; height: 300px;" ></canvas>
        </div>
        <link rel="stylesheet" type="text/css" href="../css/chart-style.css">
        <script src="../js/Chart.bundle.js"></script>
        <script src="../js/chart-utils.js"></script>
        <script src="../js/charts_area_analyser.js"></script>
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
                        if (($diretoria == $qtdCircContas_table['desc_localizacao']) && ($qtdCircContas_table['situacao'] == 'Up(0)')) {
                            $val = $qtdCircContas_table['qtd_circ_dir_sit'];
                        }
                    }
                } elseif ($key == 1) {
                    foreach ($qtdCircContas as $qtdCircContas_table) {
                        if (($diretoria == $qtdCircContas_table['desc_localizacao']) && ($qtdCircContas_table['situacao'] == 'Down(1)')) {
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
                responsive: false,
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
    <?php
    } elseif ($filtro_grafico == 2) {
        $ind_cor = "2";
        $tipoSituacaoPBLE = array('PBLE UP', 'PBLE DOWN');
        $qtdCircPBLE = $relatorio->listaPbleTipoUnid($filtro_diretoria);
        ?> 
        <div class="col-lg-12">
            <canvas id="chart-1" style="display: block; width: 100%; height: 300px;" ></canvas> 
        </div>
        <link rel="stylesheet" type="text/css" href="../css/chart-style.css">
        <script src="../js/Chart.bundle.js"></script>
        <script src="../js/chart-utils.js"></script>
        <script src="../js/charts_area_analyser.js"></script>
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
                        if (($diretoria == $qtdCircContas_table['desc_localizacao']) && ($qtdCircContas_table['situacao'] == 'Up(0)')) {
                            $val = $qtdCircContas_table['qtd_circ_dir_sit'];
                        }
                    }
                } elseif ($key == 1) {
                    foreach ($qtdCircPBLE as $qtdCircContas_table) {
                        if (($diretoria == $qtdCircContas_table['desc_localizacao']) && ($qtdCircContas_table['situacao'] == 'Down(1)')) {
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
    }
}//fim valida sessão