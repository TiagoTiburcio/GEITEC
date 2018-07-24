<?php
    include_once '../class/principal.php';
    
    $rotina = new RotinasPublicas();
    
if ($rotina->validaSessao('') == 1){

    $circuitos = new Circuitos();   
    if(!isset($_GET ['arquivo'])) { $_GET ['arquivo'] = ''; }
    if(!isset($_GET ['num_linha'])) { $_GET ['num_linha'] = ''; }
    $arquivo	= $_GET ["arquivo"];    
    $num_linha    = $_GET ["num_linha"];
    if(($arquivo !=  '')||($num_linha !=  '')){     
        $dados_linha = $circuitos->listaLinhaArquivo($arquivo, $num_linha);
        foreach ($dados_linha as $table){ 
            $contrato = $table['contrato'];
            $designacao = $table['designacao'];
            $cidade = $table['nome_local'];
        }
    } else {
            $contrato = '';
            $designacao = '';
            $cidade = '';
    }
?>  
    <div class="col-lg-8 col-lg-offset-2">
        <form class="form-horizontal" method="post" action="../circuitos/editlinhaarq_grava.php">
            <div class="form-group">
              <div class="col-xs-12">                                     
                <div class="form-group">
                  <label for="designacao">Designação Serviço</label>
                  <input type="text" class="form-control" id="designacao" name="designacao" value="<?php echo $designacao;?>">
                </div>
                <div class="form-group">
                    <label for="arquivo">Nome Arquivo</label>
                    <input type="text" class="form-control" readonly="true" id="arquivo" name="arquivo" value="<?php echo $arquivo;?>">
                </div>  
                <div class="form-group">
                    <label for="num_linha">Número Linha Arquivo</label>
                    <input type="text" class="form-control" readonly="true" id="num_linha" name="num_linha" value="<?php echo $num_linha;?>">
                </div>
                <div class="form-group">
                  <label for="contrato">Número Contrato Serviço</label>
                  <input type="text" class="form-control" readonly="true" id="contrato" name="contrato" value="<?php echo $contrato;?>">
                </div>                
                <div class="form-group">
                  <label for="cidade">Cidade Serviço</label>
                  <input type="text" class="form-control" readonly="true" id="cidade" name="cidade" value="<?php echo $cidade;?>">
                </div>
                <div class="form-group ui-widget">
                <label for="combobox" >Pesquise um registro consumo vinculado: </label>
                    <select class="form-control" id="combobox" name="combobox">
                    <option value="">Escolha Unidade</option>
                    <?php              
                        $consulta_unidade = $circuitos->listaRegConsumo();
                        foreach ($consulta_unidade as $unidades){
                        echo '<option value="'.$unidades['codigo'].'">'.$unidades['codigo'].' </option>';        
                        }
                    ?>
                    </select>
                </div>
                <div class="text-center col-xs-12">
                    <a type="button" class="btn btn-danger" href="confirmaimport.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                    
                    <button type="submit" class="btn btn-success">Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>                  
                </div>
               </div>
            </div>  
        </form>
    </div>
<?php
include ("../class/footer.php");
 }