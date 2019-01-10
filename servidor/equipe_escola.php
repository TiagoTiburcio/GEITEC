<?php
include_once '../class/principal.php';

$rotina = new RotinasPublicas();

if ($rotina->validaSessao('', '23') == 1) {

    $escolas = new EscolasPG();
    $codigo = filter_input(INPUT_GET, 'codigo');
    $nome = filter_input(INPUT_GET, 'nome');
    $connect = odbc_connect('conexao', 'educacional', 'educacional');
    $sql = "select ed.COD_LOCAL, ed.COD_PORTARIA, ed.ANO_PORTARIA, ed.RG, ed.COD_TIPO_PORTARIA, ed.DATA_ASSINATURA  AS DATA_ASSINATURA , ed.DATA_VIGENCIA_INICIO as DATA_VIGENCIA_INICIO, ed.DATA_VIGENCIA_FIM as DATA_VIGENCIA_FIM, ed.NOME_SERVIDOR, ed.CPF, (case when ed.cod_tipo_portaria in ('1041','1202', '2036') then 'Secretário(a)' when ed.cod_tipo_portaria in ('1050','1048','2018','1204', '2031') then 'Diretor(a)' when ed.cod_tipo_portaria in ('1055','1053','1200','2034') then 'Coordenador(a)' end) as cargo from drh_portarias.dbo.Equipe_Diretiva ed join drh_portarias.dbo.Portaria p on ed.Cod_Portaria = p.Cod_Portaria and ed.ANO_PORTARIA=p.ANO_PORTARIA where servidor_ativo='S' and p.secretario_assinou = 'S' and ed.COD_LOCAL = '$codigo' order by ed.COD_PORTARIA desc";
    $rs = odbc_exec($connect, $sql);
    ?>

    <div class="col-lg-12">
        <div class="col-lg-12">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Cargo</th> 
                        <th>Nome Servidor</th>  
                        <th>CPF</th>                                               
                        <th>Cod. Port.</th>
                        <th>Ano Port.</th>                         
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while (odbc_fetch_row($rs)) {
                        ?>                
                        <tr>
                            <td><?php echo odbc_result($rs, "cargo"); ?></td>
                            <td><?php echo odbc_result($rs, "nome_servidor"); ?></td>
                            <td><?php echo odbc_result($rs, "cpf"); ?></td>
                            <td><?php echo odbc_result($rs, "cod_portaria"); ?></td>
                            <td><?php echo odbc_result($rs, "ano_portaria"); ?></td> 
                        </tr>  
                        <?php
                    }
                    ?>                                          
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12 centraltd">                        
        <a type="button" class="btn btn-danger"  href="../servidor/lista_escolas.php">Voltar <span class="glyphicon glyphicon-backward"></span></a>                 
    </div>
    </div>
    <script type="text/javascript" src="../js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../js/qunit-1.11.0.js"></script>
    <script type="text/javascript" src="../js/sinon-1.10.3.js"></script>
    <script type="text/javascript" src="../js/sinon-qunit-1.0.0.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.test.js"></script>
    <?php
    odbc_close($connect);
    include ("../class/footer.php");
}    
