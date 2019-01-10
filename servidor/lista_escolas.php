<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('', '23') == 1) {

    $cpf = filter_input(INPUT_POST, 'cpf');
    $nome = filter_input(INPUT_POST, 'nome');
    $setor = filter_input(INPUT_POST, 'setor');
    $siglasetor = filter_input(INPUT_POST, 'siglasetor');
    $zbx = filter_input(INPUT_POST, 'ativo');
    if (!isset($zbx)) {
        $zbx = '2';
    }
    $escolas = new EscolasPG();
    $result = $escolas->listaEscolas('');
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                                  
                    <div class="form-group">                
                        <label for="cpf">CPF</label>
                        <input type="text" class="simple-field-data-mask-selectonfocus form-control" data-mask="000.000.000-00" data-mask-selectonfocus="true" id="cpf" name="cpf" value="<?php echo $cpf; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome Servidor</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                    </div>
                    <div class="form-group">
                        <label for="siglasetor">Sigla Setor</label>
                        <input type="text" class="form-control" id="siglasetor" name="siglasetor" value="<?php echo $siglasetor; ?>">
                    </div>   
                    <div class="form-group">
                        <label for="setor">Setor</label>
                        <input type="text" class="form-control" id="setor" name="setor" value="<?php echo $setor; ?>">
                    </div>
                    <div class="form-group">
                        <label for="ativo">Situação Vinculo</label><br/>
                        <div class="radio">
                            <label><input type="radio" name="ativo" <?php
                                if ($zbx == 2) {
                                    echo 'checked=""';
                                }
                                ?> value="2">Todos</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="ativo" <?php
                                if ($zbx == 1) {
                                    echo 'checked=""';
                                }
                                ?> value="1">Ativo</label>
                        </div><br/>
                        <div class="radio">
                            <label><input type="radio" name="ativo" <?php
                                if ($zbx == 0) {
                                    echo 'checked=""';
                                }
                                ?> value="0">Inativo</label>
                        </div><br/>                    
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
                        <th>Diretoria</th>  
                        <th>Unidade</th>                                               
                        <th>Cod. INEP</th>
                        <th>Cidade</th>                                                
                        <th>Visualizar Equipe</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($consulta = pg_fetch_assoc($result)) { //print "Saldo: ".$consulta['cdsituacao'];                        
                        ?>                
                        <tr>
                            <td><?php echo $consulta["dre"]; ?></td>
                            <td><?php echo $consulta["nome_unidade"]; ?></td>                      
                            <td><?php echo $consulta["codigo_mec"]; ?></td>
                            <td><?php echo $consulta["cidade"]; ?></td>
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
