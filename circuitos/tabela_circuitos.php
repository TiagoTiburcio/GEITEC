<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4') == 1) {
    if (!isset($_GET ['dre'])) {
        $_GET ['dre'] = 'Todas';
    }
    if (!isset($_GET ['sit'])) {
        $_GET ['sit'] = '2';
    }
    if (!isset($_GET ['tpckt'])) {
        $_GET ['tpckt'] = '0';
    }
    $filtro_diretoria = $_GET ['dre'];
    $filtro_situacao = $_GET ['sit'];
    $filtro_tp_ckt = $_GET ['tpckt'];
    $relatorio = new RelatorioCircuitos();
    $dadosDiretoria = $relatorio->listaNomesDiretorias();
    $dadosTipoUnidade = $relatorio->listaNomesTiposUnidadePorDRE($filtro_diretoria);
    $dadosUnidades = $relatorio->listaNomesUnidades($filtro_diretoria);
    $dadosCircuitos = $relatorio->listaCircuitos($filtro_diretoria);
    $dadosPble = $relatorio->listaPble($filtro_diretoria);
    ?>    
    <div class="col-lg-6">
        <form class="form-inline" id="filtro_diretoria_circuito" name="filtro_diretoria_circuito" method="get" action=""> 
            <label for="dre">Diretoria Filtro</label>
            <select class="form-control" id="dre" name="dre" onchange="submitFormRelPorTipo()">                    
                <?php if ($filtro_diretoria == 'Todas') {
                    ?><option value="Todas" selected>Todas</option><?php
                } else {
                    ?><option value="Todas">Todas</option><?php
                }
                foreach ($dadosDiretoria as $dirTable) {
                    if ($dirTable["sigla_dre"] == $filtro_diretoria) {
                        ?> 
                        <option value="<?php echo $dirTable["sigla_dre"]; ?>" selected><?php echo $dirTable["sigla_dre"]; ?></option>                    
                        <?php
                    } else {
                        ?> 
                        <option value="<?php echo $dirTable["sigla_dre"]; ?>" ><?php echo $dirTable["sigla_dre"]; ?></option>                    
                        <?php
                    }
                }
                ?>                                       
            </select>  
            <label for="sit">Situação Circuito</label>
            <select class="form-control" id="sit" name="sit" onchange="submitFormRelPorTipo()">
                <option value="2" <?php
                if ($filtro_situacao == 2) {
                    echo 'selected';
                }
                ?>>Todos</option> 
                <option value="0" <?php
                if ($filtro_situacao == 0) {
                    echo 'selected';
                }
                ?>>UP(0)</option> 
                <option value="1" <?php
                if ($filtro_situacao == 1) {
                    echo 'selected';
                }
                ?>>Down(1)</option>                         
            </select>
            <label for="sit">Tipo Circuito</label>
            <select class="form-control" id="sit" name="tpckt" onchange="submitFormRelPorTipo()">
                <option value="0" <?php
                if ($filtro_tp_ckt == 0) {
                    echo 'selected';
                }
                ?>>Todos</option> 
                <option value="1" <?php
                if ($filtro_tp_ckt == 1) {
                    echo 'selected';
                }
                ?>>Faturados SEED</option> 
                <option value="2" <?php
                if ($filtro_tp_ckt == 2) {
                    echo 'selected';
                }
                ?>>PBLE</option>                         
            </select>          
        </form>        
    </div>
    <?php
    foreach ($dadosDiretoria as $dirTable) {
        $diretoriaAtual = $dirTable['cd_siig_dre'];
        foreach ($dadosUnidades as $unidTable) {
            if ($diretoriaAtual == $unidTable['cd_siig_dre']) {
                $unidadeAtual = $unidTable['cd_siig_unidade'];
                $first = true;
                if (($filtro_tp_ckt == '0') || ($filtro_tp_ckt == '1')) {
                    foreach ($dadosCircuitos as $circTable) {
                        if ($unidTable['cd_siig_unidade'] == $circTable['cd_siig_unidade']) {
                            if (($first) && (($filtro_situacao == '2') || ($filtro_situacao == $circTable['value']))) {
                                ?>
                                <table class="table table-striped table-responsive">        
                                    <caption><?php echo 'Diretoria: ' . $unidTable['sigla_dre'] . ' <br/> Nome Unidade / Cidade:  ' . $unidTable['desc_unidade'] . ' / ' . $unidTable['cidade_unidade']; ?></caption>
                                    <thead>
                                        <tr>
                                            <th>Designação</th>
                                            <th>Tipo Circuito</th>
                                            <th>Data Ult. Ref.</th>
                                            <th>IP</th>
                                            <th>Velocidade</th>
                                            <th>Data Ult. Alt.</th>
                                            <th>Situação</th>
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <?php
                                        $first = false;
                                    } if (($filtro_situacao == '2') || ($filtro_situacao == $circTable['value'])) {
                                        ?>
                                        <tr>
                                            <td><?php echo $circTable['designacao']; ?></td>                   
                                            <td><?php echo $circTable['grupo']; ?></td>                   
                                            <td><?php echo $circTable['ult_ref']; ?></td>                   
                                            <td><?php echo $circTable['ip']; ?></td>                   
                                            <td><?php echo $circTable['velocidade']; ?></td>                   
                                            <td><?php echo $circTable['data']; ?></td>                   
                                            <td><?php echo $rotina->imprimiInverso($circTable['value']); ?></td>                   
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        if (($filtro_tp_ckt == '0') || ($filtro_tp_ckt == '2')) {
                            foreach ($dadosPble as $circTable) {
                                if ($unidTable['cd_siig_unidade'] == $circTable['cd_siig_unidade']) {
                                    if (($first) && (($filtro_situacao == '2') || ($filtro_situacao == $circTable['value']))) {
                                        ?>
                                    <table class="table table-striped table-responsive">        
                                        <caption><?php echo 'Diretoria: ' . $unidTable['sigla_dre'] . ' <br/> Nome Unidade / Cidade:  ' . $unidTable['desc_unidade'] . ' / ' . $unidTable['cidade_unidade']; ?></caption>
                                        <thead>
                                            <tr>
                                                <th>Designação</th>
                                                <th>Tipo Circuito</th>
                                                <th>Data Ult. Ref.</th>
                                                <th>IP</th>
                                                <th>Velocidade</th>
                                                <th>Data Ult. Alt.</th>
                                                <th>Situação</th>
                                            </tr>
                                        </thead>
                                        <tbody>    
                                            <?php
                                            $first = false;
                                        } if (($filtro_situacao == '2') || ($filtro_situacao == $circTable['value'])) {
                                            ?>               
                                            <tr>
                                                <td><?php echo $circTable['designacao']; ?></td>                   
                                                <td><?php echo $circTable['grupo']; ?></td> 
                                                <td> - </td>
                                                <td><?php echo $circTable['ip']; ?></td>                   
                                                <td><?php echo $circTable['velocidade']; ?></td>                   
                                                <td><?php echo $circTable['data']; ?></td>                   
                                                <td><?php echo $rotina->imprimiInverso($circTable['value']); ?></td>                   
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <style>            
                        th {
                            text-align: center;
                        }
                        td{
                            text-align: center;
                        }
                    </style>
                    <?php
                } // fim IF 
            } //fim unidade
        }// fim diretoria 
    }
    