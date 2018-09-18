<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {

    $redeLocal = new RedeLocal();
    $busca_usuario = filter_input(INPUT_POST, 'usuario');
    $busca_conferidos = filter_input(INPUT_POST, 'conferidos');
    $atu_email = filter_input(INPUT_GET, 'email');

    if (($busca_conferidos == NULL) || ($busca_conferidos == "")) {
        $busca_conferidos = 1;
    }

    if (($atu_email != NULL) || ($atu_email != "")) {
        $r = $redeLocal->updateUsuarioLista($atu_email); 
    }

    $consulta = $redeLocal->usuariosListaExpresso($busca_usuario, $busca_conferidos);
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                
                    <div class="form-group">
                        <label for="usuario">Usuário</label>              
                        <input type="text" class="form-control" name="usuario" value="<?php echo $busca_usuario; ?>">                        
                    </div>
                    <div class="form-group">
                        <label for="conferidos">Conferidos</label><br/>
                        <div class="radio">
                            <label><input type="radio" name="conferidos" <?php
                                if ($busca_conferidos == 2) {
                                    echo 'checked=""';
                                }
                                ?> value="2">Todos</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="conferidos" <?php
                                if ($busca_conferidos == 1) {
                                    echo 'checked=""';
                                }
                                ?> value="1">Pendentes</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="conferidos" <?php
                                if ($busca_conferidos == 0) {
                                    echo 'checked=""';
                                }
                                ?> value="0">Conferidos</label>
                        </div><br/>                        
                    </div>

                    <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-10">         
        <div class="col-xs-12">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Qtd_Lista</th>                        
                        <th>lista_seed_geral</th>
                        <th>lista_seed_usuarios</th>
                        <th>lista_seed_administrativo</th>
                        <th>lista_seed_escest</th>
                        <th>Conferido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($consulta as $table) {
                        ?>                
                        <tr>
                            <td><?php echo $table["nome_usuario"]; ?></td>
                            <td><?php echo $table["email"]; ?></td> 
                            <td><?php echo $table["qtd_lista"]; ?></td>                      
                            <td><?php echo $rotina->imprimiAtivo($table["lista_seed_geral"]) ?></td>                        
                            <td><?php echo $rotina->imprimiAtivo($table["lista_seed_usuarios"]) ?></td>                        
                            <td><?php echo $rotina->imprimiAtivo($table["lista_seed_administrativo"]) ?></td>                        
                            <td><?php echo $rotina->imprimiAtivo($table["lista_seed_escest"]) ?></td>                        
                            <td><?php echo '<a type="button" class="btn btn-primary" href="listar_usuario_expresso.php?email=' . $table["email"] . '"><span class="glyphicon glyphicon-ok-sign"></span></a>'; ?></td>
                        </tr>  
                        <?php
                    }
                    ?>  
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
    </div>       
    <?php
    include ("../class/footer.php");
}