<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('','16') == 1) {

    $zbxCofre = new ZabbixCofre();
    $logArquivos = new LogArquivos();

    if (filter_input(INPUT_GET, 'limpa') == NULL) {
        $_GET['limpa'] = '';
        
    } 
    if (filter_input(INPUT_GET, 'limpa') == '1') {
        
        unset($_SESSION['usuario']);
        unset($_SESSION['arquivo']);
        unset($_SESSION['inicio']);
        unset($_SESSION['fim']);
        unset($_SESSION['acao']);
    }

    if (!isset($_SESSION['usuario'])) {
        $_SESSION['usuario'] = '';
    }
    if (!isset($_SESSION['arquivo'])) {
        $_SESSION['arquivo'] = '';
    }
    if (!isset($_SESSION['inicio'])) {
        $_SESSION['inicio'] = '2010-01-01 00:00:00';
    }
    if (!isset($_SESSION['fim'])) {
        date_default_timezone_set("America/Bahia");
        $data = date('Y-m-d');
        $_SESSION['fim'] = $data . ' 23:59:59';
    }
    if (!isset($_SESSION['acao'])) {
        $_SESSION['acao'] = '';
    }
    if (filter_input(INPUT_POST, 'usuario')!== NULL) {
        $_SESSION ["usuario"] = filter_input(INPUT_POST, 'usuario');
    }
    if (filter_input(INPUT_POST, 'arquivo')!== NULL) {
        $_SESSION ["arquivo"] = filter_input(INPUT_POST, 'arquivo');
    }

    if (filter_input(INPUT_POST, 'inicio')!== NULL) {
        $_SESSION ["inicio"] = $logArquivos->convert_data_BR_US(filter_input(INPUT_POST, 'inicio'));
    }
    if (filter_input(INPUT_POST, 'fim')!== NULL) {
        $_SESSION ["fim"] = $logArquivos->convert_data_BR_US(filter_input(INPUT_POST, 'fim'));
    }
    if (filter_input(INPUT_POST, 'acao')!== NULL) {
        $_SESSION ["acao"] = filter_input(INPUT_POST, 'acao');
    }


    $busca_usuario = $_SESSION ["usuario"];
    $busca_arquivo = $_SESSION ["arquivo"];
    $busca_inicio = $_SESSION ["inicio"];
    $busca_fim = $_SESSION ["fim"];
    $busca_acao = $_SESSION ["acao"];

    $formatado_inicio = $logArquivos->convert_data_US_BR($busca_inicio);
    $formatado_fim = $logArquivos->convert_data_US_BR($busca_fim);

    $consuta_arquivos = $logArquivos->consArquivos($busca_inicio, $busca_fim, $busca_usuario, $busca_arquivo, $busca_acao);
    $lista_nomes = $logArquivos->usuariosArquivos();
    $log = array();
    ?>
    <div class="col-xs-2">                        
        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <div class="col-xs-10 col-xs-offset-2">                
                    <div class="form-group">
                        <label for="usuario">Usuário</label>              
                        <input type="text" class="form-control" list="usuarios" name="usuario" value="<?php echo $busca_usuario; ?>">
                        <datalist id="usuarios">
                            <?php
                            foreach ($lista_nomes as $nomesTable) {
                                echo '<option value="' . $nomesTable['usuario'] . '">  ';
                            }
                            ?>        
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="arquivo">Nome Arquivo ou Diretório</label>
                        <input type="text" class="form-control" id="arquivo" name="arquivo" value="<?php echo $busca_arquivo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inicio">Data / Hora - Inicio Busca </label>                
                        <input class="simple-field-data-mask-selectonfocus form-control " value="<?php echo $formatado_inicio; ?>" data-mask="00/00/0000 00:00:00" data-mask-selectonfocus="true" name="inicio" type="text" id="inicio"/> 
                    </div>
                    <div class="form-group">
                        <label for="fim">Data / Hora - Fim Busca </label>
                        <input class="simple-field-data-mask-selectonfocus form-control " value="<?php echo $formatado_fim; ?>" data-mask="00/00/0000 00:00:00" data-mask-selectonfocus="true" name="fim" type="text" id="fim"/> 
                    </div>
                    <div class="form-group">
                        <label for="acao">Tipo de Ação</label>
                        <input type="text" class="form-control" id="acao" name="acao" value="<?php echo $busca_acao; ?>">
                    </div>   
                    <a type="button" class="btn btn-danger"  href="listar_log.php?limpa=1">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                    <button type="submit" class="btn btn-primary" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                </div>
            </div>  
        </form>
    </div>
    <div class="col-xs-10">         
        <div class="col-xs-12">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Data / Hora</th>
                        <th>Usuário</th>
                        <th>Nome Arquivo ou Diretório</th>                        
                        <th>Tipo de Ação</th>
                        <th>Qtd.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($consuta_arquivos as $table_arquivo) {
                        ?>                
                        <tr>
                            <td><?php echo $table_arquivo["data_hora"]; ?></td>
                            <td><?php echo $table_arquivo["usuario"]; ?></td> 
                            <td><?php echo $table_arquivo["arquivo"]; ?></td>                      
                            <td><?php echo $table_arquivo["descricao_acao"]; ?></td>                        
                            <td><?php echo $table_arquivo["cont_arq"]; ?></td>
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
    </div>       
    <?php
    include ("../class/footer.php");
}