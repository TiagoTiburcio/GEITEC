    <?php
    include_once '../class/principal.php';
    
    $rotina = new RotinasPublicas();
    
    if ($rotina->validaSessao('') == 1){

    $circuitos = new Circuitos();
    
    $zabbix = new ZabbixSEED();
    
    if(!isset($_POST['diretoria'])) { $_POST['diretoria'] = ''; }
    if(!isset($_POST['unidade'])) { $_POST['unidade'] = ''; }
    if(!isset($_POST['cidade'])) { $_POST['cidade'] = ''; }    
    $diretoria  = $_POST ['diretoria'];
    $unidade	= $_POST ['unidade'];
    $cidade   = $_POST ['cidade'];
    if(!isset($_POST ['zabbix'])){
        $zbx    = 2;
    } else {
        $zbx   = $_POST ['zabbix'];
    }   
    ?>
        <div class="col-xs-2">                        
            <form class="form-horizontal" method="post" action="">
             <div class="form-group">
               <div class="col-xs-10 col-xs-offset-2">                                     
                <div class="form-group">
                  <label for="diretoria">Diretoria</label>
                  <input type="text" class="form-control" id="diretoria" name="diretoria" value="<?php echo $diretoria;?>">
                </div>
                <div class="form-group">
                  <label for="unidade">Nome Unidade</label>
                  <input type="text" class="form-control" id="unidade" name="unidade" value="<?php echo $unidade;?>">
                </div>
                <div class="form-group">
                  <label for="cidade">Cidade</label>
                  <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $cidade;?>">
                </div>                
                <div class="form-group">
                    <label for="zabbix">Cadastro Zabbix</label><br/>
                    <div class="radio">
                        <label><input type="radio" name="zabbix" <?php if($zbx == 2){echo 'checked=""';}?> value="2">Todos</label>
                    </div><br/>
                    <div class="radio">
                        <label><input type="radio" name="zabbix" <?php if($zbx == 1){echo 'checked=""';}?> value="1">Inoperante</label>
                    </div><br/>
                    <div class="radio">
                        <label><input type="radio" name="zabbix" <?php if($zbx == 0){echo 'checked=""';}?> value="0">Funcionando</label>
                    </div><br/>
                    <div class="radio">
                        <label><input type="radio" name="zabbix" <?php if($zbx == 3){echo 'checked=""';}?> value="3">Não Cadastrado Zabbix</label>
                    </div><br/>
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
                        <th>Zabbix</th>
                        <th>Dias Sit.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php                        
                        $resultado_detalhada2 = $circuitos->listaUnidades($diretoria,$unidade,$cidade);
                        $consultaZabbix = $zabbix->listLinksPBLE(); 
                        foreach ($resultado_detalhada2 as $table){
                            $cadzbx = 3;
                            $sitZbx = 0;
                            $tipoZbx = "N/C";
                            foreach ($consultaZabbix as $tableZbx){                                
                                if($tableZbx['inep'] == $table['codigo_inep']){
                                    $cadzbx = $tableZbx['value']; 
                                    $sitZbx = $tableZbx['tempo_inativo']; 
                                    $tipoZbx = $tableZbx['name'];}
                                }
                                if(($zbx == 2)){
                                    echo  " <tr> <td>".$table['sigla_dre']."</td> "
                                        . " <td>".$table['cidade']."</td> "
                                        . " <td>".$tipoZbx."</td>"
                                        . " <td>".$table['descricao']."</td>"
                                        . " <td>".$zabbix->imprimiAtivo($cadzbx)."</td>"
                                        . " <td>".$sitZbx."</td> </tr>";
                                } elseif (($zbx == 0) && ($zbx == $cadzbx)) {
                                    echo  " <tr> <td>".$table["sigla_dre"]."</td> "
                                        . " <td>".$table['cidade']."</td> "
                                        . " <td>".$tipoZbx."</td>"
                                        . " <td>".$table['descricao']."</td>"
                                        . " <td>".$zabbix->imprimiAtivo($cadzbx)."</td>"
                                        . " <td>".$sitZbx."</td> </tr>";
                                } elseif (($zbx == 1) && ($zbx == $cadzbx)) {
                                    echo  " <tr> <td>".$table['sigla_dre']."</td> "
                                        . " <td>".$table['cidade']."</td> "
                                        . " <td>".$tipoZbx."</td>"
                                        . " <td>".$table['descricao']."</td>" 
                                        . " <td>".$zabbix->imprimiAtivo($cadzbx)."</td>"
                                        . " <td>".$sitZbx."</td> </tr>";
                                } 
                                //echo 'cadzbx: '.$cadzbx."| sitzbx: ".$sitZbx." | tipozbx: ".$tipoZbx."| desc: ". $tableZbx["inep"]. " | " . $table["codigo_inep"].'|<br/>' ;
                        }
                ?>                                          
                    </tbody>
                  </table>
                </div>
        </div>
<?php 
    include ("../class/footer.php");
    }