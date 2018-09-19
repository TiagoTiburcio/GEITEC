<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {
    $atu_email = filter_input(INPUT_GET, 'email');
    $redeLocal = new RedeLocal();
    $consulta = $redeLocal->consultaPendenciaLista($atu_email);
    $resolvida = "0";
    $descricao = "";

    foreach ($consulta as $table) {
        $descricao = $table['descricao'];
        $resolvida = $table['resolvido'];
    }
    ?>
    <div class="col-xs-12">                        
        <form class="form-horizontal" method="post" action="listar_usuario_expresso.php">
            <div class="form-group">
                <div class="col-xs-6 col-xs-offset-3">                
                    <div class="form-group">
                        <label for="emailup">Email</label>              
                        <input type="text" class="form-control" readonly="" name="emailup" id="emailup" value="<?php echo $atu_email; ?>">                        
                    </div>
                    <div class="form-group">
                        <label for="pendup">Descrição Pendência</label> 
                        <textarea name="pendup" id="pendup" required="true" class="form-control"><?php echo $descricao; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="resolvido">Descrição Pendência</label><br/>                        
                        <input type="radio" name="resolvido" id="resolvido" <?php
                        if ($resolvida == 1) {
                            echo 'checked=""';
                        }
                        ?> value="1">Resolvida <br/>
                        <input type="radio" name="resolvido" id="resolvido"  <?php
                        if ($resolvida == 0) {
                            echo 'checked=""';
                        }
                        ?> value="0">Em aberto <br/>
                    </div>
                    <div class="form-group centraltd" >
                        <a type="button" class="btn btn-danger"  href="listar_usuario_expresso.php">Cancelar <span class="glyphicon glyphicon-backward"></span></a>                 
                        <button type="submit" class="btn btn-success" >Salvar <span class="glyphicon glyphicon-floppy-disk"></span></button>
                    </div>
                </div>
            </div>  
        </form>
    </div>
    </div>       
    <?php
    include ("../class/footer.php");
}