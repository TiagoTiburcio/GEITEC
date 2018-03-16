<?php
   include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();      
    $circuitos = new Circuitos();   
    if(!isset($_POST['fatura'])) { $_POST['fatura'] = ''; }
    if(!isset($_POST['mes'])) { $_POST['mes'] = ''; }
    $fatura	= $_POST ["fatura"];    
    $mescad    = $_POST ["mes"];   
    if(!isset($_SESSION ['pendente'])) { $_SESSION ['pendente'] = ''; }
    
    if($_SESSION ['pendente'] == 'S'){
        echo '<meta http-equiv="refresh" content=0;url="'.'http://'. $_SERVER['SERVER_NAME'] . str_replace("confirmaimport.php","",$_SERVER['REQUEST_URI']) .'abrirarq.php">';
        $disable_btn = ' disabled="" ';
    } else {
        $disable_btn = '';
    }
 
    $circuitos->limpaImport();
    $resultado_analitico2 = $circuitos->listaProblemaImport();
    
?>  

    <div class="col-xs-7 col-xs-offset-1"> 
        <?php //echo $_SESSION ['linha_inicio1'];?>
        <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Per. Ref.</th>
                        <th>Valor Total</th>
                        <th>Aviso</th>
                        <th>Cancelar</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $resultado_listaProblemaImport = $circuitos->listaContasImport();
                        foreach ($resultado_listaProblemaImport as $table1){                        
                    ?>                
                   <tr>
                        <td><?php echo $table1["contrato"]; ?></td>
                        <td><?php echo $table1["conta"]; ?></td>
                        <td><?php echo $table1["valor_total"]; ?></td>
                        <td><?php                   
                            $aviso = '';
                            foreach ($resultado_analitico2 as $table){
                                if(($table["contrato"] == $table1["contrato"])&&($aviso == '')){
                                    $aviso = $aviso.' Possui circuitos com Pendência';
                                }
                            }
                            if ($table1["periodo_ref"] == ''){
                                $aviso = '' .$aviso;        
                            } else {
                                $aviso = '<a '.$disable_btn.' type="button" class="btn btn-danger" href="../circuitos/limpaArquivo.php?contrato='.$table1['contrato'].'&conta='.$table1['periodo_ref'].'&tipo=2 "><span class="glyphicon glyphicon-erase"></span> Limpa Dados Conta para Reimportar</a>'.$aviso;        
                            }
                            if($aviso == ''){
                                echo '<a '.$disable_btn.' type="button" class="btn btn-success" href="../circuitos/addregistroconsumo.php?arquivo='.$table1['nome_arquivo'].'"><span class="glyphicon glyphicon-ok-circle"></span> Confirma Importação Conta!!</a>';
                            } else {
                                echo $aviso;
                            }
                        ?></td>
                        <td><?php echo '<a '.$disable_btn.' type="button" class="btn btn-primary" href="../circuitos/limpaArquivo.php?arquivo='.$table1['nome_arquivo'].'&tipo=1 "><span class="glyphicon glyphicon-erase"></span> Limpa '.$table1['nome_arquivo'].'!!</a>'; ?></td>
                   </tr>  
                <?php
                        }
                ?>                                          
                    </tbody>
                </table>
            </div>
    </div>
    <div class="col-xs-4">
        <label>Upload Arquivos Contas Oi</label>
        <form action="importcontas_grava.php" method="post" enctype="multipart/form-data">
        <p><input type="file" name="arquivo[]" /></p>        
        <p><input type="submit" value="Enviar" <?php echo $disable_btn;?> /></p>
        </form>
    </div>
    <div class="col-xs-10 col-xs-offset-1">                        
        <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Per. Ref.</th>                       
                        <th>Designacao</th>                        
                        <th>Cidade</th>
                        <th>Tipo Logradouro</th>
                        <th>Logradouro</th>
                        <th>Num Imovel</th>
                        <th>Bairro</th>
                        <th>Valor</th>
                        <th>Edit. Arq.</th>
                        <th>Adic. Circuito</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php                        
                        foreach ($resultado_analitico2 as $table){                        
                    ?>                
                   <tr>                        
                       <td><?php echo $table["contrato"]; ?></td>
                        <td><?php echo $table["conta"]; ?></td>                        
                        <td><?php echo $table["designacao"]; ?></td> 
                        <td><?php echo $table["nome_local"]; ?></td>  
                        <td><?php echo $table["tip_logradouro"]; ?></td>  
                        <td><?php echo $table["nome_logradouro"]; ?></td>  
                        <td><?php echo $table["num_imovel"]; ?></td>  
                        <td><?php echo $table["nome_bairro"]; ?></span></td>  
                        <td><?php echo 'R$' . number_format($table["valor_servico"], 2, ',', '.'); ?></td> 
                        <td><?php echo '<a  type="button" '.$disable_btn.' class="btn btn-primary" href="../circuitos/editlinhaarq.php?arquivo='.$table["nome_arquivo"].'&num_linha='.$table["num_linha_arquivo"].'"><span class="glyphicon glyphicon-edit"></span></a>';?></td> 
                        <td><?php echo '<a type="button" '.$disable_btn.' class="btn btn-success" href="../circuitos/novoregconsumo.php?arquivo='.$table["nome_arquivo"].'&num_linha='.$table["num_linha_arquivo"].'"><span class="glyphicon glyphicon-plus-sign"></span></a>';?></td> 
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
