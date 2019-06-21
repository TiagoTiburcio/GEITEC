<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('4', '0') == 1) {
    $hostid = (empty(filter_input(INPUT_GET, 'hostid'))) ? '' : filter_input(INPUT_GET, 'hostid');
    if ($hostid != '') {
        $servidores = new RedeLocalServidores();
        $dados_app = $servidores->listAplicativos($hostid);
        ?>
        <div class="col-lg-12">
            <a type="button" class="btn btn-success" href="servidores_add_aplicativo.php?hostid=<?php echo $hostid; ?>">Adicionar Nova Aplicação <span class="glyphicon glyphicon-plus"></span></a>
            <a type="button" class="btn btn-success" href="servidores_add_banco.php?hostid=<?php echo $hostid; ?>">Adicionar Nova Base de Dados <span class="glyphicon glyphicon-plus"></span></a>
            <h2>Dados Aplicativos Servidor</h2>          
            <label for="graficos">Aplicativos Servidor</label>
            <table class="table table-hover table-striped table-condensed" name="graficos" id="graficos">
                <thead>
                    <tr>
                        <th>Nome App</th>  
                        <th>Tipo App</th> 
                        <th>Nome BD</th> 
                        <th>Tipo Banco Dados</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dados_app as $value) {
                        ?>                
                        <tr>
                            <td><?php echo $value['nome_app']; ?></td>
                            <td><?php echo $value['tipo_app']; ?></td>                                
                            <td><?php echo $value['nome_bd']; ?></td>                                
                            <td><?php echo $value['tipo_banco_dados']; ?></td>                                
                        </tr>  
                        <?php
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo 'Erro sem codigo de Servidor Atualize a pagina';
    }
}
    