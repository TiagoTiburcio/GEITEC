<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('') == 1) {
    if (!isset($_GET ["usuario"])) {
        $_GET ["usuario"] = '';
    }

    $usuarioEdit = new Usuario();
    $usuario = new Usuario();
    $usuarioEdit->iniUsuario(filter_input(INPUT_GET,'usuario'));
    ?>
    <div class="col-xs-12 text-center">
        <h2>Manuten&ccedil;&atilde;o Usu&aacute;rio</h2>
        <h2></h2>
        <form class="form-horizontal" method="post" action="gravaeditusuario.php">
            <div class="form-group">
                <div class="col-xs-2 col-xs-offset-5">                                  
                    <div class="input-group login">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control text-center" id="login" name="login" placeholder="Login" value="<?php echo $usuarioEdit->getUsuario(); ?>">                
                    </div>
                    <div class="input-group login">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control text-center" id="nome_usuario" name="nome_usuario" placeholder="Nome Usuário"value="<?php echo $usuarioEdit->getNome(); ?>">                
                    </div>
                    <div class="input-group centraliza">
                        <label for="perfil">Perfil Usu&aacute;rio</label>
                        <select class="form-control" id="perfil" name="perfil">

                            <?php
                            $resultado_perfil = $usuario->listaPerfil();
                            foreach ($resultado_perfil as $table_perfil) {
                                if ($table_perfil["codigo"] == $usuarioEdit->getPerfil()) {
                                    ?> 
                                    <option value="<?php echo $table_perfil["codigo"]; ?>" selected><?php echo $table_perfil["descricao"]; ?></option>                    
                                    <?php
                                } else {
                                    ?> 
                                    <option value="<?php echo $table_perfil["codigo"]; ?>" ><?php echo $table_perfil["descricao"]; ?></option>                    
                                    <?php
                                }
                            }
                            ?>                                       
                        </select>
                    </div>   
                    <div class="input-group login centraliza">
                        <label for="ativo">Usuário Ativo?</label><br/>
                        <div class="radio-inline">
                            <label><input type="radio" name="ativo" <?php
                                if ($usuarioEdit->getAtivo() == 1) {
                                    echo 'checked=""';
                                }
                                ?> value="1">Sim</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="ativo" <?php
                                if ($usuarioEdit->getAtivo() == 0) {
                                    echo 'checked=""';
                                }
                                ?> value="0">Não</label>
                        </div>                    
                    </div>
                    <!--                <div class="input-group login centraliza">
                                        <label for="resetSenha">Resetar Senha Usuário?</label><br/>
                                        <div class="radio-inline">
                                            <label><input type="radio" name="resetSenha" onclick="return mostraSenha();" value="1">Sim</label>
                                        </div>
                                        <div class="radio-inline">
                                            <label><input type="radio" name="resetSenha" onclick="return escondeSenha();" checked="" value="0">Não</label>
                                        </div>                    
                                    </div>
                                    <div id="senha" name="senha" style="display: none">
                                        <div class="input-group login centraliza">
                                            <label for="altProxLogin">Alterar no Próximo Login do Usuário?</label><br/>
                                            <div class="radio-inline">
                                                <label><input type="radio" name="altProxLogin" checked="" value="1">Sim</label>
                                            </div>
                                            <div class="radio-inline">
                                                <label><input type="radio" name="altProxLogin" value="0">Não</label>
                                            </div>
                                        </div>
                                        <div class="input-group login" >                  
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                          <input type="password" class="form-control text-center" id="pass" name="pass" value="" placeholder="Nova Senha">
                                        </div>
                                        <div class="input-group login">                  
                                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                          <input type="password" class="form-control text-center" id="repass" name="repass" value="" placeholder="Repita Nova Senha">
                                        </div>
                                    </div>   -->
                    <button type="submit" class="btn btn-success">Gravar <span class="glyphicon glyphicon-save"></span></button>                  
                </div>
            </div>  
        </form>
    </div>    
    <?php
    include ("../class/footer.php");
}