<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();   

    $circuitos = new Circuitos();   
    if(!isset($_GET ['arquivo'])) { $_GET ['arquivo'] = ''; }
    if(!isset($_GET ['num_linha'])) { $_GET ['num_linha'] = ''; }
    $arquivo	= $_GET ["arquivo"];    
    $num_linha    = $_GET ["num_linha"];
    $dados_linha = $circuitos->listaLinhaArquivo($arquivo, $num_linha);
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
        <form class="form-horizontal" method="post" action="../circuitos/addregistroconsumo_grava.php">
           
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
          <label for="combobox" >Escolha a Unidade vinculada ao Serviço: </label>
            <select class="form-control" id="combobox" name="combobox">
            <option value="">Escolha Unidade</option>
            <?php              
             $consulta_unidade = $circuitos->listaUnidadesCadastradas();
             foreach ($consulta_unidade as $unidades){
                 echo '<option value="'.$unidades['codigo'].'">'.$unidades['dre'].' - '.$unidades['nome'].' - '.$unidades['cidade'].' </option>';        
             }
            ?>
          </select>
        </div> 
           
        <div class="form-group">
            <label for="localizacao" style="width: 310px;">Escolha a Localização vinculada ao Serviço: </label>
             <select style="margin: 0; padding: 5px 10px; width: 950px;" id="localizacao" name="localizacao">
            <option value="">Escolha Localizacao</option>
            <?php              
             $consulta_localizacao = $circuitos->listaLocalizacao();
             foreach ($consulta_localizacao as $localizacao){
                 echo '<option value="'.$localizacao['codigo'].'">'.$localizacao['descricao'].' </option>';        
             }
            ?>
          </select>
        </div>    
            <div class="text-center col-xs-12">
                <a type="button" class="btn btn-danger" href="confirmaimport.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                    
                <button type="submit" class="btn btn-success">Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>                  
            </div>                	
        </form>
    </div>
<?php
include ("../class/footer.php");
