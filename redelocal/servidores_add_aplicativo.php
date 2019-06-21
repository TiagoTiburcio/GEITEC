<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {
    $hostid = (empty(filter_input(INPUT_GET, 'hostid'))) ? '' : filter_input(INPUT_GET, 'hostid');
    if ($hostid != '') {
        $servidores = new RedeLocalServidores();
        $dados_srv = $servidores->listServidores($hostid);
        $codigo_app = (empty(filter_input(INPUT_GET, 'app'))) ? '' : filter_input(INPUT_GET, 'app');
        if ($codigo_app == ''){          
          $nome = '';
          $descricao = '';
          $tipo_app = 'Local';
        }
        foreach ($dados_srv as $value) {
            $nome_servidor =  $value['nome_servidor'];      }
        ?>
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" action="servidores_add_aplicativo_grava.php">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">               
                        <div class="form-group text-center">
                            <label for="codigo">Codigo Aplicativo</label>
                            <input type="text" class="form-control text-center" readonly="true" id="codigo" name="codigo" value="<?php echo $codigo_app; ?>">
                        </div> 
                        <div class="form-group text-center">
                            <label for="hostid">Nome Servidor</label>
                            <input type="text" class="form-control text-center" readonly="true" value="<?php echo $nome_servidor; ?>">
                            <input type="hidden" class="form-control text-center" id="hostid" name="hostid" value="<?php echo $hostid; ?>">
                        </div> 
                        <div class="form-group text-center">
                            <label for="nome">Nome</label>                            
                            <input type="text" class="form-control text-center" id="nome" name="nome" value="<?php echo $nome; ?>">
                        </div>  
                        <div class="form-group text-center">
                            <label for="descricao">Descrição Utlidade</label>
                            <input type="text" class="form-control text-center" id="descricao" name="descricao" value="<?php echo $descricao; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="tipo_app">Tipo Aplicação</label><br/>
                            <input type="radio" class="radio-inline" id="tipo_app" name="tipo_app" value="Local" <?php if($tipo_app == 'Local'){echo 'checked';}?>>Local
                            <input type="radio" class="radio-inline" id="tipo_app" name="tipo_app" value="Web" <?php if($tipo_app == 'Web'){echo 'checked';}?>>Web
                        </div>
                        <div class="form-group centraltd">
                            <a type="button" class="btn btn-danger"  href="servidores_servidor_aplicativo.php?hostid=<?php echo $hostid;?>">Voltar <span class="glyphicon glyphicon-backward"></span></a>                 
                            <button type="submit" class="btn btn-success">Salvar <span class="glyphicon glyphicon-saved"></span></button>                  
                        </div>                        
                    </div>
                </div>  
            </form>

        </div>
        <?php
    }else {
        echo 'Erro sem codigo de Servidor Atualize a pagina';
    }
}
    