<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {

    $codigo = filter_input(INPUT_GET, 'codigo');
    if (!isset($codigo)) {
        $codigo = '0';
    }
    $redeLocal = new RedeLocal();
    $teste = $redeLocal->updateSituacaoExpresso($codigo, "2");
    $consultaExp = $redeLocal->getUsuarioExpresso($codigo);
    ?>                
    <div class="col-lg-2">
        <?php foreach ($consultaExp as $dados) {
            ?>
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">               
                        <div class="form-group text-center">
                            <label for="codigo">Codigo Credencial</label>
                            <input type="text" class="form-control text-center" readonly="true" id="codigo" name="codigo" value="<?php echo $codigo; ?>">
                        </div> 
                        <div class="form-group text-center">
                            <label for="descricao">Nome</label>
                            <input type="text" class="form-control text-center" readonly="true" id="nome" name="nome" value="<?php echo $dados['nome_usuario']; ?>">
                        </div>  
                        <div class="form-group text-center">
                            <label for="usuario">Usuário</label>
                            <input type="text" class="form-control text-center" readonly="true" id="usuario" name="usuario" value="<?php echo $dados['login']; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="senha">Data Criação</label>
                            <input type="text" class="form-control text-center" readonly="true" readonly="true" id="data_criacao" name="data_criacao" value="<?php echo $dados['data_criacao']; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="local">Ult. Acesso</label>
                            <input type="text" class="form-control text-center" readonly="true" id="ult_acesso" name="ult_acesso" value="<?php echo $dados['ult_acesso']; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="local">Dias Sem logar</label>
                            <input type="text" class="form-control text-center" readonly="true" id="dias_sem_logar" name="dias_sem_logar" value="<?php echo $dados['dias_sem_logar']; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="local">Situação</label>
                            <input type="text" class="form-control text-center" readonly="true" id="situacao" name="situacao" value="<?php echo $dados['status']; ?>">
                        </div>                    
                    </div>
                </div>  
            </form>
        <?php } ?>
    </div>
    <div class="col-lg-3">
        <?php
        foreach ($consultaExp as $dados) {
            $consultaGer = $redeLocal->getUsuarioGeral($dados['login']);
            $cpfGer = '';
            $usrRedeGer = '';
            $codRecadGer = '';
            $motDesatGer = '';
            $situacaoGer = '0';
            foreach ($consultaGer as $dadosUsr) {
                $cpfGer = $dadosUsr['cpf'];
                $usrRedeGer = $dadosUsr['usuario_rede'];
                $codRecadGer = $dadosUsr['codigo_recadastramento'];
                $situacaoGer = $dadosUsr['situacao'];
                $motDesatGer = $dadosUsr['motivo_desativar'];
            }
            ?>
        <form class="form-horizontal" method="post" action="gravaeditusuario.php">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <div class="form-group text-center">
                            <label for="codigo">Codigo</label>
                            <input type="text" readonly="true" class="form-control text-center" id="codigo" name="codigo" value="<?php echo $codigo; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="usuario_exp">Usuário</label>
                            <input type="text" class="form-control text-center" readonly="true" id="usuario_exp" name="usuario_exp" value="<?php echo $dados['login']; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="situacao">Ação Realizada</label><br/>
                            <div class="radio-inline">
                                <label><input type="radio" name="situacao" <?php
                                    if ($situacaoGer == 0) {
                                        echo 'checked=""';
                                    }
                                    ?> value="0">Ativo</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="situacao" <?php
                                    if ($situacaoGer == 1) {
                                        echo 'checked=""';
                                    }
                                    ?> value="1">Desativado</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="situacao" <?php
                                    if ($situacaoGer == 2) {
                                        echo 'checked=""';
                                    }
                                    ?> value="2">Pendente</label>
                            </div>
                        </div>                   

                        <div class="form-group text-center">
                            <label for="cpf">CPF</label>
                            <input type="text" required="true" class="form-control text-center" id="cpf" name="cpf" value="<?php echo $cpfGer; ?>">
                        </div>

                        <div class="form-group text-center">
                            <label for="usuario_rede">Usuário Rede</label>
                            <input type="text" class="form-control text-center" id="usuario_rede" name="usuario_rede" value="<?php echo $usrRedeGer; ?>">
                        </div>  
                        <div class="form-group text-center">
                            <label for="cod_recad">Codigo Recadastramento</label>
                            <input type="text" class="form-control text-center"  id="cod_recad" name="cod_recad" value="<?php echo $codRecadGer; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="mot_desat">Motivo Desativar</label>
                            <input type="text" class="form-control text-center"  id="mot_desat" name="mot_desat" value="<?php echo $motDesatGer; ?>">
                        </div>                        
                        <div class="form-group centraltd">
                            <a type="button" class="btn btn-danger"  href="gravaeditusuario.php?codigo=<?php echo $codigo; ?>">Voltar <span class="glyphicon glyphicon-backward"></span></a>                 
                            <button type="submit" class="btn btn-success">Salvar <span class="glyphicon glyphicon-saved"></span></button>                  
                        </div>
                    </div>
                </div>  
            </form>
        <?php } ?>
    </div>
    <div class="col-lg-7">
        <div class="col-lg-12">               
            <iframe src="consulta_recad.php" width="100%" height="620px" style="border: 0px;"></iframe> 
        </div>
    </div>    
    </div>
    <?php
}