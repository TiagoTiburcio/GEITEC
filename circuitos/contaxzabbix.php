    <?php
    session_start();

    //Caso o usuário não esteja autenticado, limpa os dados e redireciona
    if ( !isset($_SESSION['login']) and !isset($_SESSION['pass']) ) {
	//Destrói
	session_destroy();

	//Limpa
	unset ($_SESSION['login']);
	unset ($_SESSION['pass']);
	
	//Redireciona para a página de autenticação
	header('location:login.php');
    }    
    include ("./class/header.php");
    $diretoria = $_POST ["diretoria"];
    $unidade	= $_POST ["unidade"];	
    $fatura	= $_POST ["fatura"];
    $circuito  = $_POST ["circuito"];
    $mescad    = $_POST ["mes"];     
    include_once './conection.php';
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
                        $query3 = "SELECT distinct periodo_ref,  date_format(periodo_ref,'%m/%Y') as mes FROM circuitos_pagos order by periodo_ref desc limit 10";                                
                        $resultado2 = mysqli_query($con, $query3);
                        foreach ($resultado2 as $mes){
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
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $query2 = "SELECT `circuitos_pagos`.`DRE`,"
                                 . " `circuitos_pagos`.`cidade`, `circuitos_pagos`.`circuito`,"
                                 . "`circuitos_pagos`.`nome_unidade`, date_format(periodo_ref,'%m/%Y') as `periodo_ref`,"
                                 . "`circuitos_pagos`.`fatura`, CONCAT('R$ ', REPLACE(REPLACE(REPLACE(FORMAT(valor_conta, 2),'.',';'),',','.'),';',',')) as `valor_conta`FROM `Circuitos_OI`.`circuitos_pagos`"
                                 . "where "
                                 . "`circuitos_pagos`.`nome_unidade` like '%$unidade%'"
                                 . " and `circuitos_pagos`.`fatura` like '%$fatura%'"
                                 . " and `circuitos_pagos`.`circuito` like '%$circuito%'"
                                 . " and `circuitos_pagos`.`DRE` like '%$diretoria%'"
                                 . " and `circuitos_pagos`.`periodo_ref` = '$mescad'"
                                . "order by DRE, cidade, nome_unidade;";
                        $resultado2 = mysqli_query($con, $query2);
                        foreach ($resultado2 as $table){                        
                    ?>                
                   <tr>
                        <td><?php echo $table["DRE"]; ?></td>
                        <td><?php echo $table["cidade"]; ?></td>
                        <td><?php echo $table["circuito"]; ?></td>
                        <td><?php echo $table["nome_unidade"]; ?></td>
                        <td><?php echo $table["periodo_ref"]; ?></td>
                        <td><?php echo $table["fatura"]; ?></td>
                        <td><?php echo $table["valor_conta"]; ?></td>
                   </tr>  
                <?php
                        }
                ?>                                          
                    </tbody>
                  </table>
                </div>
        </div>
<?php 
    include ("./class/footer.php");
?>    