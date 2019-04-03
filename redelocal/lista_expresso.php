<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();
if ($rotina->validaSessao('4', '0') == 1) {

    $redeLocal = new RedeLocal();

    $consulta = $redeLocal->listaExpresso("10");
    $totais = $redeLocal->totalConf();
    
    ?>
    <meta http-equiv="refresh" content="5" url=""/>
    <div class="col-xs-12">
        <?php 
        foreach ($totais as $tot_dados){
            echo "<h3> Total: ".$tot_dados['total']." | Conferidos: ". $tot_dados['conferidos'] ." | A Conferir: " . $tot_dados['a_conferir'] . "</h3>";
        }        
        ?>
        
    </div>
    <div class="col-xs-12">
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Data Criacao</th>                        
                    <th>Ult Acess</th>
                    <th>Dias S/ Logar</th>
                    <th>Situacao</th>
                    <th>Nome Usuario</th>                    
                    <th>Man.</th>                    
                </tr>
            </thead>
            <tbody> 
                <?php foreach ($consulta as $dados) { ?>
                    <tr>
                        <td><?php echo $dados['login']; ?></td>                   
                        <td><?php echo $dados['data_criacao']; ?></td>                   
                        <td><?php echo $dados['ult_acesso']; ?></td>                   
                        <td><?php echo $dados['dias_sem_logar']; ?></td>                   
                        <td><?php echo $dados['status']; ?></td>                   
                        <td><?php echo $dados['nome_usuario']; ?></td>
                        <td><?php echo '<a type="button" class="btn btn-primary" href="edit_usuario.php?codigo=' . $dados['id'] . '"><span class="glyphicon glyphicon-ok-sign"></span></a>'; ?></td>                   
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