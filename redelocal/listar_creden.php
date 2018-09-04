<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {

    $redeLocal = new RedeLocal();
   
    $tipo = filter_input(INPUT_POST,'tipo');
    $descricao = filter_input(INPUT_POST,'descricao');
    $local = filter_input(INPUT_POST,'local');
    $zbx = '2';
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                                     
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $tipo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $descricao; ?>">
                    </div>
                    <div class="form-group">
                        <label for="local">Local Alocado</label>
                        <input type="text" class="form-control" id="local" name="local" value="<?php echo $local; ?>">
                    </div>   
                    <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-2 col-xs-offset-8"> 
        <a type="button" class="btn btn-success" href="../redelocal/editcredencial.php?">Adicionar Nova Credencial <span class="glyphicon glyphicon-plus-sign"></span></a>
    </div>    
    <div class="col-xs-10">
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Usuário</th>
                    <th>Senha</th>
                    <th>Local</th>
                    <th>Manutenção</th>                
                </tr>
            </thead>
            <tbody>
    <?php
    $listaCreden = $redeLocal->listaCredenciais($tipo, $descricao, $local);
    foreach ($listaCreden as $table) {
        ?>                
                    <tr>
                        <td><?php echo $table["tipo"]; ?></td>
                        <td><?php echo $table["descricao"]; ?></td> 
                        <td><?php echo $table["usuario"]; ?></td>                      
                        <td><?php echo $table["senha"]; ?></td>                      
                        <td><?php echo $table["local_alocado"]; ?></td>
                        <td><?php echo '<a type="button" class="btn btn-primary" href="../redelocal/editcredencial.php?codigo=' . $table["codigo"] . '"><span class="glyphicon glyphicon-edit"></span></a>'; ?></td>                        
                    </tr>  
        <?php
    }
    ?>                               
            </tbody>
        </table>
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}