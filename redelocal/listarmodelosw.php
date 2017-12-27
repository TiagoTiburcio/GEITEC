<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
    
    $switch = new Switchs();
        
    $marca	= $_POST ["marca"];	
    
    $modelo      = $_POST ["modelo"];
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
                  <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                  <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
               </div>
             </div>  
            </form>
        </div>
        <div class="col-xs-10">
            <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                      <tr>                       
                        <th>Marca</th>
                        <th>modelo</th>                        
                        <th>Qtd. Portas</th>
                        <th>Qtd. Portas FC</th>
                        <th>Vel. Portas</th>
                        <th>Manut. Modelo</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $modelos_switch = $switch->listModelosSwitch();
                            foreach ($modelos_switch as $table_modelo_sw){   
//                                SELECT `codigo_marca`, `codigo_modelo`, "
//                      . " `marca`, `modelo`, `qtd_portas`, `qtd_portas_fb`, "
//                      . " `velocidade_padrao` FROM `redelocal_sw_modelo`; ";
                        ?>                
                    <tr>                        
                        <td><?php echo $table_modelo_sw["marca"]; ?></td> 
                        <td><?php echo $table_modelo_sw["modelo"]; ?></td>                      
                        <td><?php echo $table_modelo_sw["qtd_portas"]; ?></td>
                        <td><?php echo $table_modelo_sw["qtd_portas_fb"]; ?></td>
                        <td><?php echo $table_modelo_sw["velocidade_padrao"]; ?></td>
                        <td><?php echo '<a type="button" class="btn btn-primary" href="../redelocal/editmodelo.php?marca='.$table_modelo_sw["codigo_marca"].'&modelo='.$table_modelo_sw["codigo_modelo"].'"><span class="glyphicon glyphicon-edit"></span></a>';?></td>                        
                    </tr>  
                        <?php
                                }
                        ?>                                          
                    </tbody>
                </table>
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

