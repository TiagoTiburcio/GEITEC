<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if ($usuario->validaSessao('') == 1){  

    $circuitos = new Circuitos();   
    if(!isset($_POST['diretoria'])) { $_POST['diretoria'] = ''; }
    if(!isset($_POST['unidade'])) { $_POST['unidade'] = ''; }
    if(!isset($_POST['fatura'])) { $_POST['fatura'] = ''; }
    if(!isset($_POST['circuito'])) { $_POST['circuito'] = ''; }
    if(!isset($_POST['mes'])) { $_POST['mes'] = '';}    
    $diretoria  = $_POST ["diretoria"];
    $unidade	= $_POST ["unidade"];	
    $fatura	= $_POST ["fatura"];
    $circuito   = $_POST ["circuito"];
     

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
                        <th>DRE</th>
                        <th>Cidade</th>
                        <th>Nome Unidade</th>
                        <th>Designacao</th>
                        <th>Contrato</th>
                        <th>Velocidade</th>
                        <th>Endere&ccedil;o</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $resultado_analitico2 = $circuitos->listaCircuitosCadstrados($fatura, $diretoria, $unidade, $circuito);
                        foreach ($resultado_analitico2 as $table){                        
                    ?>                
                   <tr>
                        <td><?php echo $table["sigla_dre"]; ?></td>
                        <td><?php echo $table["nome_cidade"]; ?></td>
                        <td><?php echo $table["nome_unidade"]; ?></td>
                        <td><?php echo $table["designacao"]; ?></td>
                        <td><?php echo $table["fatura"]; ?></td>
                        <td><?php echo $table["velocidade"]; ?></td>
                        <td><?php echo $table["tip_logradouro"].' '.$table["nome_logradouro"].' '.$table["num_imovel"].', '.$table["nome_bairro"].' '; ?></td>
                   </tr>  
                <?php
                        }
                ?>                                          
                    </tbody>
                </table>
            </div>
           </div>
        </div>
<?php
include ("../class/footer.php");
    }