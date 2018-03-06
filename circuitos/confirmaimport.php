<?php
   include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();   

    $circuitos = new Circuitos();   
    if(!isset($_POST['fatura'])) { $_POST['fatura'] = ''; }
    if(!isset($_POST['mes'])) { $_POST['mes'] = ''; }
    $fatura	= $_POST ["fatura"];    
    $mescad    = $_POST ["mes"];
    $circuitos->limpaImport();
?>  

    <div class="col-xs-5 col-xs-offset-1">                        
        <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>Contrato</th>
                        <th>Per. Ref.</th>
                        <th>Aviso</th>                       
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
                        <td><?php 
                            if ($table1["periodo_ref"] == ''){
                                echo 'Liberado para Cadastro';        
                            } else {
                                echo 'Já possui Dados Cadastrados';        
                            }
                        ?></td>
                   </tr>  
                <?php
                        }
                ?>                                          
                    </tbody>
                </table>
            </div>
    </div>
    <div class="col-xs-10 col-xs-offset-1">                        
        <div class="col-xs-12">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>Nome Arquivo</th>  
                        <th>Numero Linha</th>
                        <th>Contrato</th>
                        <th>Per. Ref.</th>
                        <th>Vencimento</th>
                        <th>Designacao</th>
                        <th>Tipo Serviço</th>
                        <th>Velocidade Circuito</th>
                        <th>Cidade</th>
                        <th>Tipo Logradouro</th>
                        <th>Logradouro</th>
                        <th>Num Imovel</th>
                        <th>Bairro</th>
                        <th>Valor</th>                       
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $resultado_analitico2 = $circuitos->listaProblemaImport();
                        foreach ($resultado_analitico2 as $table){                        
                    ?>                
                   <tr>
                        <td><?php echo $table["nome_arquivo"]; ?></td>
                        <td><?php echo $table["num_linha_arquivo"]; ?></td>
                        <td><?php echo $table["contrato"]; ?></td>
                        <td><?php echo $table["conta"]; ?></td>
                        <td><?php echo $table["vencimento"]; ?></td>   
                        <td><?php echo $table["designacao"]; ?></td>
                        <td><?php echo $table["prod_telefone"]; ?></td>  
                        <td><?php echo $table["velocidade_circuito"]; ?></td>  
                        <td><?php echo $table["nome_local"]; ?></td>  
                        <td><?php echo $table["tip_logradouro"]; ?></td>  
                        <td><?php echo $table["nome_logradouro"]; ?></td>  
                        <td><?php echo $table["num_imovel"]; ?></td>  
                        <td><?php echo $table["nome_bairro"]; ?></td>  
                        <td><?php echo $table["valor_servico"]; ?></td>  
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
