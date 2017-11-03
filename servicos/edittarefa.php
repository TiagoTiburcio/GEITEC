<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();    
    $servicos = new Servicos();
    
    $usuario->validaSessao();
    
    $evento = $_GET ["evento"];
    
    if ($evento != "") {
        $teste = $servicos->iniEvento($evento);
        if($teste = 0){
            echo " Evento Não Cadastrado!!!!!! ";
        }
    } else {
       // header("Location: calendario.php");
    }    
    
    
?>                
    <div class="col-xs-offset-4 col-xs-3">
        <form class="form-horizontal" method="post" action="../servicos/edittarefa_grava.php">
            <div class="form-group">
              <div class="col-xs-12">                                     
                <div class="form-group">
                  <label for="evento">ID Evento</label>
                  <input type="text" class="form-control" readonly="true" id="evento" name="evento" value="<?php echo $servicos->getEvento();?>">
                </div>
                <div class="form-group">
                    <label for="tarefa_redmine">N&uacute;mero Tarefa Redmine</label>    
                    <div class="input-group">
                        <input type="text" class="form-control" id="tarefa_redmine" name="tarefa_redmine" value="<?php                         
                        $tarefa = $servicos->getTarefaRedmine(); 
                        echo $tarefa->getNumTarefa();
                        ?>">
                        <div class="input-group-btn">
                            <a type="button" class="btn btn-primary" <?php if ( $tarefa->getNumTarefa() != "" ) { echo "href='http://redmine.seed.se.gov.br/redmine/issues/". $tarefa->getNumTarefa()."'";}?>  target="_blank" ><span class="glyphicon glyphicon-list"></span></a>
                        </div>
                    </div>  
                </div>
                <div class="form-group">
                    <label for="situacao_evento">Situa&ccedil;&atilde;o Evento</label>
                    <input type="text" class="form-control" readonly="true" id="situacao_evento" name="situacao_evento" value="<?php echo $servicos->getSituacaoEvento();?>">
                </div>  
                <div class="form-group">
                    <label for="desc_res">Descri&ccedil;&atilde;o Resumida</label>
                    <input type="text" class="form-control" readonly="true" id="desc_res" name="desc_res" value="<?php echo $servicos->getDescRes();?>">
                </div>
                <div class="form-group">
                  <label for="desc_comp">Descri&ccedil;&atilde;o Detalhada</label>
                  <input type="text" class="form-control" readonly="true" id="desc_comp" name="desc_comp" value="<?php echo $servicos->getDescComp();?>">
                </div>                
                <div class="form-group">
                  <label for="inicio_evento">Data Inicio Evento</label>
                  <input type="text" class="form-control" readonly="true" id="inicio_evento" name="inicio_evento" value="<?php echo $servicos->formataDataBR($servicos->getInicioEvento());?>">
                </div>  
                <div class="form-group">
                  <label for="fim_evento">Data Fim Evento</label>
                  <input type="text" class="form-control" readonly="true" id="fim_evento" name="fim_evento" value="<?php echo $servicos->formataDataBR($servicos->getFimEvento());?>">
                </div>                
                <div class="text-center col-xs-12">
                    <a type="button" class="btn btn-danger" href="calendario.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                    
                    <button type="submit" <?php if ($servicos->getCodSitEvento() == '99' && $servicos->getLimiteFim() > date('Y-m-d') ){ echo 'disabled="';}?>  class="btn btn-success">Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>                  
                </div>
               </div>
            </div>  
        </form>  
    </div>
    </div>
<?php
include ("../class/footer.php");
