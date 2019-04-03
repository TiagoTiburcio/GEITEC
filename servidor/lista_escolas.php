<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('', '23') == 1) {

    $nome = filter_input(INPUT_POST, 'nome');
    $diretoria = filter_input(INPUT_POST, 'dre');
    $inep = filter_input(INPUT_POST, 'inep');
    $cidade = filter_input(INPUT_POST, 'cidade');

    $escolas = new EscolasPG();
    $result = $escolas->listaEscolas($inep, $diretoria, $nome,$cidade);
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">
                    <div class="form-group">
                        <label for="dre">DRE</label>
                        <input type="text" class="form-control" id="dre" name="dre" value="<?php echo $diretoria; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome Unidade</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inep">Codigo Mec</label>
                        <input type="text" class="form-control" id="inep" name="inep" value="<?php echo $inep; ?>">
                    </div>
                    <div class="form-group">
                        <label for="cidade">Cidade Unidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $cidade; ?>">
                    </div>
                    <div class="form-group">
                        <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                        <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-xs-10">
        <div class="col-xs-12">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Diretoria</th>  
                        <th>Cidade</th>                                
                        <th>Unidade</th>                                               
                        <th>Cod. INEP</th>                                        
                        <th>Visualizar Equipe</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($consulta = pg_fetch_assoc($result)) { //print "Saldo: ".$consulta['cdsituacao'];                        
                        ?>                
                        <tr>
                            <td><?php echo $consulta["dre"]; ?></td>
                            <td><?php echo $consulta["cidade"]; ?></td>
                            <td><?php echo $consulta["nome_unidade"]; ?></td>                      
                            <td><?php echo $consulta["codigo_mec"]; ?></td>                            
                            <td><?php echo '<a type="button" class="btn btn-default" href="../servidor/equipe_escola.php?codigo=' . $consulta["cdestrutura"] . '"><span class="glyphicon glyphicon-eye-open"></span></span></a>'; ?></td>                                
                        </tr>  
                        <?php
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="../js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="../js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="../js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.test.js"></script>
    <?php
    include ("../class/footer.php");
}    
