<?php
    include_once '../class/usuario.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
    
    $nome	= $_POST ["nome"];	
    $id         = $_POST ["id"];
    $login      = $_POST ["login"];
?>
        <div class="col-xs-2">                        
            <form class="form-horizontal" method="post" action="">
             <div class="form-group">
               <div class="col-xs-10 col-xs-offset-2">
                <div class="form-group">
                  <label for="id">Codigo</label>
                  <input type="text" class="form-control" id="id" name="id" value="<?php echo $id;?>">
                </div>
                <div class="form-group">
                  <label for="login">Usu&aacute;rio</label>
                  <input type="text" class="form-control" id="login" name="login" value="<?php echo $login;?>">
                </div>
                <div class="form-group">
                    <label for="nome">Nome Usu&aacute;rio</label>
                  <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome;?>">
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
                        <th>ID</th>
                        <th>Login Usu&aacute;rio</th>
                        <th>Nome Usu&aacute;rio</th>                        
                        <th>Ativo</th>
                        <th>Perfil Usu&aacute;rio</th>
                        <th>Manut. Usu&aacute;rio</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $usarios = $usuario->listaUsuarios();
                            foreach ($usarios as $table_usuario){                                
                        ?>                
                    <tr>
                        <td><?php echo $table_usuario["id"]; ?></td>
                        <td><?php echo $table_usuario["usuario"]; ?></td> 
                        <td><?php echo $table_usuario["nome_usuario"]; ?></td>                      
                        <td><?php echo $table_usuario["ativo"]; ?></td>
                        <td><?php echo $table_usuario["perfil"]; ?></td>
                        <td><?php echo '<a type="button" class="btn btn-primary" target="_blank" href="../home/editusuario.php?usuario='.$table_usuario["usuario"].'"><span class="glyphicon glyphicon-edit"></span></a>';?></td>                        
                    </tr>  
                        <?php
                                }
                        ?>                                          
                    </tbody>
                </table>
            </div>
           </div>
        </div>
    <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/jquery.mask.test.js"></script>
<?php 
    include ("../class/footer.php");

