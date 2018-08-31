<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('') == 1) {
    ?>
    <div class="col-xs-12 text-center">
        <form id="renoveSenha" name="renoveSenha" onsubmit="return validaSenha();" class="form-horizontal" method="post" action="index.php">
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-5">                                  
                    <div class="input-group login">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control text-center" id="login" name="login" value="<?php echo $_SESSION['login']; ?>" readonly="">                
                    </div>
                    <div class="input-group login">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control text-center" id="nome_usuario" name="nome_usuario" value="<?php echo $_SESSION['nome_usuario']; ?>" readonly="">                
                    </div>               
                    <button type="submit" class="btn btn-success">Acessar <span class="glyphicon glyphicon-ok-sign"></span></button>                  
                </div>
            </div>  
        </form>
    </div>    
    <?php
    include ("../class/footer.php");
}