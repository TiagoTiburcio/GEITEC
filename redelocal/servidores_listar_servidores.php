<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('4', '25') == 1) {
    $rede_servidores = new ServidoresRede();
    $nome = (empty(filter_input(INPUT_POST, 'nome'))) ? '' : filter_input(INPUT_POST, 'nome');
    $tipo = (empty(filter_input(INPUT_POST, 'tipo'))) ? '0' : filter_input(INPUT_POST, 'tipo');
    $sis_op = (empty(filter_input(INPUT_POST, 'so'))) ? '0' : filter_input(INPUT_POST, 'so');
    $tipo_amb = (empty(filter_input(INPUT_POST, 'amb'))) ? '0' : filter_input(INPUT_POST, 'amb');
    $lista_servidores = $rede_servidores->listServidores($tipo, $tipo_amb, $sis_op, $nome);
    $lista_tipos = $rede_servidores->listTiposServidores();
    $lista_sis_op = $rede_servidores->listSistemasOperacionais();
    ?>
    <div class="col-xs-12">
        <form class="form-inline" method="post" id="filtro_diretoria_circuito" name="filtro_diretoria_circuito" action="">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="form-group">                
                        <label for="prod">Produção / Homo </label>
                        <select class="form-control" id="amb" name="amb" onchange="submitFormRelPorTipo()"> 
                            <?php
                            echo '<option value="0" > Todos os S.O.</option>';
                            echo '<option value="PROD" ';
                            if ($tipo_amb == 'PROD') {
                                echo 'selected=""';
                            }
                            echo '> PROD - Servidor Produção</option>';
                            echo '<option value="HOMO"';
                            if ($tipo_amb == 'HOMO') {
                                echo ' selected="" ';
                            }
                            echo '> HOMO - Servidor Homologação</option>';
                            ?>
                        </select>    
                    </div>
                    <div class="form-group">                
                        <label for="tipo">Tipo Servidor</label>
                        <select class="form-control" id="tipo" name="tipo" onchange="submitFormRelPorTipo()"> 
                            <option value="0" > Todos os Tipos</option>
                            <?php
                            foreach ($lista_tipos as $value) {
                                echo '<option value="' . $value['type'] . '" ';
                                if ($value['type'] == $tipo) {
                                    echo 'selected=""';
                                }
                                echo ' >' . $value['type'] . ' - ' . $value['type_full'] . '</option>';
                            }
                            ?>
                        </select>    
                    </div>
                    <div class="form-group">                
                        <label for="so">Sistema Operacional</label>
                        <select class="form-control" id="so" name="so" onchange="submitFormRelPorTipo()"> 
                            <option value="0" > Todos os S.O.</option>
                            <?php
                            foreach ($lista_sis_op as $value) {
                                echo '<option value="' . $value['os_short'] . '" ';
                                if ($value['os_short'] == $sis_op) {
                                    echo 'selected=""';
                                }
                                echo ' >' . $value['os_short'] . ' - ' . $value['os_full'] . '</option>';
                            }
                            ?>
                        </select>    
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome Servidor</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>">
                    </div> 
                    <div class="form-group">
                        <a type="button" class="btn btn-danger"  href="">Limpar <span class="glyphicon glyphicon-erase"></span></a>                 
                        <button type="submit" class="btn btn-primary">Pesquisar <span class="glyphicon glyphicon-search"></span></button>                  
                    </div>
                </div>
            </div>
        </form>
    </div>  
    <div class="col-xs-12">
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Ambiente</th>  
                    <th>Tipo</th>                        
                    <th>Nome Servidor</th>
                    <th>Função</th>
                    <th>Sistema Op.</th>
                    <th>Ativo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista_servidores as $value) {
                    ?>                
                    <tr>
                        <td><?php echo $value['tag']; ?></td>
                        <td><?php echo $value['type']; ?></td>
                        <td><?php echo $value['host']; ?></td>
                        <td><?php echo $value['description']; ?></td>                                
                        <td><?php echo $value['os_short']; ?></td>  
                        <td><?php echo $rotina->imprimiInverso($value['status']); ?></td>
                    </tr>  
                    <?php
                }
                ?>                                          
            </tbody>
        </table>
    </div>
    </div>    

    <?php
}