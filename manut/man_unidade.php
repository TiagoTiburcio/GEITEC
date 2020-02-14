<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('5', '30') == 1) {

    $unidades = new UnidadesManut();


    $filtro_unidade = (isset($_GET['unidade'])) ? filter_input(INPUT_GET, 'unidade', FILTER_VALIDATE_INT) : '';
    $formUnidadeNome = (isset($_POST['unidadeNome'])) ? filter_input(INPUT_POST, 'unidadeNome', FILTER_SANITIZE_STRING) : '';
    if ($formUnidadeNome != '') {
        $formUnidadeAtivo = (filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_STRING) == 'Ativado') ? 1 : 0;
        $formUnidadeINEP = filter_input(INPUT_POST, 'codigoINEP', FILTER_SANITIZE_STRING);
        $formUnidadeSIIG = ($_POST['unidadeSIIG'] == '') ? 0 : filter_input(INPUT_POST, 'unidadeSIIG', FILTER_SANITIZE_STRING);
        $formUnidadeSigla = filter_input(INPUT_POST, 'unidadeSigla', FILTER_SANITIZE_STRING);
        $formUnidadeCidade = filter_input(INPUT_POST, 'unidadeCidade', FILTER_SANITIZE_STRING);
        $formUnidadeDRE = filter_input(INPUT_POST, 'dre', FILTER_SANITIZE_STRING);
        $formUnidadeTipo = filter_input(INPUT_POST, 'tipoUnidade', FILTER_SANITIZE_STRING);
        $formUnidadeZona = filter_input(INPUT_POST, 'zona', FILTER_SANITIZE_STRING);
        $formUnidadeCodigo = filter_input(INPUT_POST, 'codigoUnidade', FILTER_VALIDATE_INT);
        $unidade = new Unidade(
            $formUnidadeCodigo,
            $formUnidadeSIIG,
            $formUnidadeINEP,
            $formUnidadeNome,
            $formUnidadeSigla,
            $formUnidadeDRE,
            $formUnidadeTipo,
            $formUnidadeZona,
            $formUnidadeCidade,
            $formUnidadeAtivo
        );

        $existe = $unidades->manUnidade($unidade);
    }
    $dados_unidade = $unidades->listaUnidades(NULL, NULL, $filtro_unidade);
    $dados_dre = $unidades->listaDREs();
    $dados_tipo_unidade = $unidades->listaTipoUnidade();
    $unidadeCodigo = '0';
    $unidadeINEP = '';
    $unidadeSigla = '';
    $unidadeDRE = '';
    $unidadeSIIG = '';
    $unidadeDescricao =  '';
    $unidadeCidade =  '';
    $unidadeAtivo =  '0';
    $unidadeZona = 'U';
    if ($filtro_unidade != '') {
        $dados_circuitos = $unidades->listaCircuitosUnidade($filtro_unidade);
        $lista_unidades = $unidades->listaUnidades(NULL, NULL, $filtro_unidade, true);
        foreach ($dados_unidade as $value) {
            $unidadeCodigo = $value['unidade_codigo'];
            $unidadeINEP = $value['unidade_inep'];
            $unidadeSigla = $value['unidade_sigla'];
            $unidadeSIIG = $value['unidade_siig'];
            $unidadeDRE = $value['dre_unidade'];
            $unidadeDescricao =  $value['unidade_descricao'];
            $unidadeCidade =  $value['unidade_cidade'];
            $unidadeAtivo =  $value['ativo'];
            $unidadeTipo = $value['unidade_tipo_codigo'];
            $unidadeZona = $value['unidade_zona'];
        }
    }

