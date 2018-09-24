<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('') == 1) {
    $filtro_ckt = filter_input(INPUT_GET, 'ckt');
    $filtro_period = filter_input(INPUT_GET, 'period');
    if (($filtro_period == NULL) || ($filtro_period == "")) {
        $filtro_period = "3600";
    }
    $zabbix = new ZabbixSEED();
    $circuitos = new Circuitos();
    if ((filter_input(INPUT_SERVER, 'HTTP_REFERER') != NULL) || (filter_input(INPUT_SERVER, 'HTTP_REFERER') != "")) {
        $url = filter_input(INPUT_SERVER, 'HTTP_REFERER');
    } else {
        $url = "../index.php";
    }

    if (($filtro_ckt == NULL) || ($filtro_ckt == "")) {
        echo '<META http-equiv="refresh" content="0;' . $url . '">';
    } else {
        $grafico = "";
        $ip = "";
        $consulta_grafico = $zabbix->buscaDadosCircuito($filtro_ckt);
        foreach ($consulta_grafico as $table) {
            $grafico = $table['graphid'];
            $ip = $table['ip'];
        }        
        $resultado_contas = $circuitos->listaCirctuitosUltCobancas($filtro_ckt);
        foreach ($resultado_contas as $table) {
            $designacao = $table['designacao'];
            $nome_unidade = $table['nome_unidade'];
            $endereco = trim($table['tip_logradouro']) . " " . trim($table['nome_logradouro']) . ", " . trim($table['num_imovel']) . " Bairro: " . trim($table['nome_bairro']) . " Cidade:" . trim($table['nome_cidade']);
        }
        ?>
        <div class="col-lg-offset-2 col-lg-4 centraltd">  
            <div class="form-group">
                <label for="designacao">Designa&ccedil;&atilde;o </label>
                <input type="text" class="form-control centraltd" readonly="true" id="designacao" name="designacao" value="<?php echo $designacao; ?>">
            </div>
            <div class="form-group">
                <label for="ip">Endere&ccedil;o IP Wan </label>
                <input type="text" class="form-control centraltd" readonly="true" id="ip" name="ip" value="<?php echo $ip; ?>">
            </div>
        </div>
        <div class="col-lg-4 centraltd">  
            <div class="form-group">
                <label for="nome_unidade">Descri&ccedil;&atilde;o Resumida</label>
                <input type="text" class="form-control centraltd" readonly="true" id="nome_unidade" name="nome_unidade" value="<?php echo "$nome_unidade"; ?>">
            </div>
            <div class="form-group">
                <label for="endereco">Endere&ccedil;o Unidade</label>
                <input type="text" class="form-control centraltd" readonly="true" id="endereco" name="endereco" value="<?php echo "$endereco"; ?>">
            </div>
        </div>
        <div class="col-lg-6">  
           <iframe src="grafico.php<?php echo "?ckt=".$filtro_ckt."&period=".$filtro_period; ?>" width="100%" height="50%" style="border: 0px;"></iframe> 
        </div>
        <div class="col-lg-6">
            <h3 class="centraltd">Ultimas Cobranças</h3>
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Contrato</th>
                        <th>Mês Cobranca</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($resultado_contas as $table) {
                        echo ' <td>' . $table['fatura'] . '</td>'
                        . ' <td>' . date('m/Y', strtotime($table['periodo_ref'])) . ' </td>'
                        . ' <td>' . $table['valor_conta'] . '</td> </tr>';
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 centraltd">
            <a type="button" class="btn btn-primary" href="<?php echo $url; ?>">voltar <span class="glyphicon glyphicon-backward"></span></a>
        </div>
        </div>
        <?php
    }
    include ("../class/footer.php");
}
    