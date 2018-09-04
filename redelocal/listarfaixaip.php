<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {

    $circuitos = new Circuitos();

    $zabbix = new ZabbixSEED();
    $switch = new Switchs();
    $rede = new Rede();    
    $bloco = filter_input(INPUT_POST,'bloco');
    $rack = filter_input(INPUT_POST,'rack');
    $zbx = '2';
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                                     
                    <div class="form-group">
                        <label for="bloco">Bloco</label>
                        <input type="text" class="form-control" id="bloco" name="bloco" value="<?php echo $bloco; ?>">
                    </div>
                    <div class="form-group">
                        <label for="rack">Rack</label>
                        <input type="text" class="form-control" id="rack" name="rack" value="<?php echo $rack; ?>">
                    </div>
                    <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-10">
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Bloco</th>
                    <th>Rack</th>
                    <th>Ip Switch</th>
                    <th>Porta Sw</th>                        
                    <th>Vlan</th>
                    <th>Nome Impressora - IP</th>
                    <th>Marca - Modelo</th>
                    <th>Grupo</th>
                    <th>Ativo?</th>
                    <th>Dias Sit.</th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                $ips = $rede->getArrayIPsRede("300");
                $resultado_detalhada2 = $switch->listImpressoras($bloco, $rack);
                $consultaZabbix = $zabbix->listImpr();
                foreach ($ips as $table_ips) {
                    $cadzbx = 3;
                    $sitZbx = 0;
                    $tipoZbx = "N/C";
                    $nomeImpzbx = "Livre";
                    $blocoLista = "-";
                    $rackLista = "-";
                    $ipSwLista = "";
                    $cdSwLista = "-";
                    $tpPortSwLista = "";
                    $cdPortSwLista = "";
                    $impMarcaLista = "-";
                    $impModelLista = "-";
                    foreach ($resultado_detalhada2 as $table) {
                        foreach ($consultaZabbix as $tableZbx) {
                            if (($tableZbx["hostid"] == $table["codigo_host_zabbix"]) && ($tableZbx["ip"] == $table_ips)) {
                                $nomeImpzbx = $tableZbx["host"];
                                $cadzbx = $tableZbx["value"];
                                $sitZbx = $tableZbx["tempo_inativo"];
                                $tipoZbx = $tableZbx["grupo"];
                                $blocoLista = $table["bloco"];
                                $rackLista = $table["rack"];
                                $ipSwLista = $table["ip"];
                                $impMarcaLista = $table["marca"];
                                $impModelLista = $table["modelo"];
                                $cdSwLista = $table["codigo_switch"];
                                $cdPortSwLista = $table["codigo_porta_switch"];
                                $tpPortSwLista = $table["tipo_porta"];
                            } elseif ($tableZbx["ip"] == $table_ips) {
                                $nomeImpzbx = $tableZbx["host"];
                                $cadzbx = $tableZbx["value"];
                                $sitZbx = $tableZbx["tempo_inativo"];
                                $tipoZbx = $tableZbx["grupo"];
                            }
                        }
                    }
                    if ($cadzbx == '1') {
                        echo '<tr class="danger">';
                    } elseif ($cadzbx == '0') {
                        echo '<tr class="success">';
                    } else {
                        echo '<tr>';
                    }
                    echo " <td>" . $blocoLista . "</td> "
                    . " <td>" . $rackLista . "</td>"
                    . ' <td><a title="Abrir Interface Configuração Switch" target="_blank" href="' . "http://" . $ipSwLista . '">' . $ipSwLista . "</a></td>"
                    . ' <td><a title="Abrir Tela Configuração Porta Switch Sistema" target="_blank" href="../redelocal/editportasw.php?sw=' . $cdSwLista . '&port=' . $cdPortSwLista . '&tipo=' . $tpPortSwLista . '">' . $cdPortSwLista . '</a></td> <td>300</td>'
                    . ' <td><a title="Abrir Interface Configuração Impressora" target="_blank" href="' . "http://" . $table_ips . '">' . $nomeImpzbx . "- " . $table_ips . "</a></td>"
                    . " <td>" . $impMarcaLista . " - " . $impModelLista . "</td>"
                    . " <td>" . $tipoZbx . "</td>"
                    . " <td>" . $zabbix->imprimiSitu($cadzbx) . "</td>"
                    . " <td>" . $sitZbx . "</td> </tr>";
                }
                ?>                                          
            </tbody>
        </table>
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}