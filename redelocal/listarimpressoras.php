    <?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao('');   

    $circuitos = new Circuitos();
    
    $zabbix = new ZabbixSEED();
    $switch = new Switchs();
    if(!isset($_POST['bloco'])) { $_POST['bloco'] = ''; } 
    if(!isset($_POST['rack'])) { $_POST['rack'] = ''; } 
    $bloco  = $_POST ["bloco"];
    $rack   = $_POST ["rack"];	    
    $zbx = '2';
    ?>
        <div class="col-xs-2">                        
            <form class="form-horizontal" method="post" action="">
             <div class="form-group">
               <div class="col-xs-10 col-xs-offset-2">                                     
                <div class="form-group">
                  <label for="bloco">Bloco</label>
                  <input type="text" class="form-control" id="bloco" name="bloco" value="<?php echo $bloco;?>">
                </div>
                <div class="form-group">
                  <label for="rack">Rack</label>
                  <input type="text" class="form-control" id="rack" name="rack" value="<?php echo $rack;?>">
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
                        <th>Tipo</th>
                        <th>Vlan</th>
                        <th>Nome Impressora</th>
                        <th>Marca - Modelo</th>
                        <th>Laser</th>
                        <th>Tinta</th>
                        <th>Colorida</th>
                        <th>Scanner</th>
                        <th>Rede</th>
                        <th>Grupo</th>
                        <th>Ativo?</th>
                        <th>Dias Sit.</th>                    
                      </tr>
                    </thead>
                    <tbody>
                      <?php                        
                        $resultado_detalhada2 = $switch->listImpressoras($bloco,$rack);
                        $consultaZabbix = $zabbix->listImpr(); 
                        foreach ($resultado_detalhada2 as $table){
                            $cadzbx = 3;
                            $sitZbx = 0;
                            $tipoZbx = "N/C";
                            $IpZbx = "";
                            $nomeImpzbx = "";
                            foreach ($consultaZabbix as $tableZbx){ 
                                if($tableZbx["hostid"]==$table["codigo_host_zabbix"]){
                                    $nomeImpzbx = $tableZbx["host"];
                                    $cadzbx = $tableZbx["value"];
                                    $sitZbx = $tableZbx["tempo_inativo"]; 
                                    $tipoZbx = $tableZbx["grupo"];
                                    $IpZbx = $tableZbx["ip"];
                                }
                                }                                
                                if($cadzbx == '1'){
                                   echo '<tr class="danger">';
                                } elseif ($cadzbx == '0') {
                                   echo '<tr class="success">';
                                } else {
                                   echo '<tr>';    
                                }                                  
                                echo  " <td>".$table["bloco"]."</td> "
                                    . " <td>".$table["rack"]."</td>"
                                    . ' <td><a title="Abrir Interface Configuração Switch" target="_blank" href="'."http://".$table["ip"].'">'.$table["ip"]."</a></td>"
                                    . ' <td><a title="Abrir Tela Configuração Porta Switch Sistema" target="_blank" href="../redelocal/editportasw.php?sw='.$table["codigo_switch"].'&port='.$table["codigo_porta_switch"].'&tipo='.$table["tipo_porta"].'">'.$table["codigo_porta_switch"].'</a></td>'
                                    . " <td>".$table["tipo_porta_desc"]."</td> "
                                    . " <td>".$table["codigo_vlan"]."</td>"
                                    . ' <td><a title="Abrir Interface Configuração Impressora" target="_blank" href="'."http://".$IpZbx.'">'.$nomeImpzbx."</a></td>"
                                    . " <td>".$table["marca"]." - ".$table["modelo"]."</td>"
                                    . " <td>".$zabbix->imprimiSitu($table["laser"])."</td>"
                                    . " <td>".$zabbix->imprimiSitu($table["tinta"])."</td>"
                                    . " <td>".$zabbix->imprimiSitu($table["colorida"])."</td>"
                                    . " <td>".$zabbix->imprimiSitu($table["scanner"])."</td>"
                                    . " <td>".$zabbix->imprimiSitu($table["rede"])."</td>"        
                                    . " <td>".$tipoZbx."</td>"
                                    . " <td>".$zabbix->imprimiSitu($cadzbx)."</td>"
                                    . " <td>".$sitZbx."</td> </tr>";
                                
                        }
                ?>                                          
                    </tbody>
                  </table>
                </div>
        </div>
<?php 
    include ("../class/footer.php");
