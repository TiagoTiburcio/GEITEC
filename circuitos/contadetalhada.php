<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('') == 1) {

    $circuitos = new Circuitos();

    $zabbix = new ZabbixSEED();

    $diretoria = filter_input(INPUT_POST, 'diretoria');
    $unidade = filter_input(INPUT_POST, 'unidade');
    $fatura = filter_input(INPUT_POST, 'fatura');
    $circuito = filter_input(INPUT_POST, 'circuito');
    $mescad = filter_input(INPUT_POST, 'mes');
    $zbx = filter_input(INPUT_POST, 'zabbix');
    $inep = filter_input(INPUT_POST, 'inep');
    if (!isset($zbx)) {
        $zbx = 2;
    }
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                                     
                    <div class="form-group">
                        <label for="diretoria">Diretoria</label>
                        <input type="text" class="form-control" id="diretoria" name="diretoria" value="<?php echo $diretoria; ?>">
                    </div>
                    <div class="form-group">
                        <label for="unidade">Nome Unidade</label>
                        <input type="text" class="form-control" id="unidade" name="unidade" value="<?php echo $unidade; ?>">
                    </div>
                    <div class="form-group">
                        <label for="circuito">Circuito</label>
                        <input type="text" class="form-control" id="circuito" name="circuito" value="<?php echo $circuito; ?>">
                    </div>
                    <div class="form-group">
                        <label for="fatura">Contrato</label>
                        <input type="text" class="form-control" id="fatura" name="fatura" value="<?php echo $fatura; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inep">Codigo Inep</label>
                        <input type="text" class="form-control" id="inep" name="inep" value="<?php echo $inep; ?>">
                    </div>
                    <div class="form-group">
                        <label for="zabbix">Cadastro Zabbix</label><br/>
                        <div class="radio">
                            <label><input type="radio" name="zabbix" <?php
                                if ($zbx == 2) {
                                    echo 'checked=""';
                                }
                                ?> value="2">Todos</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="zabbix" <?php
                                if ($zbx == 1) {
                                    echo 'checked=""';
                                }
                                ?> value="1">Inoperante</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="zabbix" <?php
                                if ($zbx == 0) {
                                    echo 'checked=""';
                                }
                                ?> value="0">Funcionando</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="zabbix" <?php
                                if ($zbx == 4) {
                                    echo 'checked=""';
                                }
                                ?> value="4">Cadastrado Zabbix</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="zabbix" <?php
                                if ($zbx == 3) {
                                    echo 'checked=""';
                                }
                                ?> value="3">Não Cadastrado Zabbix</label>
                        </div><br/>
                    </div>                   
                    <div class="form-group">
                        <label for="mes">Mes Cobranca</label>
                        <select class="form-control" id="mes" name="mes" onchange="pegaMesSint()">

                            <?php
                            $resultado_detalhada1 = $circuitos->listaPeriodoRef();
                            foreach ($resultado_detalhada1 as $mes) {
                                if ($mescad == '') {
                                    $mescad = $mes['periodo_ref'];
                                }
                                if ($mes['periodo_ref'] == $mescad) {
                                    ?> 
                                    <option value="<?php echo $mes['periodo_ref']; ?>" selected><?php echo $mes['mes']; ?></option>                    
                                    <?php
                                } else {
                                    ?> 
                                    <option value="<?php echo $mes['periodo_ref']; ?>" ><?php echo $mes['mes']; ?></option>                    
                                    <?php
                                }
                            }
                            ?>                                       
                        </select>
                        <div class="col-xs-6 col-xs-3" >                     
                            <br/><a id="linkprint"  type="button" class="btn btn-info" target="_blank" href="./relatorios/contas_sintetico.php?periodo=<?php echo $mescad . "&fatura=" . $fatura; ?>">Imprimir Relatótio <span class="glyphicon glyphicon-print"></span></a>    
                        </div>  
                    </div>
                    <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                    <label> Cad. no ZBX Funcionando: <span class="glyphicon glyphicon-ok-circle btn-success"></label> 
                    <label> Cad. ZBX Inoperante: <span class="glyphicon glyphicon-remove-circle btn-danger"></label> 
                    <label> Não Cad ZBX: <span class="glyphicon glyphicon-ban-circle"></label>  
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-10">
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>DRE</th>
                    <th>Cidade</th>
                    <th>Circuito</th>
                    <th>Nome Unidade</th>
                    <th>Periodo</th>
                    <th>Fatura</th>
                    <th>valor</th>
                    <th>Tipo</th>
                    <th>Velocidade</th>
                    <th>Zabbix</th>                        
                    <th>Dias Sit.</th>            
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado_detalhada2 = $circuitos->listaConsultaDetalhada($unidade, $fatura, $circuito, $diretoria, $mescad, $inep);
                $consultaZabbix = $zabbix->listLinksPagos();
                foreach ($resultado_detalhada2 as $table) {
                    $cadzbx = 3;
                    $sitZbx = 0;
                    $tipoZbx = "N/C";
                    foreach ($consultaZabbix as $tableZbx) {
                        if ($tableZbx['name'] == $table['circuito']) {
                            $cadzbx = $tableZbx['value'];
                            $sitZbx = $tableZbx['tempo_inativo'];
                            $tipoZbx = $tableZbx['grupo'];
                        }
                    }
                    if (($zbx == 2)) {
                        echo " <tr> <td>" . $table['DRE'] . "</td> "
                        . " <td>" . $table['cidade'] . "</td> "
                        . " <td>" . $table['circuito'] . "</td>"
                        . ' <td> <a href="escola.php?inep='.$table['codigo_inep'].'" target="_blank"> ' . $table['nome_unidade'] . " </a></td>"
                        . " <td>" . $table['periodo_ref'] . "</td>"
                        . " <td>" . $table['fatura'] . "</td> "
                        . " <td>" . $table['valor_conta'] . "</td>"
                        . " <td>" . $tipoZbx . "</td>"
                        . " <td>" . $table['velocidade'] . "</td>"
                        . " <td>" . $zabbix->imprimiAtivo($cadzbx) . "</td>"
                        . " <td>" . $sitZbx . "</td> </tr>";
                    } elseif (($zbx == 0) && ($zbx == $cadzbx)) {
                        echo " <tr> <td>" . $table['DRE'] . "</td> "
                        . " <td>" . $table['cidade'] . "</td> "
                        . " <td>" . $table['circuito'] . "</td>"
                        . ' <td> <a href="escola.php?inep='.$table['codigo_inep'].'" target="_blank"> ' . $table['nome_unidade'] . " </a></td>"
                        . " <td>" . $table['periodo_ref'] . "</td>"
                        . " <td>" . $table['fatura'] . "</td> "
                        . " <td>" . $table['valor_conta'] . "</td>"
                        . " <td>" . $tipoZbx . "</td>"
                        . " <td>" . $table['velocidade'] . "</td>"
                        . " <td>" . $zabbix->imprimiAtivo($cadzbx) . "</td>"
                        . " <td>" . $sitZbx . "</td> </tr>";
                    } elseif (($zbx == 1) && ($zbx == $cadzbx)) {
                        echo " <tr> <td>" . $table['DRE'] . "</td> "
                        . " <td>" . $table['cidade'] . "</td> "
                        . " <td>" . $table['circuito'] . "</td>"
                        . ' <td> <a href="escola.php?inep='.$table['codigo_inep'].'" target="_blank"> ' . $table['nome_unidade'] . " </a></td>"
                        . " <td>" . $table['periodo_ref'] . "</td>"
                        . " <td>" . $table['fatura'] . "</td> "
                        . " <td>" . $table['valor_conta'] . "</td>"
                        . " <td>" . $tipoZbx . "</td>"
                        . " <td>" . $table['velocidade'] . "</td>"
                        . " <td>" . $zabbix->imprimiAtivo($cadzbx) . "</td>"
                        . " <td>" . $sitZbx . "</td> </tr>";
                    } elseif (($zbx == 3) && ($zbx == $cadzbx)) {
                        echo " <tr> <td>" . $table['DRE'] . "</td> "
                        . " <td>" . $table['cidade'] . "</td> "
                        . " <td>" . $table['circuito'] . "</td>"
                        . ' <td> <a href="escola.php?inep='.$table['codigo_inep'].'" target="_blank"> ' . $table['nome_unidade'] . " </a></td>"
                        . " <td>" . $table['periodo_ref'] . "</td>"
                        . " <td>" . $table['fatura'] . "</td> "
                        . " <td>" . $table['valor_conta'] . "</td>"
                        . " <td>" . $tipoZbx . "</td>"
                        . " <td>" . $table['velocidade'] . "</td>"
                        . " <td>" . $zabbix->imprimiAtivo($cadzbx) . "</td>"
                        . " <td>" . $sitZbx . "</td> </tr>";
                    } elseif (($zbx == 4) && (( '0' == $cadzbx) || ( '1' == $cadzbx))) {
                        echo " <tr> <td>" . $table['DRE'] . "</td> "
                        . " <td>" . $table['cidade'] . "</td> "
                        . " <td>" . $table['circuito'] . "</td>"
                        . ' <td> <a href="escola.php?inep='.$table['codigo_inep'].'" target="_blank"> ' . $table['nome_unidade'] . " </a></td>"
                        . " <td>" . $table['periodo_ref'] . "</td>"
                        . " <td>" . $table['fatura'] . "</td> "
                        . " <td>" . $table['valor_conta'] . "</td>"
                        . " <td>" . $tipoZbx . "</td>"
                        . " <td>" . $table['velocidade'] . "</td>"
                        . " <td>" . $zabbix->imprimiAtivo($cadzbx) . "</td>"
                        . " <td>" . $sitZbx . "</td> </tr>";
                    }
                }
                ?>                                          
            </tbody>
        </table>
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}