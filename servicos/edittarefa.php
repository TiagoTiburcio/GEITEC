<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {

    $servicos = new Servicos();
    $evento = filter_input(INPUT_GET, 'evento');

    if ($evento != "") {
        $teste = $servicos->iniEvento($evento);
        if ($teste == 0) {
            echo " Evento Não Cadastrado!!!!!! ";
        } else {
            $resultado = $servicos->cunsultaProxAntUlt($evento);
            foreach ($resultado as $table_servicos) {
                if (($table_servicos["id_evento"] == $table_servicos["id_ultimo_evento"]) && ($table_servicos["id_evento_anterior"] == "0")) {
                    $tarefaAntes = new Servicos();
                    $tarefaDepois = new Servicos();
                    $testeAntes = 1;
                    $testeDepois = 1;
                } elseif (($table_servicos["id_evento"] < $table_servicos["id_ultimo_evento"]) && ($table_servicos["id_evento_anterior"] == "0")) {
                    $tarefaAntes = new Servicos();
                    $tarefaDepois = new Servicos();
                    $tarefaDepois->iniEvento($table_servicos["id_prox_evento"]);
                    $testeAntes = 1;
                    $testeDepois = 0;
                } elseif (($table_servicos["id_evento"] == $table_servicos["id_ultimo_evento"]) && ($table_servicos["id_evento_anterior"] != "0")) {
                    $tarefaAntes = new Servicos();
                    $tarefaAntes->iniEvento($table_servicos["id_evento_anterior"]);
                    $tarefaDepois = new Servicos();
                    $testeAntes = 0;
                    $testeDepois = 1;
                } else {
                    $tarefaAntes = new Servicos();
                    $tarefaAntes->iniEvento($table_servicos["id_evento_anterior"]);
                    $tarefaDepois = new Servicos();
                    $tarefaDepois->iniEvento($table_servicos["id_prox_evento"]);
                    $testeAntes = 0;
                    $testeDepois = 0;
                }
            }
        }
    } else {
        
    }
    ?>  <div class="col-xs-offset-1 col-xs-2">
    <?php if ($testeAntes == 0) { ?>
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <div class="col-xs-12">                                     
                        <div class="form-group">
                            <label for="evento">ID Evento Anterior</label>
                            <input type="text" class="form-control" readonly="true" id="evento" name="evento" value="<?php echo $tarefaAntes->getEvento(); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tarefa_redmine">N&uacute;mero Tarefa Redmine</label>    
                            <div class="input-group">
                                <input type="text" class="form-control" id="tarefa_redmine" name="tarefa_redmine" readonly="true" value="<?php
                                $tarefa1 = $tarefaAntes->getTarefaRedmine();
                                echo $tarefa1->getNumTarefa();
                                ?>">
                                <div class="input-group-btn">
                                    <a type="button" class="btn btn-primary" <?php
                                    if ($tarefa1->getNumTarefa() != "") {
                                        echo "href='http://redmine.seed.se.gov.br/redmine/issues/" . $tarefa1->getNumTarefa() . "'";
                                    }
                                    ?>  target="_blank" ><span class="glyphicon glyphicon-list"></span></a>
                                </div>
                            </div>  
                        </div>
                        <?php if ($tarefa1->getNumTarefa() != "") { ?>
                            <div class="form-group centraltd">
                                <a type="button" class="btn btn-primary" <?php
                                echo "href='http://redmine.seed.se.gov.br/redmine/projects/atividades-gerais/issues/" . $tarefa1->getNumTarefa() . "/copy'";
                                ?>  target="_blank" >Copiar Dados Tarefa</a>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="situacao_evento">Situa&ccedil;&atilde;o Evento</label>
                            <input type="text" class="form-control" readonly="true" id="situacao_evento" name="situacao_evento" value="<?php echo $tarefaAntes->getSituacaoEvento(); ?>">
                        </div>  
                        <div class="form-group">
                            <label for="desc_res">Descri&ccedil;&atilde;o Resumida</label>
                            <input type="text" class="form-control" readonly="true" id="desc_res" name="desc_res" value="<?php echo $tarefaAntes->getDescRes(); ?>">
                        </div>
                        <div class="form-group">
                            <label for="desc_comp">Descri&ccedil;&atilde;o Detalhada</label>
                            <input type="text" class="form-control" readonly="true" id="desc_comp" name="desc_comp" value="<?php echo $tarefaAntes->getDescComp(); ?>">
                        </div>                
                        <div class="form-group">
                            <label for="inicio_evento">Data Inicio Evento</label>
                            <input type="text" class="form-control" readonly="true" id="inicio_evento" name="inicio_evento" value="<?php echo $tarefaAntes->formataDataBR($tarefaAntes->getInicioEvento()); ?>">
                        </div>  
                        <div class="form-group">
                            <label for="fim_evento">Data Fim Evento</label>
                            <input type="text" class="form-control" readonly="true" id="fim_evento" name="fim_evento" value="<?php echo $tarefaAntes->formataDataBR($tarefaAntes->getFimEvento()); ?>">
                        </div>                
                        <div class="text-center col-xs-12">
                            <a type="button" class="btn btn-primary" href="edittarefa.php?evento=<?php echo $tarefaAntes->getEvento(); ?>">Ir Tarefa Anterior <span class="glyphicon glyphicon-backward"></span></a>
                        </div>
                    </div>
                </div>  
            </form>
            <?php
        } elseif ($testeAntes == 1) {
            echo " Não Possui Tarefa Anterior!!! ";
        }
        ?>
    </div>                  
    <div class="col-xs-offset-1 col-xs-3">
        <form class="form-horizontal" method="post" action="../servicos/edittarefa_grava.php">
            <div class="form-group">
                <div class="col-xs-12">                                     
                    <div class="form-group">
                        <label for="evento">ID Evento</label>
                        <input type="text" class="form-control" readonly="true" id="evento" name="evento" value="<?php echo $servicos->getEvento(); ?>">
                    </div>
                    <div class="form-group">
                        <label for="tarefa_redmine">N&uacute;mero Tarefa Redmine</label>    
                        <div class="input-group">
                            <input type="text" class="form-control" id="tarefa_redmine" name="tarefa_redmine" value="<?php
                            $tarefa = $servicos->getTarefaRedmine();
                            echo $tarefa->getNumTarefa();
                            ?>">
                            <div class="input-group-btn">
                                <a type="button" class="btn btn-primary" <?php
                                if ($tarefa->getNumTarefa() != "") {
                                    echo "href='http://redmine.seed.se.gov.br/redmine/issues/" . $tarefa->getNumTarefa() . "'";
                                }
                                ?>  target="_blank" ><span class="glyphicon glyphicon-list"></span></a>
                            </div>
                        </div>  
                    </div>
                    <?php if ($tarefa->getNumTarefa() != "") { ?>
                        <div class="form-group centraltd">
                            <a type="button" class="btn btn-primary" <?php
                            echo "href='http://redmine.seed.se.gov.br/redmine/projects/atividades-gerais/issues/" . $tarefa->getNumTarefa() . "/copy'";
                            ?>  target="_blank" >Copiar Dados Tarefa</a>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="situacao_evento">Situa&ccedil;&atilde;o Evento</label>
                        <input type="text" class="form-control" readonly="true" id="situacao_evento" name="situacao_evento" value="<?php echo $servicos->getSituacaoEvento(); ?>">
                    </div>  
                    <div class="form-group">
                        <label for="desc_res">Descri&ccedil;&atilde;o Resumida</label>
                        <input type="text" class="form-control" readonly="true" id="desc_res" name="desc_res" value="<?php echo $servicos->getDescRes(); ?>">
                    </div>
                    <div class="form-group">
                        <label for="desc_comp">Descri&ccedil;&atilde;o Detalhada</label>
                        <input type="text" class="form-control" readonly="true" id="desc_comp" name="desc_comp" value="<?php echo $servicos->getDescComp(); ?>">
                    </div>                
                    <div class="form-group">
                        <label for="inicio_evento">Data Inicio Evento</label>
                        <input type="text" class="form-control" readonly="true" id="inicio_evento" name="inicio_evento" value="<?php echo $servicos->formataDataBR($servicos->getInicioEvento()); ?>">
                    </div>  
                    <div class="form-group">
                        <label for="fim_evento">Data Fim Evento</label>
                        <input type="text" class="form-control" readonly="true" id="fim_evento" name="fim_evento" value="<?php echo $servicos->formataDataBR($servicos->getFimEvento()); ?>">
                    </div>                
                    <div class="text-center col-xs-12">
                        <a type="button" class="btn btn-danger" href="calendario.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                    
                        <button type="submit" <?php
                        if ($servicos->getCodSitEvento() == '99' && $servicos->getLimiteFim() > date('Y-m-d')) {
                            echo 'disabled="';
                        }
                        ?>  class="btn btn-success">Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>                  
                    </div>
                </div>
            </div>  
        </form>  
    </div>

    <div class="col-xs-offset-1 col-xs-2">
        <?php if ($testeDepois == 0) { ?>
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <div class="col-xs-12">                                     
                        <div class="form-group">
                            <label for="evento">ID Evento Após</label>
                            <input type="text" class="form-control" readonly="true" id="evento" name="evento" value="<?php echo $tarefaDepois->getEvento(); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tarefa_redmine">N&uacute;mero Tarefa Redmine</label>    
                            <div class="input-group">
                                <input type="text" class="form-control" id="tarefa_redmine" name="tarefa_redmine" readonly="true" value="<?php
                                $tarefa2 = $tarefaDepois->getTarefaRedmine();
                                echo $tarefa2->getNumTarefa();
                                ?>">
                                <div class="input-group-btn">
                                    <a type="button" class="btn btn-primary" <?php
                                    if ($tarefa2->getNumTarefa() != "") {
                                        echo "href='http://redmine.seed.se.gov.br/redmine/issues/" . $tarefa2->getNumTarefa() . "'";
                                    }
                                    ?>  target="_blank" ><span class="glyphicon glyphicon-list"></span></a>
                                </div>
                            </div>  
                        </div>
                        <?php if ($tarefa2->getNumTarefa() != "") { ?>
                            <div class="form-group centraltd">
                                <a type="button" class="btn btn-primary" <?php
                                echo "href='http://redmine.seed.se.gov.br/redmine/projects/atividades-gerais/issues/" . $tarefa2->getNumTarefa() . "/copy'";
                                ?>  target="_blank" >Copiar Dados Tarefa</a>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="situacao_evento">Situa&ccedil;&atilde;o Evento</label>
                            <input type="text" class="form-control" readonly="true" id="situacao_evento" name="situacao_evento" value="<?php echo $tarefaDepois->getSituacaoEvento(); ?>">
                        </div>  
                        <div class="form-group">
                            <label for="desc_res">Descri&ccedil;&atilde;o Resumida</label>
                            <input type="text" class="form-control" readonly="true" id="desc_res" name="desc_res" value="<?php echo $tarefaDepois->getDescRes(); ?>">
                        </div>
                        <div class="form-group">
                            <label for="desc_comp">Descri&ccedil;&atilde;o Detalhada</label>
                            <input type="text" class="form-control" readonly="true" id="desc_comp" name="desc_comp" value="<?php echo $tarefaDepois->getDescComp(); ?>">
                        </div>                
                        <div class="form-group">
                            <label for="inicio_evento">Data Inicio Evento</label>
                            <input type="text" class="form-control" readonly="true" id="inicio_evento" name="inicio_evento" value="<?php echo $tarefaDepois->formataDataBR($tarefaDepois->getInicioEvento()); ?>">
                        </div>  
                        <div class="form-group">
                            <label for="fim_evento">Data Fim Evento</label>
                            <input type="text" class="form-control" readonly="true" id="fim_evento" name="fim_evento" value="<?php echo $tarefaDepois->formataDataBR($tarefaDepois->getFimEvento()); ?>">
                        </div>                
                        <div class="text-center col-xs-12">
                            <a type="button" class="btn btn-primary" href="edittarefa.php?evento=<?php echo $tarefaDepois->getEvento(); ?>">Ir Próxima Tarefa <span class="glyphicon glyphicon-forward"></span></a>
                        </div>
                    </div>
                </div>  
            </form>
            <?php
        } elseif ($testeDepois == 1) {
            echo ' Não Possui Tarefa Após a Atual!!! ';
        }
        ?>
    </div>             
    </div>
    <?php
    include ("../class/footer.php");
}