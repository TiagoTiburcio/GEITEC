<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('') == 1) {

    $circuitos = new Circuitos();
    if (!isset($_POST['fatura'])) {
        $_POST['fatura'] = '';
    }
    if (!isset($_POST['mes'])) {
        $_POST['mes'] = '';
    }
    $fatura = $_POST ["fatura"];
    $mescad = $_POST ["mes"];
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                                  
                    <div class="form-group">
                        <label for="fatura">Contrato</label>
                        <input type="text" class="form-control" id="fatura" name="fatura" value="<?php echo $fatura; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mes">M&ecirc;s Cobran&ccedil;a</label>
                        <select class="form-control" id="mes" name="mes">

                            <?php
                            $resultado_analitico1 = $circuitos->listaPeriodoRef();
                            foreach ($resultado_analitico1 as $mes) {
                                if ($mes["periodo_ref"] == $mescad) {
                                    ?> 
                                    <option value="<?php echo $mes["periodo_ref"]; ?>" selected><?php echo $mes["mes"]; ?></option>                    
                                    <?php
                                } else {
                                    ?> 
                                    <option value="<?php echo $mes["periodo_ref"]; ?>" ><?php echo $mes["mes"]; ?></option>                    
                                    <?php
                                }
                            }
                            ?>                                       
                        </select>
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
                        <th>M&ecirc;s Referencia</th>  
                        <th>Servi&ccedil;o Contrato</th>
                        <th>Numero Contrato</th>
                        <th>Tipo Unidade</th>
                        <th>Valor</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultado_analitico2 = $circuitos->listaCircuitos($mescad, $fatura);
                    foreach ($resultado_analitico2 as $table) {
                        ?>                
                        <tr>
                            <td><?php echo $table["mes"]; ?></td>
                            <td><?php echo $table["descricao_servico"]; ?></td>
                            <td><?php echo $table["fatura"]; ?></td>
                            <td><?php echo $table["descricao"]; ?></td>
                            <td><?php echo $table["valor"]; ?></td>                        
                        </tr>  
        <?php
    }
    ?>                                          
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <?php
    include ("../class/footer.php");
}