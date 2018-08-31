<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('') == 1) {
    $servidores = new Servidores();

    if (!isset($_POST['cpf'])) {
        $_POST['cpf'] = '';
    }
    if (!isset($_POST['nome'])) {
        $_POST['nome'] = '';
    }
    if (!isset($_POST['setor'])) {
        $_POST['setor'] = '';
    }
    if (!isset($_POST['siglasetor'])) {
        $_POST['siglasetor'] = '';
    }
    $cpf = $_POST ["cpf"];
    $nome = $_POST ["nome"];
    $setor = $_POST ["setor"];
    $siglasetor = $_POST ["siglasetor"];
    $usuario = '';
    $situacao = '';
    $consulta_expresso = $servidores->listaExpresso($usuario, $nome, $situacao);
    $ida = '0';

    $nomeA = array();
    $cpfA = array();
    $i = 0;
    if (!@($conexao = pg_connect("host=172.25.76.67 dbname=seednet port=5432 user=usrappacademico password=12347"))) {
        print "Não foi possível estabelecer uma conexão com o banco de dados.";
    } else {
        $query = " SELECT distinct s.nome , replace(to_char(s.cpf, '000:000:000-00'), ':', '.') as cpf, vs.ativo"
                . " FROM administrativo.servidor as s join administrativo.vinculo_servidor as vs on s.cdservidor = vs.cdservidor "
                . " join administrativo.tipo_vinculo as tv on tv.cdtipo_vinculo = vs.cdtipo_vinculo "
                . " join administrativo.cargo as c on c.cdcargo = vs.cdcargo and c.cdcargo_grupo = vs.cdcargo_grupo left "
                . " join administrativo.estrutura_organizacional as e1 on vs.cdlotacao = e1.cdestrutura "
                . " left join administrativo.estrutura_organizacional as e2 on e1.cdestrutura_pai = e2.cdestrutura "
                . " left join administrativo.estrutura_organizacional as e3 on e2.cdestrutura_pai = e3.cdestrutura "
                . " left join administrativo.estrutura_organizacional as e4 on e3.cdestrutura_pai = e4.cdestrutura "
                . " where s.cpf not in (SELECT distinct s.cpf FROM administrativo.servidor as s join administrativo.vinculo_servidor as vs on s.cdservidor = vs.cdservidor join administrativo.tipo_vinculo as tv on tv.cdtipo_vinculo = vs.cdtipo_vinculo join administrativo.cargo as c on c.cdcargo = vs.cdcargo and c.cdcargo_grupo = vs.cdcargo_grupo left join administrativo.estrutura_organizacional as e1 on vs.cdlotacao = e1.cdestrutura left join administrativo.estrutura_organizacional as e2 on e1.cdestrutura_pai = e2.cdestrutura left join administrativo.estrutura_organizacional as e3 on e2.cdestrutura_pai = e3.cdestrutura left join administrativo.estrutura_organizacional as e4 on e3.cdestrutura_pai = e4.cdestrutura where vs.ativo = '1') ";


        $result = pg_query($conexao, $query);

        /* Retonar um array associativo correspondente a cada linha da tabela */
        while ($consulta = pg_fetch_assoc($result)) {
            $nomeA[$i] = $consulta['nome'];
            $cpfA[$i] = $consulta['cpf'];
            $i = $i + 1;
        }

        pg_close($conexao);
    }

//$input = preg_quote($nome, '~'); 
//$result = preg_grep('~' . $input . '~', $nomeA);
//foreach ($result as $key => $value) {
//    echo $key.' !!! '.$value. '!! '. $cpfA[$key].'<br/>';    
//}
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
                        <th>CPF</th>  
                        <th>Nome Servidor</th>
                        <th>Usuário Expresso</th>                       
                        <th>Vinculo</th>                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($consulta_expresso as $table_expresso) {

                        $input = preg_quote(strtoupper($table_expresso['nome']), '~');
                        $result = preg_grep('~' . $input . '~', $nomeA);
                        foreach ($result as $key => $value) {
                            // echo $key.' !!! '.$value. '!! '. $cpfA[$key].' !!!!! '.$table_expresso['login']. '!!!!!'. $table_expresso['nome'] . '<br/>';    
                            ?>                    
                            <tr>
                                <td><?php echo $cpfA[$key]; ?></td>
                                <td><?php echo $value; ?></td>
                                <td><?php echo $table_expresso['login']; ?></td>                        
                                <td><?php echo "Servidor"; ?></td>                        
                            </tr>  
            <?php
        }
    }
    ?>                                          
                </tbody>
            </table>                         
        </div>
    </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/jquery.mask.test.js"></script>
    <?php
    include ("../class/footer.php");
}    