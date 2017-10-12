<?php
    include_once '../class/usuario.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
    $usuario->iniUsuario($_GET ["usuario"]);
?>
        <div class="col-xs-12 text-center">
            <h2>Novo Usu&aacute;rio</h2>
            <h2></h2>
            <form class="form-horizontal" method="post" action="gravaeditusuario.php">
             <div class="form-group">
               <div class="col-xs-2 col-xs-offset-5">                                  
                <div class="input-group login">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control text-center" id="login" name="login" value="<?php echo $usuario->getUsuario();?>">                
                </div>
                <div class="input-group login">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control text-center" id="nome_usuario" name="nome_usuario" value="<?php echo $usuario->getNome();?>">                
                </div>
                <div class="input-group login">                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control text-center" id="pass" name="pass" value="">
                </div>                  
                  <button type="submit" class="btn btn-success">Gravar <span class="glyphicon glyphicon-save"></span></button>                  
               </div>
             </div>  
            </form>
        </div>    
<?php
    include ("../class/footer.php");

