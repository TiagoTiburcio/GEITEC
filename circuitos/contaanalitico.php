<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('','1') == 1) {
    $circuitos = new Circuitos();
    
    $fatura = filter_input(INPUT_POST, 'fatura');
    $mescad = filter_input(INPUT_POST, 'mes');
    $forncad = filter_input(INPUT_POST, 'fornecedor');
    if (!isset($forncad)) {
        $forncad = 'OI';
    }
    ?>
    <div class="col-xs-2">
    <form class="form-horizontal" method="post" action="" id="filtro_fornecedor" name="filtro_fornecedor">
            <div class="form-group">
                <div class="col-xs-11 col-xs-offset-1">
                    <label for="fornecedor">Fornecedor</label>
                    <select class="form-control" id="fornecedor" name="fornecedor" onchange="submitFormFornecedor()">
                        <?php
                            $resultado_fornecedor = $circuitos->listaFornecedor();
                            foreach ($resultado_fornecedor as $fornecedor) {
                                if ($forncad == '') {
                                    $forncad = $fornecedor['nome_fornecedor'];
                                }
                                if ($fornecedor['nome_fornecedor'] == $forncad) {
                                    ?>
                                <option value="<?php echo $fornecedor['nome_fornecedor']; ?>" selected><?php echo $fornecedor['nome_fornecedor']; ?></option>
                            <?php
                                    } else {
                                        ?>
                                <option value="<?php echo $fornecedor['nome_fornecedor']; ?>"><?php echo $fornecedor['nome_fornecedor']; ?></option>
                        <?php
                                }
                            }
                            ?>
                    </select>
                </div>
            </div>
        </form>                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                                  
                    <div class="form-group">
                        <label for="fatura">Contrato</label>
                        <input type="text" class="form-control" id="fatura" name="fatura" value="<?php echo $fatura; ?>">
                        <input type="hidden" id="fornecedor" name="fornecedor" value="<?php echo $forncad; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mes">M&ecirc;s Conta</label>
                        <select class="form-control" id="mes" name="mes" onchange="pegaMes()">

                            <?php
                            $resultado_analitico1 = $circuitos->listaPeriodoRef($forncad);
                            foreach ($resultado_analitico1 as $mes) {
                                if ($mescad == '') {
                                    $mescad = $mes["periodo_ref"];
                                }
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
                        <div class="col-xs-6 col-xs-3" >                     
                            <br/><a id="linkprint"  type="button" class="btn btn-info" target="_blank" href="./relatorios/contas_analitico.php?periodo=<?php echo $mescad . '&fornecedor=' . $forncad; ?>">Imprimir Relatório Fatura<span class="glyphicon glyphicon-print"></span></a>    
                            <br/><a id="linkprint2"  type="button" class="btn btn-info" target="_blank" href="./relatorios/contas_localizacao.php?periodo=<?php echo $mescad . '&fornecedor=' . $forncad; ?>">Imprimir Relatório Localizacao<span class="glyphicon glyphicon-print"></span></a>    
                        </div>
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
                        <th>M&ecirc;s Conta</th>  
                        <th>Servi&ccedil;o Contrato</th>
                        <th>Numero Contrato</th>
                        <th>Tipo Unidade</th>
                        <th>Valor</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultado_analitico2 = $circuitos->listaCircuitos($mescad, $fatura, $forncad);
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