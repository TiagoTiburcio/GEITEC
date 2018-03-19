<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if ($usuario->validaSessao('') == 1){

    $circuitos = new Circuitos();   
    
    $zabbix = new ZabbixSEED();
    if(!isset($_POST['fatura'])) { $_POST['fatura'] = ''; }    
    if(!isset($_POST['mes'])) { $_POST['mes'] = ''; }    
    $fatura	= $_POST ["fatura"];    
    $mescad    = $_POST ["mes"];     
    
?>
        <div class="col-xs-2">                        
            <form class="form-horizontal" method="post" action="">
             <div class="form-group">
               <div class="col-xs-10 col-xs-offset-2">                                  
                <div class="form-group">
                  <label for="fatura">Contrato</label>
                  <input type="text" class="form-control" id="fatura" name="fatura" value="<?php echo $fatura;?>">
                </div>
                <div class="form-group">
                    <label for="mes">M&ecirc;s Cobran&ccedil;a</label>
                  <select class="form-control" id="mes" name="mes">
                    
                <?php
                        $resultado_analitico1 = $circuitos->listaPeriodoRef();
                        foreach ($resultado_analitico1 as $mes){
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
               </div>
             </div>  
            </form>
        </div>
        <div class="col-xs-10">
            <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed  centraltd">
                    <thead>
                        <tr>
                        <th style="text-align:center;vertical-align:middle;">Circuito</th> 
                        <th style="text-align:center;vertical-align:middle;">Situacao</th>
                        <th style="text-align:center;vertical-align:middle;">Data</th>
                        <th style="text-align:center;vertical-align:middle;">Dias Inativo</th>
                        <th style="text-align:center;vertical-align:middle;">Tipo Circuito</th>
                        <th style="text-align:center;vertical-align:middle;">Diretoria</th>
                        <th style="text-align:center;vertical-align:middle;" >Cidade</th>
                        <th>Unidade</th>
                        <th style="text-align:center;vertical-align:middle;">INEP</th>
                        <th style="text-align:center;vertical-align:middle;">Ip</th>                        
                        <th style="text-align:center;vertical-align:middle;">Sit. ZBX</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i = 1;
                        $consultaZabbix = $zabbix->listLinksPagos(); 
                        $consultaContas = $circuitos->listaContaZabbix();
                        foreach ($consultaContas as $tableContas){
                            foreach ($consultaZabbix as $tableZbx){
                                if($tableZbx["name"]==$tableContas["circuito"]){
                    ?>                
                   <tr>
                        <td><?php echo $tableZbx["name"]; ?></td>                        
                        <td><?php echo $tableZbx["situacao"]; ?></td>
                        <td><?php echo date('d/m/Y h:i',strtotime($tableZbx["data"])); ?></td>
                        <td><?php echo $tableZbx["tempo_inativo"]; ?></td>
                        <td><?php echo $tableZbx["grupo"]; ?></td>
                        <td><?php echo $tableContas["DRE"]; ?></td>
                        <td><?php echo $tableContas["cidade"]; ?></td>
                        <td class="esquerdatd"><?php echo $tableContas["nome_unidade"]; ?></td>
                        <td><?php echo $tableZbx["serialno_a"]; ?></td>
                        <td><?php echo $tableZbx["ip"]; ?></td>                        
                        <td><?php if ($tableZbx["status"] == '0') {echo "Ativo";} elseif ($tableZbx["status"] == '1') {echo "Ativo";} ?></td>
                   </tr>  
                                <?php $i = 1 + $i;}
                        }
                        
                    }echo 'QtdLinhas: '.$i;
                ?>                                          
                    </tbody>
                </table>
                
            </div>
           </div>
        </div>
<?php
include ("../class/footer.php");
    }