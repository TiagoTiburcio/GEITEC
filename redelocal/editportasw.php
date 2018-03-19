<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    if ($usuario->validaSessao('') == 1){
    $switch = new Switchs();
    
    $zabbix = new ZabbixSEED();
  
    $codigo_sw	= $_GET ["sw"];
    $porta_sw	= $_GET ["port"];
    $tipo_porta = $_GET ["tipo"];
    $resultado_porta = $switch->iniPorta($porta_sw, $codigo_sw, $tipo_porta);    
    foreach ($resultado_porta as $table_porta){
?>
        <div class="col-xs-12 text-center">
            <h2>Manuten&ccedil;&atilde;o Porta Switch</h2>
            <h2></h2>
            <form class="form-horizontal" method="post" id="cadPorta" name="cadPorta" onsubmit="return validaCadastroPortaSw();" action="gravaeditportasw.php">
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
                <input type="text" id="vlansw" name="vlansw" style=" visibility: hidden;" value="<?php echo $table_sws["vlan_padrao"];?>">         
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
                  <input type="text" class="form-control centraltd" readonly="true" id="empilha" name="empilha" value="<?php echo $table_sws["numero_empilhamento"].' / '.$table_porta["codigo_porta_switch"].' / '; if($table_porta["tipo_porta"]=='1'){echo 'ETH';}else{echo 'FC';}?>">
                </div>   
                       <?php
                }?>
                <div class="form-group">
                    <label for="limpar">Gravar configuração Default na porta?</label><br/>
                    <div class="radio-inline">
                        <label><input type="radio" id="limpar" name="limpar" onclick="return mostraTelaPorta();" checked="" value="0">Manter Configuração Atual.</label>
                    </div>
                    <div class="radio-inline">
                        <label><input type="radio" id="limpar" name="limpar" onclick="return escondeTelaPorta();" value="1">Limpar Configuração.</label>
                    </div>                                        
                </div>   
                   <div id="limpaTela" name="limpaTela">
                <div class="input-group centraliza">
                    <label for="vlan">VLAN Porta</label>
                  <select class="form-control centraltd" id="vlan" name="vlan" onclick="return testeVlan();">
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
                   
                <div id="cadImp" name="cadImp" <?php if($table_porta["codigo_vlan"] != '300'){ echo 'style=" display: none;"';}?>>
                    <div class="input-group centraliza">
                        <label for="Imp">Impressora Zabbix SEED</label>
                        <select class="form-control centraltd" id="Imp" name="Imp">
                            <option value="0">Escolha Impressora Cadastrada no Zabix</option>
                        <?php
                                $resultado_impressora = $zabbix->listImpr();
                                $resultado_impressora1 = $switch->listImprCad();
                                foreach ($resultado_impressora as $table_impressora){
                                    $vinculado = '0';
                                   foreach ($resultado_impressora1 as $table_impressora1){                                       
                                       if ($table_impressora["hostid"] == $table_impressora1["codigo_host_zabbix"] ) {
                                           $vinculado = '1';
                                           $cd_sw = $table_impressora1["codigo_switch"];
                                           $pt_sw = $table_impressora1["codigo_porta_switch"];
                                       }
                                   }
                                   if($vinculado == '1'){
                                       if ($table_porta["cod_imp"] == $table_impressora["hostid"] ){
                                           echo ' <option style="background: green; color: white;" selected="" value="'.$table_impressora["hostid"].'" >'.$table_impressora["host"].' - '.$table_impressora["ip"].' / SW - '.$cd_sw.' PT - '.$pt_sw.'</option>';   
                                       } else {
                                           echo ' <option style="background: yellow; " value="'.$table_impressora["hostid"].'" >'.$table_impressora["host"].' - '.$table_impressora["ip"].' / SW - '.$cd_sw.' PT - '.$pt_sw.'</option>';   
                                       } 
                                       
                                   } else {
                                       echo ' <option value="'.$table_impressora["hostid"].'" >'.$table_impressora["host"].' - '.$table_impressora["ip"].' / Não Vinculada Porta SW</option>';   
                                   }
                                   
                                }
                        ?>                                       
                        </select>                       
                    </div>
                    Obs: Ao Cadastrar em uma porta já vinculada a anterior irá voltar para configuração Padrão.
                    <br/><a type="button" class="btn btn-primary" target="_blank" href=" http://10.24.0.59/zabbix/hosts.php?groupid=15&form=Criar+host&templates=10104">Impressora Não Cadastrada no Zabbix <span class="glyphicon glyphicon-plus-sign"></span></a>
                    <div class="input-group centraliza">
                        <label for="modImp">Modelo Impressora no Local</label>
                        <select class="form-control centraltd" id="modImp" name="modImp">
                           <option value="0"> Escolha o Modelo da Impressora</option>
                        <?php
                                $resultado_modImp = $switch->listModImpr();
                                foreach ($resultado_modImp as $table_modImp){
                                    if ($table_porta["codigo_modelo"] == $table_modImp["codigo"] ) {
                                        echo ' <option value="'.$table_modImp["codigo"].'" selected="" >'.$table_modImp["marca"].' - '.$table_modImp["modelo"].'</option>';
                                    }else{
                                        echo ' <option value="'.$table_modImp["codigo"].'" >'.$table_modImp["marca"].' - '.$table_modImp["modelo"].'</option>';                                    
                                    }
                                }
                        ?>                                       
                        </select>                       
                    </div>
                    <div class="form-group">
                        <label for="setorImp">Setor Impressora:</label>
                        <input type="text" class="form-control centraltd" id="setorImp" name="setorImp" value="<?php echo $table_porta["setor"];?>">
                    </div>
                </div>
                   
                <div class="form-group">
                  <label for="observacao">Observações Sobre a Porta:</label>
                  <input type="text" class="form-control centraltd" id="observacao" name="observacao" value="<?php echo $table_porta["observacao"];?>">
                </div>
                <div class="input-group centraliza">
                  <label for="opcaoTexto">Modo Texto Tela</label>
                  <select class="form-control centraltd" id="opcaoTexto" name="opcaoTexto" onclick=" return mostraOpcaoTela(); ">
                      <option value="1" selected=""> Vlan Configurada </option>
                      <option value="0"> Texto Personalizado </option>                      
                  </select>
                </div>       
                       <div class="form-group" style=" display: none; " id="divTela" name="divTela">
                  <label for="tela"> Texto Tela Switch Limite 5 caracteres:</label>
                  <input type="text" class="form-control centraltd" id="tela" name="tela" maxlength="5" value="<?php echo $table_porta["texto_tela"];?>">
                </div>
                </div>       
                   <br/><a type="button" class="btn btn-danger" href="listarsw.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                                       
                    <button type="submit" class="btn btn-success" >Gravar <span class="glyphicon glyphicon-save"></span></button>                  
               </div>
             </div>
              
            </form>
        </div>    
    <?php }
    include ("../class/footer.php");

    }