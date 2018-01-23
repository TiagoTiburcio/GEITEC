<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
    
    $switch = new Switchs();
        
    $marca	= $_POST ["marca"];	
    
    $modelo      = $_POST ["modelo"];
    
    $ip      = $_POST ["ip"];
    
    $bloco      = $_POST ["bloco"];
    
    $setor      = $_POST ["setor"];
    
?>
        <div class="col-xs-2">                        
            <form class="form-horizontal" method="post" action="">
             <div class="form-group">
               <div class="col-xs-10 col-xs-offset-2">                
                <div class="form-group">
                  <label for="marca">Marca</label>
                  <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $marca;?>">
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo SW</label>
                  <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $modelo;?>">
                </div>
                <div class="form-group">
                    <label for="ip">Endereço IP</label>
                  <input type="text" class="form-control" id="ip" name="ip" value="<?php echo $ip;?>">
                </div>
                <div class="form-group">
                    <label for="bloco">Bloco</label>
                  <input type="text" class="form-control" id="bloco" name="bloco" value="<?php echo $bloco;?>">
                </div>
                <div class="form-group">
                    <label for="setor">Setor</label>
                  <input type="text" class="form-control" id="setor" name="setor" value="<?php echo $setor;?>">
                </div>   
                  <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                  <button type="submit" class="btn btn-primary" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
               </div>
             </div>  
            </form>
        </div>
        <div class="col-xs-10">
            <div class="col-xs-12">
               <?php $resultado_sws = $switch->listaSwitch($marca,$modelo,$ip,$bloco,$setor);
                     $resultado_portas_sws = $switch->listPortasSwitch();  
                        foreach ($resultado_sws as $table_sws){
                            $portasFC = 'FC';
               if($table_sws["numero_empilhamento"] != '2' ){ 
                   if ($table_sws["empilhado"] == '1'){ $empilhado = 'Sim';} else { $empilhado = 'Não'; } 
                   echo '<label for="sw">'
                        .'Bloco / Rack : '.$table_sws["nome_bloco"].' '.$table_sws["descricao_bloco"].' / '.$table_sws["descricao_rack"].' '.$table_sws["setor_rack"].' '
                        .' <br/> Marca / Modelo : '.$table_sws["marca_sw"].' / '.$table_sws["modelo_sw"]
               .' <br/> IP Acesso / Empilhado: '.'<a target="_blank" href="http://'.$table_sws["ip"].'">'.$table_sws["ip"].'</a> / '.$empilhado.' </label>'; }?>
                <table class="table table-hover table-striped table-condensed centraltd" id="sw">                    
                    <tbody>
                        <tr>                       
                            <?php 
                            for($contador = 1; $contador <= $table_sws["qtd_portas_eth"]; $contador++){
                                if ($contador%2 ==  1) { 
                                    echo '<th class="centraltd">'.$contador."</th>";
                                    }                                  
                                }
                            echo '<th class="centraltd"> | </th>';    
                            for($contador = 1; $contador <=$table_sws["qtd_portas_fc"]; $contador++){
                                if ($contador%2 ==  1) {
                                echo '<th class="centraltd">'.$contador."</th>";
                                }
                            }    
                             ?>
                        </tr>                                           
                            
                        <tr>
                            <?php 
                            $tipoPorta = '1';
                            for($contador = 1; $contador <= $table_sws["qtd_portas_eth"]; $contador++){
                                if ($contador%2 ==  1) {
                                    $tela = '<td> <a type="button" class="btn btn-primary fonteSw" " href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$table_sws["vlan_padrao"].'</a></td>';
                                    foreach ($resultado_portas_sws as $table_portas_sws){                                        
                                        if (($table_sws["codigo_sw"] == $table_portas_sws["codigo_switch"]) &&
                                            ($table_portas_sws["codigo_porta_switch"] == $contador) &&
                                            ($table_portas_sws["tipo_porta"] == $tipoPorta)){
                                                $tela = '<td> <a type="button" class="btn btn-default fonteSw" style="background: '.$table_portas_sws["cor"].'; color: '.$table_portas_sws["fonte"].';" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$table_portas_sws["texto_tela"].'</a></td>';
                                            }}
                                            echo $tela;        
                                    }
                                    
                            }
                            echo '<th class="centraltd"> | </th>';
                            $tipoPorta = '2';
                            for($contador = 1; $contador <= $table_sws["qtd_portas_fc"]; $contador++){
                                if ($contador%2 ==  1) {
                                    $tela = '<td> <a type="button" class="btn btn-primary fonteSw" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$portasFC.'</a></td>';
                                    foreach ($resultado_portas_sws as $table_portas_sws){
                                        if (($table_sws["codigo_sw"] == $table_portas_sws["codigo_switch"]) &&
                                            ($table_portas_sws["codigo_porta_switch"] == $contador) &&
                                            ($table_portas_sws["tipo_porta"] == $tipoPorta)){
                                                $tela = '<td> <a type="button" class="btn btn-default fonteSw" style="background: '.$table_portas_sws["cor"].'; color: '.$table_portas_sws["fonte"].';" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$table_portas_sws["texto_tela"].'</a></td>';
                                            } else {
                                                '<td> <a type="button" class="btn btn-primary fonteSw" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$portasFC.'</a></td>';
                                                }                                            
                                            }
                                            echo $tela;
                                }
                            }?>                        
                        </tr>
                        
                        <tr>                        
                            <?php 
                            $tipoPorta = '1';
                            for($contador = 1; $contador <= $table_sws["qtd_portas_eth"]; $contador++){
                                if ($contador%2 == 0) { 
                                    $tela = '<td> <a type="button" class="btn btn-primary fonteSw" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$table_sws["vlan_padrao"].'</a></td>';
                                    foreach ($resultado_portas_sws as $table_portas_sws){
                                        if (($table_sws["codigo_sw"] == $table_portas_sws["codigo_switch"]) &&
                                            ($table_portas_sws["codigo_porta_switch"] == $contador) &&
                                            ($table_portas_sws["tipo_porta"] == $tipoPorta)){
                                                $tela = '<td> <a type="button" class="btn btn-default fonteSw" style="background: '.$table_portas_sws["cor"].'; color: '.$table_portas_sws["fonte"].';" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$table_portas_sws["texto_tela"].'</a></td>';
                                            } else {
                                                '<td> <a type="button" class="btn btn-primary fonteSw" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$portasFC.'</a></td>';
                                                }                                            
                                            }
                                            echo $tela;
                                }
                            }
                            echo '<th class="centraltd"> | </th>';    
                            $tipoPorta = '2';
                            for($contador = 1; $contador <= $table_sws["qtd_portas_fc"]; $contador++){
                                if ($contador%2 ==  0) { 
                                    $tela = '<td> <a type="button" class="btn btn-primary fonteSw" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$portasFC.'</a></td>';
                                    foreach ($resultado_portas_sws as $table_portas_sws){
                                        if (($table_sws["codigo_sw"] == $table_portas_sws["codigo_switch"]) &&
                                            ($table_portas_sws["codigo_porta_switch"] == $contador) &&
                                            ($table_portas_sws["tipo_porta"] == $tipoPorta)){
                                                $tela = '<td> <a type="button" class="btn btn-default fonteSw" style="background: '.$table_portas_sws["cor"].'; color: '.$table_portas_sws["fonte"].'; " href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$table_portas_sws["texto_tela"].'</a></td>';
                                            } else {
                                                '<td> <a type="button" class="btn btn-primary fonteSw" href="../redelocal/editportasw.php?sw='.$table_sws["codigo_sw"].'&port='.$contador.'&tipo='.$tipoPorta.'">'.$portasFC.'</a></td>';
                                                }                                            
                                            }
                                            echo $tela;
                                    
                                }
                            }?>    
                        </tr>
                        <tr>                       
                            <?php for($contador = 1; $contador <= $table_sws["qtd_portas_eth"]; $contador++){
                               if ($contador%2 == 0) { echo '<th class="centraltd">'.$contador."</th>";}
                            }
                            echo '<th class="centraltd"> | </th>';    
                            for($contador = 1; $contador <= $table_sws["qtd_portas_fc"]; $contador++){
                                if ($contador%2 == 0) {
                                echo '<th class="centraltd">'.$contador."</th>";
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
                        <?php }?>
            </div>
           </div>
        </div>
    <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/jquery.mask.test.js"></script>
<?php 
    include ("../class/footer.php");

