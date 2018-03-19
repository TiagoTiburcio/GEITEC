<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    if ($usuario->validaSessao('') == 1){
    
    $zbxCofre = new ZabbixCofre();
    
    if(!isset($_POST['marca'])) { $_POST['marca'] = ''; }
    if(!isset($_POST['modelo'])) { $_POST['modelo'] = ''; }
    if(!isset($_POST['ip'])) { $_POST['ip'] = ''; }
    if(!isset($_POST['bloco'])) { $_POST['bloco'] = ''; } 
    if(!isset($_POST['setor'])) { $_POST['setor'] = ''; }
    $marca	= $_POST ["marca"];	
    
    $modelo      = $_POST ["modelo"];
    
    $ip      = $_POST ["ip"];
    
    $bloco      = $_POST ["bloco"];
    
    $setor      = $_POST ["setor"];
    $log = array();
    
    $consulta_arq_exc = $zbxCofre->listArquivosExcluidos();    
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
            <?php 
            foreach ($consulta_arq_exc as $table) {
                $arq = $table['log'];
                $linhas = explode("\n", file_get_contents($arq));
                foreach ($linhas as $key => $value){
                    echo $value;
                }
            }
            ?>
            
        </div>   
    
<?php 
    include ("../class/footer.php");

    }