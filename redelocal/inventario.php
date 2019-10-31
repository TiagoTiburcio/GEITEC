<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('5', '25') == 1) {
    $glpi = new Glpi();
    $lista_computadores = $glpi->listaComputadores();
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="'../design/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../design/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../design/css/style.css" rel="stylesheet">
    <div class="col-xs-12">
        <table id="example" class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Localizacao</th>
                    <th>Nome</th>
                    <th>Serial</th>
                    <th>tipo_equip</th>
                    <th>fabricante</th>
                    <th>modelo</th>
                    <th>situacao</th>
                    <th>usuario</th>
                    <th>data_mod</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista_computadores as $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['localizacao']; ?></td>
                        <td><?php echo $value['nome_comp']; ?></td>
                        <td><?php echo $value['serial']; ?></td>
                        <td><?php echo $value['tipo_equip']; ?></td>
                        <td><?php echo $value['fabricante']; ?></td>
                        <td><?php echo $value['modelo']; ?></td>
                        <td><?php echo $value['situacao']; ?></td>
                        <td><?php echo $value['usuario']; ?></td>
                        <td><?php echo $value['date_mod']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Localizacao</th>
                    <th>Nome</th>
                    <th>Serial</th>
                    <th>tipo_equip</th>
                    <th>fabricante</th>
                    <th>modelo</th>
                    <th>situacao</th>
                    <th>usuario</th>
                    <th>data_mod</th>
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
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                    }
                });
            });
        </script>
    </div>
    </div>

<?php
}
