<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('3','17') == 1) {
    $redeLocal = new RedeLocal();
    
    $codigo = filter_input(INPUT_GET, 'codigo');
    if (!isset($codigo)) {
        $codigo = '0';
    }

    $consultaCredencial = $redeLocal->dadosCredencial($codigo);
    foreach ($consultaCredencial as $dados) {

        if ($dados['cont'] == '0') {
            $menssagem = 'Cadastre a Nova Credencial';
            $tipo = '';
            $descricao = '';
            $user = '';
            $senha = '';
            $local = '';
        } else {
            $menssagem = 'Editar Credencial';
            $tipo = $dados['tipo'];
            $descricao = $dados['descricao'];
            $user = $dados['usuario'];
            $senha =  base64_decode($dados['senha']);
            $local = $dados['local_alocado'];
        }
        $arrayTipo = array("SERVIÇO", "SERVIDOR", "EQUIPAMENTO");
        ?>                
        <div class="col-xs-offset-4 col-xs-3">
            <form class="form-horizontal" method="post" action="credencial_grava.php">
                <div class="form-group">
                    <div class="col-xs-12">
                        <h4 class="text-center"><?php echo $menssagem; ?></h4>  
                        <div class="form-group text-center">
                            <label for="codigo">Codigo Credencial</label>
                            <input type="text" class="form-control text-center" readonly="true" id="codigo" name="codigo" value="<?php echo $codigo; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo Credencial</label>
                            <select class="form-control centraltd" id="tipo" name="tipo" >
                                <?php
                                foreach ($arrayTipo as $key => $value) {
                                    if ($value == $tipo) {
                                        echo '<option value="' . $value . '" selected="" >' . $value . '</option>';
                                    } else {
                                        echo '<option value="' . $value . '">' . $value . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>  
                        <div class="form-group text-center">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control text-center" id="descricao" name="descricao" value="<?php echo $descricao; ?>">
                        </div>  
                        <div class="form-group text-center">
                            <label for="usuario">Usuário</label>
                            <input type="text" class="form-control text-center" id="usuario" name="usuario" value="<?php echo $user; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="senha">Senha</label>
                            <input type="text" class="form-control text-center" id="senha" name="senha" value="<?php echo $senha; ?>">
                        </div>
                        <div class="form-group text-center">
                            <label for="local">Local Alocação</label>
                            <input type="text" class="form-control text-center" id="local" name="local" value="<?php echo $local; ?>">
                        </div>  
                        <div class="text-center col-xs-12">
                            <a type="button" class="btn btn-danger"  href="listar_creden.php">voltar <span class="glyphicon glyphicon-backward"></span></a>
                            <button type="submit" class="btn btn-success">Gravar <span class="glyphicon glyphicon-save"></span></button>
                        </div>
                    </div>
                </div>  
            </form>  
        </div>
        </div>
        <?php
        include ("../class/footer.php");
    }
}