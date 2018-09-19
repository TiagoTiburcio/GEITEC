<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {
    
    $redeLocal = new RedeLocal();
    
    if (filter_input(INPUT_GET,'limpa') == '') {
        $_GET['limpa'] = '';
    } elseif (filter_input(INPUT_GET,'limpa') == '1') {
        unset($_SESSION['usr_lst_exp']);
        unset($_SESSION['conf_lst_exp']);       
    }

    if (!isset($_SESSION['conf_lst_exp'])) {
        $_SESSION['conf_lst_exp'] = '';
    }
    if (!isset($_SESSION['usr_lst_exp'])) {
        $_SESSION['usr_lst_exp'] = '';
    }
    if (filter_input(INPUT_POST, 'usuario') != ''){
        $_SESSION['usr_lst_exp'] = filter_input(INPUT_POST, 'usuario');
    }
    if (filter_input(INPUT_POST, 'conferidos') != ''){
        $_SESSION['conf_lst_exp'] = filter_input(INPUT_POST, 'conferidos');
    }
    $busca_usuario = $_SESSION['usr_lst_exp'];
    $busca_conferidos = $_SESSION['conf_lst_exp'];
    $atu_email = filter_input(INPUT_GET, 'email');

    $update_email = filter_input(INPUT_POST, 'emailup');
    $update_pendencia = filter_input(INPUT_POST, 'pendup');
    $update_resolvido = filter_input(INPUT_POST, 'resolvido');

    if (($busca_conferidos == NULL) || ($busca_conferidos == "")) {
        $busca_conferidos = 1;
    }

    if (($atu_email != NULL) || ($atu_email != "")) {
        $redeLocal->updateUsuarioLista($atu_email);
    }

    if ((($update_email != NULL) || ($update_email != "")) && (($update_pendencia != NULL) || ($update_pendencia != ""))) {
        $redeLocal->updateUsuarioLista($update_email);
        $redeLocal->gravaPendencia($update_email, $update_pendencia, $update_resolvido);
    }

    $consulta = $redeLocal->usuariosListaExpresso($busca_usuario, $busca_conferidos);
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                
                    <div class="form-group">
                        <label for="usuario">Email</label>              
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
                                ?> value="0">Todos Já Conferidos</label>
                        </div><br/>                        
                        <div class="radio">
                            <label><input type="radio" name="conferidos" <?php
                                if ($busca_conferidos == 3) {
                                    echo 'checked=""';
                                }
                                ?> value="3">Conferidos com Pendência</label>
                        </div><br/>                        
                        <div class="radio">
                            <label><input type="radio" name="conferidos" <?php
                                if ($busca_conferidos == 4) {
                                    echo 'checked=""';
                                }
                                ?> value="4">Conferidos sem Pendência</label>
                        </div><br/>                        
                    </div>

                    <a type="button" class="btn btn-danger"  href="listar_usuario_expresso.php?limpa=1">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
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
                        <th>Email</th>
                        <th>Nome</th>                        
                        <th>Qtd_Lista</th>                        
                        <th>Geral</th>
                        <th>Usuarios</th>
                        <th>Admin.</th>
                        <th>Escolas</th>
                        <th>Pendencia</th>
                        <th>Conferido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($consulta as $table) {
                        if ($table["conferido"] == "") {
                            echo '<tr>';
                        } else {
                            if ($table["descricao"] == "") {
                                echo '<tr class="success">';
                            } else {
                                if ($table["resolvido"] == "0") {
                                    echo '<tr class="danger">';
                                } else {
                                    echo '<tr class="success">';
                                }
                            }
                        }
                        ?>               
                    <td><?php echo $table["email"]; ?></td> 
                    <td><?php echo $table["nome_usuario"]; ?></td>
                    <td><?php echo $table["qtd_lista"]; ?></td>                      
                    <td><?php echo $rotina->imprimiAtivo($table["lista_seed_geral"]) ?></td>                        
                    <td><?php echo $rotina->imprimiAtivo($table["lista_seed_usuarios"]) ?></td>                        
                    <td><?php echo $rotina->imprimiAtivo($table["lista_seed_administrativo"]) ?></td>                        
                    <td><?php echo $rotina->imprimiAtivo($table["lista_seed_escest"]) ?></td> 
                    <td><?php echo '<a type="button" class="btn btn-warning" href="pendencia_expresso.php?email=' . $table["email"] . '"><span class="glyphicon glyphicon-warning-sign"></span></a>'; ?></td>
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