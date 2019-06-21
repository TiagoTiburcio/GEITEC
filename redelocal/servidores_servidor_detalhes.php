<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('4', '25') == 1) {
    $rede_servidores = new ServidoresRede();
    $hostid = (empty(filter_input(INPUT_GET, 'hostid'))) ? '' : filter_input(INPUT_GET, 'hostid');
    $lista_items = $rede_servidores->itensServidor($hostid);
    $dados_servidor = $rede_servidores->listServidores('0', '0', '0', '', $hostid);
    $dados_graficos = $rede_servidores->graficosServidor($hostid);
    $dados_interfaces = $rede_servidores->listInterfaces($hostid);
    $array_giga = array("vm.memory.size[total]", "vm.memory.size[free]", "system.swap.size[,total]", "system.swap.size[,free]");
    $array_giga_name = array("Free disk space on $1", "Total disk space on $1", "Used disk space on $1");

    function convertBtoGb($valor) {
        return round(($valor / 1024 / 1024 / 1024), 2) . ' Gb';
    }

    $i = 0;
    $disco_nome = array();
    $disco_total = array();
    $disco_livre = array();
    $disco_uso = array();
    foreach ($lista_items as $value) {
        $dado_item = $rede_servidores->dadoItem($value['itemid']);
        foreach ($dado_item as $item) {
            $item_tamanho = $item['tamanho'];
        }
        if (($value['key_'] == "vm.memory.size[total]")) {
            $memoria_total = $item_tamanho;
        } elseif (( $value['key_'] == "vm.memory.size[free]") || ( $value['key_'] == "vm.memory.size[available]")) {
            $memoria_livre = $item_tamanho;
        } elseif (( $value['name'] == "Total disk space on $1")) {
            $disco_nome[$i] = str_replace(",total]", "", str_replace("vfs.fs.size[", "", $value['key_']));
            $disco_total[$i] = $item_tamanho;
            $i = $i + 1;
        }
    }
    $memoria_uso = ($memoria_total - $memoria_livre);
    foreach ($disco_nome as $key => $value) {
        foreach ($lista_items as $v) {
            $dado_item = $rede_servidores->dadoItem($v['itemid']);
            foreach ($dado_item as $item) {
                $item_tamanho = $item['tamanho'];
            }
            $key_livre = "vfs.fs.size[" . $value . ",free]";
            $key_uso = "vfs.fs.size[" . $value . ",used]";
            if ($key_uso == $v['key_']) {
                $disco_uso[$key] = $item_tamanho;
            } elseif ($key_livre == $v['key_']) {
                $disco_livre[$key] = $item_tamanho;
            }
        }
    }
    ?>
    <div class="col-lg-12">
        <a type="button" class="btn btn-danger" href="servidores_listar_servidores.php" style="width: 100%;">Voltar<span class="glyphicon glyphicon-backward"></span></a>      
    </div>
    <div class="col-lg-4">
        <div class="col-lg-12">
            <h2>Dados CPU Servidor</h2>                
            <label for="graficos">Graficos Disponíveis</label>
            <table class="table table-hover table-striped table-condensed" name="graficos" id="graficos">
                <thead>
                    <tr>
                        <th>Nome Grafico</th>  
                        <th>Vizualizar</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista_graf_cpu = array("CPU load", "CPU jumps", "CPU utilization", "Uso Processador");
                    foreach ($dados_graficos as $grafico) {
                        if (in_array($grafico['name'], $lista_graf_cpu)) {
                            ?>                
                            <tr>
                                <td><?php echo $grafico['name']; ?></td>
                                <td><?php echo '<a type="button" class="btn btn-primary"  target="blank_" href="servidores_servidor_grafico.php?grafico=' . $grafico['graphid'] . '"><span class="glyphicon glyphicon-stats"></span></a>'; ?></td>                           
                            </tr>  
                            <?php
                        }
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
        <div class="col-lg-12">
            <h2>Dados Rede Servidor</h2>
            <label for="rede">Interfaces Monitoradas</label>
            <table class="table table-hover table-striped table-condensed" name="rede" id="rede">
                <thead>
                    <tr>  
                        <th>IP</th>  
                        <th>Principal</th>                                                     
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        foreach ($dados_interfaces as $value) {
                            ?>
                            <td><?php echo $value['ip']; ?></td>
                            <td><?php echo $rotina->imprimiAtivo($value['main']); ?></td>                                                         
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <label for="graficos">Graficos Disponíveis</label>
            <table class="table table-hover table-striped table-condensed" name="graficos" id="graficos">
                <thead>
                    <tr>
                        <th>Nome Grafico</th>  
                        <th>Vizualizar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista_graf_discos = array("Tempo de Resposta", "Trafego de rede PLACA 1", "Trafego de rede PLACA 2", "Trafego de rede PLACA 3", "Network traffic on eno16777984", "Network traffic on enp3s4f0", "Network traffic on enp3s4f1", "Network traffic on ens160", "Network traffic on ens192", "Network traffic on eth0", "Network traffic on virbr0-nic", "Network traffic on virbr0");
                    foreach ($dados_graficos as $grafico) {
                        if (in_array($grafico['name'], $lista_graf_discos)) {
                            ?>                
                            <tr>
                                <td><?php echo $grafico['name']; ?></td>
                                <td><?php echo '<a type="button" class="btn btn-primary"  target="blank_" href="servidores_servidor_grafico.php?grafico=' . $grafico['graphid'] . '"><span class="glyphicon glyphicon-stats"></span></a>'; ?></td>                           
                            </tr>  
                            <?php
                        }
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>

        <div class="col-lg-12">
            <h2>Dados Memoria Servidor</h2>                
            <table class="table table-hover table-striped table-condensed centraltd" name="memoria" id="memoria">
                <thead>
                    <tr>  
                        <th>Uso</th>  
                        <th>Livre</th>  
                        <th>Total</th>  
                        <th>Grafico</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dados_graficos as $grafico) {
                        if ($grafico['name'] == "Memory usage") {
                            ?>                
                            <tr>
                                <td><?php echo convertBtoGb($memoria_uso); ?></td>
                                <td><?php echo convertBtoGb($memoria_livre); ?></td>
                                <td><?php echo convertBtoGb($memoria_total); ?></td>                            
                                <td><?php echo '<a type="button" class="btn btn-primary"  target="blank_" href="servidores_servidor_grafico.php?grafico=' . $grafico['graphid'] . '"><span class="glyphicon glyphicon-stats"></span></a>'; ?></td>                           
                            </tr>  
                            <?php
                        }
                    }
                    ?>                                          
                </tbody>
            </table>    
        </div>
        <div class="col-lg-12">
            <h2>Dados Unidades Disco</h2>                
            <table class="table table-hover table-striped table-condensed" name="discos" id="discos">
                <thead>
                    <tr>
                        <th>Nome</th>  
                        <th>Uso</th>  
                        <th>Livre</th>  
                        <th>Total</th>  
                        <th>Grafico Cresc.</th>                       
                        <th>Grafico Pizza</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $graficoCresc = 0;
                    $graficoPizza = 0;

                    foreach ($disco_nome as $key => $value) {
                        $nome_cresc = "Crescimento uso disco " . $value;
                        $nome_pizza = "Uso espaço em Disco " . $value;
                        foreach ($dados_graficos as $grafico) {
                            if ($grafico['name'] == $nome_cresc) {
                                $graficoCresc = $grafico['graphid'];
                            } elseif ($grafico['name'] == $nome_pizza) {
                                $graficoPizza = $grafico['graphid'];
                            }
                        }
                        ?>                
                        <tr>
                            <td><?php echo $value; ?></td>
                            <td><?php echo convertBtoGb($disco_uso[$key]); ?></td>
                            <td><?php echo convertBtoGb($disco_livre[$key]); ?></td>
                            <td><?php echo convertBtoGb($disco_total[$key]); ?></td>                            
                            <td class="centraltd"><?php echo '<a type="button" class="btn btn-primary"  target="blank_" href="servidores_servidor_grafico.php?grafico=' . $graficoCresc . '"><span class="glyphicon glyphicon-stats"></span></a>'; ?></td>                           
                            <td class="centraltd"><?php echo '<a type="button" class="btn btn-primary"  target="blank_" href="servidores_servidor_grafico.php?grafico=' . $graficoPizza . '"><span class="glyphicon glyphicon-stats"></span></a>'; ?></td>                           
                        </tr>  
                    <?php } ?>
                </tbody>
            </table>    
        </div>
        <div class="col-lg-12">
            <h2>Todos Gráficos Disponíveis</h2>            
            <table class="table table-hover table-striped table-condensed" name="graficos" id="graficos">
                <thead>
                    <tr>
                        <th>Nome Grafico</th>  
                        <th>Vizualizar</th>                       

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dados_graficos as $grafico) {
                        ?>                
                        <tr>
                            <td><?php echo $grafico['name']; ?></td>
                            <td><?php echo '<a type="button" class="btn btn-primary"  target="blank_" href="servidores_servidor_grafico.php?grafico=' . $grafico['graphid'] . '"><span class="glyphicon glyphicon-stats"></span></a>'; ?></td>                           
                        </tr>  
                        <?php
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
    </div>    

    <div class="col-lg-8">
        <h2>Dados Servidor</h2>
        <?php foreach ($dados_servidor as $value) { ?>
            <div class="form-group text-center col-lg-6">
                <label for="nome">Nome Servidor</label>
                <input type="text" class="form-control text-center" readonly="" id="nome" name="nome" value="<?php echo $value['host']; ?>">
                <label for="descricao">Descrição Principal</label>
                <input type="text" class="form-control text-center" readonly="" id="descricao" name="descricao" value="<?php echo $value['description']; ?>">
                <label for="type">Tipo Servidor</label>
                <input type="text" class="form-control text-center" readonly="" id="type" name="nome" value="<?php echo $value['type_full']; ?>">
                <label for="so">Sistema Operacional</label>
                <input type="text" class="form-control text-center" readonly="" id="so" name="so" value="<?php echo $value['os_full']; ?>">
            </div>
            <div class="form-group text-center col-lg-6">
                <label for="nome">Informação S.O. ZBX</label>
                <input type="text" class="form-control text-center" readonly="" id="nome" name="nome" value="<?php echo $value['os']; ?>">
                <label for="nome">Ambiente</label>
                <input type="text" class="form-control text-center" readonly="" id="nome" name="nome" value="<?php echo $value['tag']; ?>">
                <label for="nome">Contato Servidor</label>
                <input type="text" class="form-control text-center" readonly="" id="nome" name="nome" value="<?php echo $value['contact']; ?>">
                <label for="nome">Localização</label>
                <input type="text" class="form-control text-center" readonly="" id="nome" name="nome" value="<?php echo $value['location']; ?>">            
            </div>
        <?php } ?>
        <div class="col-lg-12">
            <iframe src="servidores_servidor_aplicativo.php?hostid=<?php echo $hostid;?>" width="100%" height="620px" style="border: 0px;"></iframe>             
        </div>
    </div>

    <?php
}        