?>
    <!-- Bootstrap core CSS -->
    <link href="../design/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../design/css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="../design/css/style.css" rel="stylesheet">


    <div class="col-xs-12">
        <div class="col-xs-12">
            <div class="d-flex mb-3">
                <div class="p-2">
                    <a class="btn btn-dark" href="../home/index.php"> <i class='fas fa-home'></i> Voltar Home</a>
                </div>
                <div class="p-2 mb-auto">
                    <a class="btn btn-primary" href="man_unidade.php"> <i class="far fa-plus-square"></i> Nova Unidade</a> </div>
                <div class="p-2 ml-auto">
                    <a class="btn btn-info" href="lista_unidades.php"> <i class="fas fa-list-ul"></i> Lista Unidades</a> </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-xs-12 col-lg-8 offset-lg-2">
        <form action="" method="post" id="formUnidade" name="formUnidade">
            <div class="d-flex mb-3">
                <div class="p-2">
                    <h2>Dados da Unidade</h2>
                </div>
                <div class="p-2 ml-auto">
                    <input type="text" <?php echo ($unidadeAtivo == '1') ? 'class="btn btn-success" value="Ativado"' : 'class="btn btn-danger" value="Desativado"' ?> id="ativo" name="ativo" onclick="mostraOpcaoTela()">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="codigoUnidade">Codigo</span>
                        </div>
                        <input type="text" class="form-control" id="codigoUnidade" name="codigoUnidade" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $unidadeCodigo; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="unidadeSIIG">Codigo SIIG</span>
                        </div>
                        <input type="text" class="form-control" id="unidadeSIIG" name="unidadeSIIG" readonly aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $unidadeSIIG; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="codigoINEP">INEP</span>
                        </div>
                        <input type="text" class="form-control" id="codigoINEP" name="codigoINEP" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $unidadeINEP; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="zona">Zona Unid.</label>
                        </div>
                        <select class="custom-select" id="zona" name="zona" form="formUnidade">
                            <option <?php echo ($unidadeZona == 'U') ? 'selected' : ''; ?> value="U">Urbano</option>
                            <option <?php echo ($unidadeZona == 'R') ? 'selected' : ''; ?> value="R">Rural</option>                            
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="unidadeSigla">Sigla Unidade</span>
                        </div>
                        <input type="text" class="form-control" id="unidadeSigla" name="unidadeSigla" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $unidadeSigla; ?>">
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="unidadeNome">Nome Unidade</span>
                        </div>
                        <input type="text" class="form-control" id="unidadeNome" name="unidadeNome" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $unidadeDescricao; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="dre">DRE</label>
                        </div>
                        <select class="custom-select" id="dre" name="dre" form="formUnidade">
                            <option selected></option>
                            <?php
                            foreach ($dados_dre as $dre) {
                                $select = ($dre['codigo_siig'] == $unidadeDRE) ? 'selected' : '';
                                echo '<option ' . $select . ' value="' . $dre['codigo_siig'] . '">' . $dre['sigla'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="tipoUnidade">Tipo Unidade</label>
                        </div>
                        <select class="custom-select" id="tipoUnidade" name="tipoUnidade" form="formUnidade">
                            <option selected></option>
                            <?php
                            foreach ($dados_tipo_unidade as $value) {
                                $select = ($value['codigo'] == $unidadeTipo) ? 'selected' : '';
                                echo '<option ' . $select . ' value="' . $value['codigo'] . '">' . $value['descricao'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="unidadeCidade">Cidade Unidade</span>
                        </div>
                        <input type="text" class="form-control" id="unidadeCidade" name="unidadeCidade" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $unidadeCidade; ?>">
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-end flex-column">
                <div class="p-2">
                    <button type="submit" class="btn btn-primary"> <i class="far fa-save"></i> Salvar Dados Unidade</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-12">
        <div class="d-flex mb-3">
            <div class="p-2">
                <h2>Circuitos Vinculados à Unidade</h2>
            </div>
            <div class="p-2 ml-auto">
                <a class="btn btn-info" href=""> <i class="far fa-plus-square"></i> Novo Circuito</a> </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Forn.</th>
                        <th scope="col">Contrato</th>
                        <th scope="col">Localizacao</th>
                        <th scope="col">Circuito</th>
                        <th scope="col">Servico</th>
                        <th scope="col">Veloc.</th>
                        <th scope="col">Endereco</th>
                        <th scope="col">Ult. Ref.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados_circuitos as $value) { ?>
                        <tr>
                            <td><?php echo $value['contrato_nome_fornecedor']; ?></td>
                            <td><?php echo $value['contrato_codigo']; ?></td>
                            <td><?php echo $value['localizacao_descricao']; ?></td>
                            <td> <a href="../circuitos/circuito.php?ckt=<?php echo $value['circuito_codigo']; ?>"><?php echo $value['circuito_codigo']; ?></a></td>
                            <td><?php echo $value['circuito_tipo_servico']; ?></td>
                            <td><?php echo $value['circuito_velocidade']; ?></td>
                            <td><?php echo $value['circuito_tipo_logradouro'] . ' ' . $value['circuito_nome_logradouro'] . ' ' . $value['circuito_bairro'] . ' N ' . $value['circuito_num_imovel']; ?></td>
                            <td><?php echo date('m/Y', strtotime($value['circuito_data_ult_ref'])); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">Forn.</th>
                        <th scope="col">Contrato</th>
                        <th scope="col">Localizacao</th>
                        <th scope="col">Circuito</th>
                        <th scope="col">Servico</th>
                        <th scope="col">Veloc.</th>
                        <th scope="col">Endereco</th>
                        <th scope="col">Ult. Ref.</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php

        ?>
    </div>
    </div>

    <div class="col-xs-12">
        <div class="row">
            <div class="col">
                <h2>Unidades Filhas</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
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
                                <td class="text-center"><?php echo '<a class="btn btn-outline-dark" href="man_unidade.php?unidade=' . $value['unidade_siig'] . '"> <i class="far fa-edit"></i></a>'; ?></td>
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
                </table>
            </div>
            <?php

            ?>
        </div>
    </div>
    <?php

    ?>
    </div>
    <script>
        function mostraOpcaoTela() {
            if (document.getElementById("ativo").value === 'Ativado') {
                document.getElementById("ativo").classList = 'btn btn-danger';
                document.getElementById("ativo").value = "Desativado";
            } else if (document.getElementById("ativo").value === 'Desativado') {
                document.getElementById("ativo").classList = 'btn btn-success';
                document.getElementById("ativo").value = "Ativado";
            }
        }
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script type="text/javascript" src="../design/js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="../design/js/popper.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="../design/js/mdb.min.js"></script>
<?php

}
