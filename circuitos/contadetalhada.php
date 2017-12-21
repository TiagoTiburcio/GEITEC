    <?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();   

    $circuitos = new Circuitos();
    
    $zabbix = new ZabbixSEED();
    
    $diretoria = $_POST ["diretoria"];
    $unidade	= $_POST ["unidade"];	
    $fatura	= $_POST ["fatura"];
    $circuito  = $_POST ["circuito"];
    $mescad    = $_POST ["mes"];     
    
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
                  <label for="circuito">Circuito</label>
                  <input type="text" class="form-control" id="circuito" name="circuito" value="<?php echo $circuito;?>">
                </div>
                <div class="form-group">
                  <label for="fatura">Contrato</label>
                  <input type="text" class="form-control" id="fatura" name="fatura" value="<?php echo $fatura;?>">
                </div>
                <div class="form-group">
                  <label for="mes">Mes Cobranca</label>
                  <select class="form-control" id="mes" name="mes">
                    
                <?php
                        $resultado_detalhada1 = $circuitos->listaPeriodoRef();
                        foreach ($resultado_detalhada1 as $mes){
                        if($mes["periodo_ref"] == $mescad){
                    ?> 
                      <option value="<?php echo $mes["periodo_ref"]; ?>" selected><?php echo $mes["mes"]; ?></option>                    
                <?php
                        } else {
                    ?> 
                      <option value="<?php echo $mes["periodo_ref"]; ?>" ><?php echo $mes["mes"]; ?></option>                    
                <?php
                            
                        }}
                ?>                                       
                  </select>
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
                        <th>Zabbix</th>
                        <th>Dias Sit.</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php                        
                        $resultado_detalhada2 = $circuitos->listaConsultaDetalhada($unidade,$fatura,$circuito,$diretoria,$mescad);
                        $consultaZabbix = $zabbix->listLinksPagos(); 
                        foreach ($resultado_detalhada2 as $table){
                            $cadzbx = 3;
                            $sitZbx = 0;
                            foreach ($consultaZabbix as $tableZbx){ 
                                if($tableZbx["name"]==$table["circuito"]){$cadzbx = $tableZbx["value"]; $sitZbx = $tableZbx["tempo_inativo"];}
                            } 
                    ?>                
                    <tr>
                        <td><?php echo $table["DRE"]; ?></td>
                        <td><?php echo $table["cidade"]; ?></td>
                        <td><?php echo $table["circuito"]; ?></td>
                        <td><?php echo $table["nome_unidade"]; ?></td>
                        <td><?php echo $table["periodo_ref"]; ?></td>
                        <td><?php echo $table["fatura"]; ?></td>
                        <td><?php echo $table["valor_conta"]; ?></td>
                        <td><?php echo $zabbix->imprimiAtivo($cadzbx); ?></td>
                        <td><?php echo $sitZbx; ?></td>
                    </tr>  
                <?php
                        }
                ?>                                          
                    </tbody>
                  </table>
                </div>
        </div>
<?php 
    include ("../class/footer.php");
