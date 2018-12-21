<?php
include_once '../class/principal.php';

$tarefas = new RotinasPublicas();

if ($tarefas->validaSessao('','21') == 1) { //Formulario nola Senha para usuários que não utilizam senha no Active Directory
    $user = new Usuario();
    $dadosUsuario = $user->iniUsuario($_SESSION['login']);
    foreach ($dadosUsuario as $table) {
        if ($table['metodo_login'] == '0') {
            $menssagem = "Usuário utilizando gerenciamento de senha via Active Directory";
        } elseif ($table['metodo_login'] == '1') {
            $menssagem = "Usuário utilizando gerenciamento de senha Local";
        } else {
            $menssagem = "";
        }
        ?>
        <div class="col-xs-12 text-center">        
            <h2><?php echo $menssagem; ?> </h2>
            <form id="renoveSenha" name="renoveSenha" onsubmit="return validaSenha();" class="form-horizontal" method="post" action="gravasenha.php">
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
                        <?php if ($table['metodo_login'] == '1') { ?>
                            <div class="input-group login">                  
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input type="password" required="true" class="form-control text-center" id="pass" name="pass" value="" placeholder="senha">
                            </div>
                            <button type="submit" class="btn btn-success">Acessar <span class="glyphicon glyphicon-ok-sign"></span></button> 
                            <?php }
                        }
                        ?>       
                </div>
            </div>  
        </form>

    </div>    
    <?php
    include ("../class/footer.php");
}