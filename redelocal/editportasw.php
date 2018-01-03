<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $switch = new Switchs();
    $usuario->validaSessao();
    $codigo_sw	= $_GET ["sw"];
    $porta_sw	= $_GET ["port"];
    $tipo_porta = $_GET ["tipo"];
    $resultado_porta = $switch->iniPorta($porta_sw, $codigo_sw, $tipo_porta);    
    foreach ($resultado_porta as $table_porta){
?>
        <div class="col-xs-12 text-center">
            <h2>Manuten&ccedil;&atilde;o Porta Switch</h2>
            <h2></h2>
            <form class="form-horizontal" method="post" action="gravaeditportasw.php">
             <input type="text" id="sw" name="sw" style=" visibility: hidden;" value="<?php echo $table_porta["codigo_switch"];?>">
             <input type="text" id="porta" name="porta" style=" visibility: hidden;" value="<?php echo $table_porta["codigo_porta_switch"];?>">
             <input type="text" id="tipo_porta" name="tipo_porta" style=" visibility: hidden;" value="<?php echo $table_porta["tipo_porta"];?>">      
             <div class="form-group">
               <div class="col-xs-4 col-xs-offset-4">
                <?php
                $resultado_sws = $switch->dadosSwitch($codigo_sw);
                foreach ($resultado_sws as $table_sws){ ?>
                <div class="form-group">
                  <label for="bloco">Localização</label>
                  <input type="text" class="form-control centraltd" readonly="true" id="bloco" name="bloco" value="<?php echo ''.$table_sws["nome_bloco"].' - '.$table_sws["descricao_bloco"].' / '.$table_sws["descricao_rack"].' - '.$table_sws["setor_rack"];?>">
                </div>
                <div class="form-group">
                  <label for="tiposw">Tipo Switch</label>
                  <input type="text" class="form-control centraltd" readonly="true" id="tiposw" name="tiposw" value="<?php echo 'Marca '.$table_sws["marca_sw"].' / Modelo '.$table_sws["modelo_sw"];?>">
                </div>
                <div class="form-group">
                  <label for="ip">Ip Acesso</label>
                  <input type="text" class="form-control centraltd" readonly="true" id="tiposw" name="tiposw" value="<?php echo $table_sws["ip"];?>">
                </div>
                <div class="form-group">
                  <label for="empilha">Número Empilhamento / Número Porta / Tipo Porta:</label>
                  <input type="text" class="form-control centraltd" readonly="true" id="empilha" name="Empilha" value="<?php echo $table_sws["numero_empilhamento"].' / '.$table_porta["codigo_porta_switch"].' / '; if($table_porta["tipo_porta"]=='1'){echo 'ETH';}else{echo 'FC';}?>">
                </div>   
                       <?php
                }?> 
                <div class="input-group centraliza">
                    <label for="vlan">VLAN Porta</label>
                  <select class="form-control centraltd" id="vlan" name="vlan">
                <?php
                        $resultado_vlan = $switch->listVlan();
                        foreach ($resultado_vlan as $table_vlan){
                           echo ' <option value="'.$table_vlan["codigo"].'"'; 
                           if($table_vlan["codigo"] == $table_porta["codigo_vlan"]){
                               echo ' selected="" >'.$table_vlan["codigo"].' - '.$table_vlan["descricao"].'</option>';                               
                           } else {
                                   echo ' >'.$table_vlan["codigo"].' - '.$table_vlan["descricao"].'</option>';                               
                           }                           
                        }
                ?>                                       
                  </select>
                </div>                 
                <div class="input-group centraliza">
                  <label for="velocidade">Velocidade Porta</label>
                  <select class="form-control centraltd" id="velocidade" name="velocidade">
                      <option value="40000" <?php if($table_porta["velocidade"] == '40000'){ echo ' selected="" ';} ?>> 40 GBps</option>
                      <option value="10000" <?php if($table_porta["velocidade"] == '10000'){ echo ' selected="" ';} ?>> 10 GBps</option>
                      <option value="1000" <?php if($table_porta["velocidade"] == '1000'){ echo ' selected="" ';} ?>> 1 GBps</option>
                      <option value="100" <?php if($table_porta["velocidade"] == '100'){ echo ' selected="" ';} ?>> 100 MBps</option>
                      <option value="10" <?php if($table_porta["velocidade"] == '10'){ echo ' selected="" ';} ?>> 10 MBps</option>                        
                  </select>
                </div>
                   
                <div class="form-group">
                  <label for="observacao">Observações Sobre a Porta:</label>
                  <input type="text" class="form-control centraltd" id="observacao" name="observacao" value="<?php echo $table_porta["observacao"];?>">
                </div>
                <div class="form-group">
                  <label for="tela"> Texto Tela Switch Limite 5 caracteres:</label>
                  <input type="text" class="form-control centraltd" id="tela" name="tela" maxlength="5" value="<?php echo $table_porta["texto_tela"];?>">
                </div>                   
                   <button type="submit" class="btn btn-success" >Gravar <span class="glyphicon glyphicon-save"></span></button>                  
               </div>
             </div>
              
            </form>
        </div>    
    <?php }
    include ("../class/footer.php");

