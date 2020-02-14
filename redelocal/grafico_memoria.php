<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('5', '5') == 1) {
    $graficos = new GraficosMemDC();
    $meses = $graficos->listaMeses();
    $lista_vms = $graficos->listaVM();
    $dados_vms = $graficos->listaDadosMemVMs();
?>
    <div class="col-xs-12">
        <div class="d-flex mb-3">
            <div class="p-2">
                <a class="btn btn-dark" href="../home/index.php"> << Voltar Home</a> 
            </div> 
            <div class="p-2 ml-auto">
                
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="../css/datatable/bootstrap.css">
    <link rel="stylesheet" href="../css/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/datatable/all.css">
    <!-- Bootstrap core CSS -->
    <link href="'../design/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../design/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../design/css/style.css" rel="stylesheet">

    <div class="col-xs-12">
        <table id="example" class="table table-hover table-striped table-condensed table-bordered">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Pool</th>
                    <th class="text-center" rowspan="2">Host</th>
                    <?php
                    foreach ($meses as $table_meses) {
                        echo ' <th class="text-center" colspan="4">';
                        echo $table_meses['mes_ano'];
                        echo '</th>';
                    }
                    ?>
                </tr>
                <tr>
                    <?php
                    foreach ($meses as $table_meses) {
                    ?>
                        <th class="text-center">Liv.<br>Gb</th>
                        <th class="text-center">Uso<br>Gb</th>
                        <th class="text-center">Tot.<br>Gb</th>
                        <th class="text-center">Uso<br>%</th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista_vms as $value) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $value['group_name']; ?></td>
                        <td class="text-center"><?php echo $value['host']; ?></td>
                        <?php
                        foreach ($meses as $table_meses) {
                            $imprime = '-';
                            $tamanho = '-';
                            $livre = '-';
                            $uso = '-';
                            foreach ($dados_vms as $dados_table) {
                                if (($dados_table['mes_ano'] == $table_meses['mes_ano']) && ($dados_table['host'] == $value['host'])) {
                                    $tamanho = number_format(($dados_table['total_mb'] / 1024), 2, ",", ".");
                                    $imprime = $dados_table['utilizada_perc'] * 100;
                                    $livre = number_format(($dados_table['livre_mb'] / 1024), 2, ",", ".");
                                    $uso = number_format(($dados_table['utilizada_mb'] / 1024), 2, ",", ".");
                                }
                            }
                        ?>
                            <td class="text-center"><?php echo $livre; ?></td>
                            <td class="text-center"><?php echo $uso; ?></td>
                            <td class="text-center"><?php echo $tamanho; ?></td>
                            <td class="text-center"><?php echo $imprime; ?></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center" rowspan="2">Pool</th>
                    <th class="text-center" rowspan="2">Host</th>
                    <?php
                    foreach ($meses as $table_meses) {
                    ?> <th class="text-center">Liv.<br>Gb</th>
                        <th class="text-center">Uso<br>Gb</th>
                        <th class="text-center">Tot.<br>Gb</th>
                        <th class="text-center">Uso<br>%</th>
                    <?php

                    }
                    ?>
                </tr>
                <tr>
                    <?php
                    foreach ($meses as $table_meses) {
                        echo ' <th class="text-center" colspan="4">';
                        echo $table_meses['mes_ano'];
                        echo '</th>';
                    }
                    ?>

                </tr>
            </tfoot>
        </table>
        <script type="text/javascript" src="../design/js/jquery-3.4.1.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="../design/js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="../design/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="../design/js/mdb.min.js"></script>
        <script type="text/javascript" src="../js/datatable/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="../js/datatable/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../js/datatable/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable({
                    "language": {
                        "url": "Portuguese-Brasil.json"
                    }
                });
            });
        </script>
    </div>
    </div>
<?php

}
