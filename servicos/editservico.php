<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('','6') == 1) {

    
    if(filter_input(INPUT_GET, 'codigo') != ''){
        $codigo = filter_input(INPUT_GET, 'codigo');
        $menssagem = "Editar Serviço";
    } else {
        $codigo = '0';
        $menssagem = "Novo Serviço";
    }
        
    $servicos = new Servico();
    

    $servicos->iniServico($codigo);
    ?>                
    <div class="col-lg-offset-4 col-lg-3 centraltd">
        <h3><?php echo $menssagem;?></h3>
        <form class="form-horizontal" method="post" action="../servicos/editservico_grava.php">
            <div class="form-group">
                <div class="col-xs-12">                                     
                    <div class="form-group">
                        <label for="evento">ID Serviço</label>
                        <input type="text" class="form-control" readonly="true" id="servico" name="servico" value="<?php echo $servicos->getCodigo(); ?>">
                    </div>
                    <div class="form-group">
                        <label for="nome_redu">Nome Reduzido Serviço</label>    
                        <input type="text" class="form-control" id="nome_redu" name="nome_redu" value="<?php echo $servicos->getNomeRedu(); ?>">                                            
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição Serviço</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $servicos->getDescricaoComp(); ?>">
                    </div>                  
                    <div class="form-group">
                        <label for="repeticao">Repeti&ccedil;&atilde;o Evento</label>
                        <select class="form-control" id="repeticao" name="repeticao">
                            <option value="D"<?php
                            if ($servicos->getRepeticao() == "D") {
                                echo ' selected ';
                            }
                            ?> >Di&aacute;rio - D</option>                    
                            <option value="S"<?php
                            if ($servicos->getRepeticao() == "S") {
                                echo ' selected ';
                            }
                            ?> >Semanal - S</option>
                            <option value="M"<?php
                            if ($servicos->getRepeticao() == "M") {
                                echo ' selected ';
                            }
                            ?> >Mensal - M</option>
                            <option value="T"<?php
                            if ($servicos->getRepeticao() == "T") {
                                echo ' selected ';
                            }
                            ?> >Trimestral - T</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data_prox">Data Próxima</label>
                        <input type="date" class="form-control" id="data_prox" name="data_prox" value="<?php echo $servicos->getDataProxExec(); ?>">
                    </div>                
                    <div class="form-group">
                        <label for="data_ant">Data Anterior</label>
                        <input type="date" class="form-control" readonly="true" id="data_ant" name="data_ant" value="<?php echo $servicos->getDataUltExec(); ?>">
                    </div>                  
                    <div class="text-center col-xs-12">
                        <a type="button" class="btn btn-danger" href="servicos.php">voltar <span class="glyphicon glyphicon-backward"></span></a>                    
                        <button type="submit" class="btn btn-success">Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>                  
                    </div>
                </div>
            </div>  
        </form>  
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}