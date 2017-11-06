<?php
    include_once '../class/principal.php';
    
    $usuario = new Usuario();
    
    $usuario->validaSessao();
?>
        <div class="col-xs-12 text-center">
            <form id="renoveSenha" name="renoveSenha" onsubmit="return validaSenha();" class="form-horizontal" method="post" action="gravasenha.php">
             <div class="form-group">
               <div class="col-xs-2 col-xs-offset-5">                                  
                <div class="input-group login">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control text-center" id="login" name="login" value="<?php echo $_SESSION['login'];?>" readonly="">                
                </div>
                <div class="input-group login">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control text-center" id="nome_usuario" name="nome_usuario" value="<?php echo $_SESSION['nome_usuario'];?>">                
                </div>
                <div class="input-group login">                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control text-center" id="pass" name="pass" value="" placeholder="Nova Senha">
                </div>
                <div class="input-group login">                  
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control text-center" id="repass" name="repass" value="" placeholder=" Repita Nova Senha">
                </div>    
                  <button type="submit" class="btn btn-success">Acessar <span class="glyphicon glyphicon-ok-sign"></span></button>                  
               </div>
             </div>  
            </form>
        </div>    
<?php
    include ("../class/footer.php");