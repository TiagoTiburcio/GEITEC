<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {

    $servicos = new Servicos();
    $tarefa_redmine = filter_input(INPUT_POST,'tarefa_redmine');
    $evento = filter_input(INPUT_POST,'evento');
    if ($tarefa_redmine != "" && $evento != "") {
        if ($servicos->iniEvento($evento) == "1") {
            $servicos->setTarefaRedmine($tarefa_redmine);
            $servicos->atualizaTarefaRedimine();
            if ($servicos->atualizaEventoBD() == '0') {
                $menssagem = "Tarefa Não gravada. <br/> Fora do prazo  predefinido de Execuçao do Serviço!!!";
            } else {
                $menssagem = "";
            }
        }
    } else {
        header("Location: calendario.php");
    }
    ?>                
    <div class="col-xs-offset-4 col-xs-3">
        <form class="form-horizontal" method="get" action="edittarefa.php">
            <div class="form-group">
                <div class="col-xs-12">
                    <h4 class="text-center"><?php echo $menssagem; ?></h4>  
                    <div class="form-group">
                        <label for="evento">ID Evento</label>
                        <input type="text" class="form-control" readonly="true" id="evento" name="evento" value="<?php echo $servicos->getEvento(); ?>">
                    </div>
                    <div class="form-group">
                        <label for="tarefa_redmine">N&uacute;mero Tarefa Redmine</label>                    
                        <div class="input-group">
                            <input type="text" class="form-control" id="tarefa_redmine" readonly="true"  disabled="true" name="tarefa_redmine" value="<?php echo $servicos->getTarefaRedmine()->getNumTarefa(); ?>">
                            <div class="input-group-btn">
                                <a type="button" class="btn btn-primary" <?php
                                if ($servicos->getTarefaRedmine()->getNumTarefa() != "") {
                                    echo "href='http://redmine.seed.se.gov.br/redmine/issues/" . $servicos->getTarefaRedmine()->getNumTarefa() . "'";
                                }
                                ?>  target="_blank" ><span class="glyphicon glyphicon-list"></span></a>
                            </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="situacao_evento">Situa&ccedil;&atilde;o Evento</label>
                        <input type="text" class="form-control" readonly="true" disabled="true" id="situacao_evento" name="" value="<?php echo $servicos->getSituacaoEvento(); ?>">
                    </div>  
                    <div class="form-group">
                        <label for="desc_res">Descri&ccedil;&atilde;o Resumida</label>
                        <input type="text" class="form-control" readonly="true"  disabled="true" id="desc_res" name="desc_res" value="<?php echo $servicos->getDescRes(); ?>">
                    </div>
                    <div class="form-group">
                        <label for="desc_comp">Descri&ccedil;&atilde;o Detalhada</label>
                        <input type="text" class="form-control" readonly="true"  disabled="true" id="desc_comp" name="desc_comp" value="<?php echo $servicos->getDescComp(); ?>">
                    </div>                
                    <div class="form-group">
                        <label for="inicio_evento">Data Inicio Evento</label>
                        <input type="text" class="form-control" readonly="true"  disabled="true" id="inicio_evento" name="inicio_evento" value="<?php echo $servicos->formataDataBR($servicos->getTarefaRedmine()->getIniTarefa()); ?>">
                    </div>  
                    <div class="form-group">
                        <label for="fim_evento">Data Fim Evento</label>
                        <input type="text" class="form-control" readonly="true"  disabled="true" id="fim_evento" name="fim_evento" value="<?php echo $servicos->formataDataBR($servicos->getTarefaRedmine()->getFimTarefa()); ?>">
                    </div>
                    <div class="form-group">                   
                        <input type="hidden" class="form-control" id="status_tarefa_redmine"  disabled="true" name="status_tarefa_redmine" value="<?php echo $servicos->getTarefaRedmine()->getSitTarefa(); ?>">
                    </div>    
                    <div class="text-center col-xs-12">
                        <button type="submit" class="btn btn-primary">Voltar Edição <span class="glyphicon glyphicon-backward"></span></button>   
                        <a type="button" class="btn btn-primary"  href="calendario.php">Ir Calendário <span class="glyphicon glyphicon-forward"></span></a>
                    </div>
                </div>
            </div>  
        </form>  
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}