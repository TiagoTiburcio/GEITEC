<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('','22') == 1) {

    $perfil = new Perfil();   
    $nome = filter_input(INPUT_POST,'nome');
    $id = filter_input(INPUT_POST,'id');   
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
                        <label for="nome">Nome Usu&aacute;rio</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                    </div>                
                    <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-10">
         <div class="col-xs-2 col-xs-offset-8"> 
             <a type="button" class="btn btn-success" href="../home/editperfil.php?">Adicionar Novo Perfil <span class="glyphicon glyphicon-plus-sign"></span></a>
    </div> 
        <div class="col-xs-12">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Codigo</th>                        
                        <th>Nome Perfil</th>                        
                        <th>Ativo</th>                        
                        <th>Manut. Usu&aacute;rio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $perfis = $perfil->listaPerfis($id, $nome);
                    foreach ($perfis as $table) {
                        ?>                
                        <tr>
                            <td><?php echo $table["codigo"]; ?></td>
                            <td><?php echo $table["descricao"]; ?></td>                             
                            <td><?php echo $rotina->imprimiAtivo($table["ativo"]); ?></td>                            
                            <td><?php echo '<a type="button" class="btn btn-primary" href="../home/editperfil.php?codigo=' . $table["codigo"] . '"><span class="glyphicon glyphicon-edit"></span></a>'; ?></td>                        
                        </tr>  
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="../js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="../js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="../js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.test.js"></script>
    <?php
    include ("../class/footer.php");
}
