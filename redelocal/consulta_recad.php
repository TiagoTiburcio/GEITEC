<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('4', '0') == 1) {
    $servidores = new Servidores();
    $cpf = filter_input(INPUT_POST, 'cpf');
    $nome = filter_input(INPUT_POST, 'nome');
    $result = $servidores->listaRecadastramento($cpf, $nome);
    $result2 = $servidores->listaServidores('', $nome, '', '', $cpf);
    ?>
    <div class="col-xs-12">
        <form class="form-inline" method="post" action="">
            <div class="form-group">
                <div class="col-xs-12">                                  
                    <div class="form-group">                
                        <label for="cpf">CPF</label>
                        <input type="text" class="simple-field-data-mask-selectonfocus form-control" data-mask="000.000.000-00" data-mask-selectonfocus="true" id="cpf" name="cpf" value="<?php echo $cpf; ?>">
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
    </div>  
    </form>

    </div>
    <div class="col-xs-12">
         <h3>Consulta Base Recadastramento</h3>
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Cod. Recad</th>
                    <th>Nome Servidor</th>                        
                    <th>CPF</th>
                    <th>Situacao Recad</th>
                </tr>
            </thead>
            <tbody> 
                <?php while ($consulta = pg_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $consulta['cd_servidor_pk']; ?></td>                   
                        <td><?php echo $consulta['nm_servidor']; ?></td>                   
                        <td><?php echo $consulta['nr_cpf']; ?></td>                   
                        <td><?php if($consulta['dt_ultima_validacao'] == ''){ echo $rotina->imprimiAtivo('0'); } else { echo $rotina->imprimiAtivo('1'); } ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-xs-12">
        <h3>Consulta Base SEEDNET</h3>
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Nome Servidor</th>  
                        <th>CPF</th>                        
                        <th>Nome Setor</th>
                        <th>Tipo Vinculo</th>
                        <th>Cargo</th>
                        <th>Situacao</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($consulta = pg_fetch_assoc($result2)) {                         
                            ?>                
                            <tr>
                                <td><?php echo $consulta["nome_servidor"]; ?></td>
                                <td><?php echo $consulta["cpf_puro"]; ?></td>                                
                                <td><?php echo $consulta["nome_setor"]; ?></td>
                                <td><?php echo $consulta["tipo_vinculo"]; ?></td>
                                <td><?php echo $consulta["cargo"]; ?></td>
                                <td><?php echo $rotina->imprimiAtivo($consulta["ativo"]); ?></td>
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