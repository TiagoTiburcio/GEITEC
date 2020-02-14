<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('5', '30') == 1) {
    $filtro_ativo = ((isset($_POST['ativo']) && ($_POST['ativo'] != 2))) ? filter_input(INPUT_POST, 'ativo', FILTER_VALIDATE_INT) : NULL;
    $filtro_tipo = ((isset($_POST['tipo']) && ($_POST['tipo'] != 0))) ? filter_input(INPUT_POST, 'tipo', FILTER_VALIDATE_INT) : NULL;
    $unidades = new UnidadesManut();
    $lista_unidades = $unidades->listaUnidades($filtro_ativo, $filtro_tipo);
    $lista_tipos = $unidades->listaTipoUnidade();    
?>
    <div class="col-xs-12">
        <div class="d-flex mb-3">
            <div class="p-2">
                <a class="btn btn-dark" href="../home/index.php"> <i class='fas fa-home'></i> Voltar Home</a>
            </div>
            <div class="p-2 mb-auto">
                <a class="btn btn-primary" href="man_unidade.php"> <i class="far fa-plus-square"></i> Nova Unidade</a> </div>
            <div class="p-2 ml-auto">
                <input type="button" class="btn btn-info" value="+ Filtro" id="filtro" name="filtro" onclick="mostraOpcaoTela()">
            </div>
        </div>
        <input type="hidden" name="visivel" value="0" id="visivel">

        <div class="col-xs-12" id="divTela" name="divTela" style="display: none;">
            <div class="d-flex mb-3">
                <div class="p-2">
                    <form class="form-inline" action="" method="post" name="filtroform" id="filtroform">
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Filtrar Tabela</button>
                    </form>
                </div>
                <div class="p-2 ml-auto">
                    <form class="form-inline" action="" method="post">
                        <button type="submit" class="btn btn-danger"> <i class="fas fa-trash-alt"></i> Limpar Filtro</button>
                    </form>
                </div>
            </div>

            <div class="form-group">
                <label for="ativo">Situação Unidades:</label>
                <select class="form-control" id="ativo" name="ativo" form="filtroform">                    
                    <option <?php  echo ($filtro_ativo == '1')? 'selected' : '';?> value="1">Ativo</option>
                    <option <?php  echo ($filtro_ativo == '0')? 'selected' : '';?> value="0">Inativo</option>
                    <option <?php  echo ($filtro_ativo == '2')? 'selected' : '';?> value="2">Todos</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tipo">Select Tipo Unidade:</label>
                <select class="form-control" id="tipo" name="tipo" form="filtroform">
                    <option value='0'>Todos</option>
                    <?php
                    foreach ($lista_tipos as $value) {
                        $select = ($value['codigo'] == $filtro_tipo) ? 'selected' : '';
                        echo '<option '.$select.' value="' . $value['codigo'] . '">' . $value['descricao'] . '</option>';
                    }
                    ?>
                </select>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="../css/datatable/bootstrap.css">
    <link rel="stylesheet" href="../css/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../css/datatable/all.css">
    <!-- Bootstrap core CSS -->
    <link href="../design/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../design/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../design/css/style.css" rel="stylesheet">
    <div class="col-xs-10">
        <table id="example" class="table table-hover table-striped table-condensed table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Dre</th>
                    <th class="text-center">Cidade</th>
                    <th class="text-center">Unidade</th>
                    <th class="text-center">INEP</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Ativo</th>
                    <th class="text-center">Manut.</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista_unidades as $value) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo $value['dre_sigla']; ?></td>
                        <td class="text-center"><?php echo $value['unidade_cidade']; ?></td>
                        <td class="text-center"><?php echo $value['unidade_descricao']; ?></td>
                        <td class="text-center"><?php echo $value['unidade_inep']; ?></td>
                        <td class="text-center"><?php echo $value['unidade_tipo_descricao']; ?></td>
                        <td class="text-center"><?php echo ($value['ativo'] == '1') ? 'SIM' : 'NÃO'; ?></td>
                        <td class="text-center"><?php echo '<a class="btn btn-dark" href="man_unidade.php?unidade=' . $value['unidade_siig'] . '"> <i class="far fa-edit"></i></a>'; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">Dre</th>
                    <th class="text-center">Cidade</th>
                    <th class="text-center">Unidade</th>
                    <th class="text-center">INEP</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Ativo</th>
                    <th class="text-center">Manut.</th>
                </tr>
            </tfoot>
        </table>
        <script>
            function mostraOpcaoTela() {
                if (document.getElementById("visivel").value === '1') {
                    document.getElementById("divTela").style.display = "none";
                    document.getElementById("visivel").value = '0';
                    document.getElementById("filtro").value = '+ Filtro';
                } else if (document.getElementById("visivel").value === '0') {
                    document.getElementById("divTela").style.display = "block";
                    document.getElementById("visivel").value = '1';
                    document.getElementById("filtro").value = '- Filtro';
                }

            }
        </script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <script type="text/javascript" src="../design/js/jquery-3.4.1.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="../design/js/popper.min.js"></script>
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
