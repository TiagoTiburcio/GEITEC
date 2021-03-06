<?php
include_once '../class/principal.php';


$servico = new Servico();
$redmine = new Redmine();

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('','6') == 1) {    
    $nome = filter_input(INPUT_POST, 'nome');
    $id = filter_input (INPUT_POST, 'id');
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                    <div class="form-group">
                        <label for="id">Codigo</label>
                        <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
                    </div>                
                    <div class="form-group">
                        <label for="nome">Descrição Serviço</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                    </div>                
                    <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-10">
        <div class="col-xs-12">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descrição</th>
                        <th>Repetição</th>
                        <th>Data Ult. Realização</th>                        
                        <th>Data Próx. Realização</th>                        
                        <th>Manut. Usu&aacute;rio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servicos = $servico->listaServicos($id, $nome);
                    foreach ($servicos as $table_servicos) {
                        ?>                
                        <tr>
                            <td><?php echo $table_servicos["codigo_servico"]; ?></td>
                            <td><?php echo $table_servicos["nome_redu_servico"]; ?></td> 
                            <td><?php echo $table_servicos["repeticao"]; ?></td>                      
                            <td><?php echo $servico->formataDataBR($table_servicos["data_ult_criacao"]); ?></td>
                            <td><?php echo $servico->formataDataBR($table_servicos["data_prox_exec"]); ?></td>
                            <td><?php echo '<a type="button" class="btn btn-primary" href="../servicos/editservico.php?codigo=' . $table_servicos["codigo_servico"] . '"><span class="glyphicon glyphicon-edit"></span></a>'; ?></td>                        
                        </tr>  
                        <?php
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <?php
    include ("../class/footer.php");
}